<?php

namespace frontend\controllers;

use common\models\Patient;
use common\models\TestsType;
use Yii;
use common\models\Reports;
use common\models\ReportsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\PatientTests;
use common\models\PatientTestsSearch;
use mPDF;
use common\components\Globals;
use yii\filters\AccessControl;
use common\components\AccessRule;

/**
 * ReportsController implements the CRUD actions for Reports model.
 */
class ReportsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                // We will override the default rule config with the new AccessRule class
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => [
                            Yii::$app->params['user.userTypeOperator'],
                        ],
                    ],
                    [
                        'actions' => ['index', 'view', 'download-report', 'mail-report'],
                        'allow' => true,
                        'roles' => [
                            Yii::$app->params['user.userTypePatient'],
                            Yii::$app->params['user.userTypeOperator'],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Reports models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReportsSearch();
        if(Yii::$app->user->identity->user_type == Yii::$app->params['user.userTypeOperator']) {
            $searchModel->created_by = Yii::$app->user->identity->id;
        } else {
            $patient = Patient::find()
                            ->select('id')
                            ->where(['user_fk_id' => Yii::$app->user->identity->id])
                            ->one();
            if($patient) {
                $searchModel->patient_fk_id = $patient->id;
            } else {
                $searchModel->patient_fk_id = Yii::$app->params['user.userTypeSystem'];
            }
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Reports model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new PatientTestsSearch();
        $searchModel->patient_report_fk_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Add New Test
        $patientTests = new PatientTests();
        if ($patientTests->load(Yii::$app->request->post()) && $patientTests->save()) {
            return $this->redirect(['view', 'id' => $id]);
        }

        // Get users for autocomplete
        $testTypes = TestsType::find()
            ->select([ 'CONCAT(name, " : " , reference_interval) as name', 'id as id'])
            ->where(['status'=>1,'is_deleted'=>0])
            ->asArray()
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'patientTests' => $patientTests,
            'testTypes' => $testTypes
        ]);
    }

    /**
     * Creates a new Reports model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Reports();
        // Get users for autocomplete
        $users = User::find()
            ->select(['user.name as value', 'patient_details.id as name' , 'patient_details.id as id'])
            ->joinWith('patient')
            ->where(['user.status'=>1,'user.is_deleted'=>0])
            ->andWhere(['user.user_type' => 3])
            ->asArray()
            ->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'users' => $users
            ]);
        }
    }

    /**
     * Updates an existing Reports model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Get users for autocomplete
        $users = User::find()
            ->select(['user.name as value', 'patient_details.id as name' , 'patient_details.id as id'])
            ->joinWith('patient')
            ->where(['user.status'=>1,'user.is_deleted'=>0])
            ->andWhere(['user.user_type' => 3])
            ->asArray()
            ->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'users' => $users
            ]);
        }
    }

    /**
     * @param $id
     * Download Report as PDF
     */
    public function actionDownloadReport($id)
    {
        $model = Reports::findOne($id);

        $file_folder = 'uploads/reports/';
        $fileNameWithoutExt = 'pathologylabs_report_'.$model->id.time();
        $filename = $fileNameWithoutExt.'.pdf';
        $file_path = $file_folder.$filename;

        //checking for invoice directory exists or not
        if(!is_dir($file_folder))
            mkdir($file_folder, 0755,true);

        $mPDF1 = new mPDF();
        $mPDF1->setAutoTopMargin = 'stretch';
        $mPDF1->SetHeader($this->renderPartial('_report_header', array(
            'model' => $model,
        )));
        $mPDF1->SetFooter('{PAGENO}');
        $mPDF1->WriteHTML($this->renderPartial('_report', array(
            'model'=> $model,
        )));

        //download pdf
        $mPDF1->Output($filename, 'D');
    }

    /**
     * @return \yii\web\Response
     * @throws \MpdfException
     * @throws \yii\base\ExitException
     */
    public function actionMailReport()
    {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];

            $model = Reports::findOne($id);

            $file_folder = 'uploads/reports/';
            $fileNameWithoutExt = 'pathologylabs_report_'.$model->id.time();
            $filename = $fileNameWithoutExt.'.pdf';
            $file_path = $file_folder.$filename;

            //checking for invoice directory exists or not
            if(!is_dir($file_folder))
                mkdir($file_folder, 0755,true);

            $mPDF1 = new mPDF();
            $mPDF1->setAutoTopMargin = 'stretch';
            $mPDF1->SetHeader($this->renderPartial('_report_header', array(
                'model' => $model,
            )));
            $mPDF1->SetFooter('{PAGENO}');
            $mPDF1->WriteHTML($this->renderPartial('_report', array(
                'model'=> $model,
            )));

            //download pdf
            $mPDF1->Output($file_path, 'F');

            $data = ['model' => $model];
            $name = isset($model->patient->user)?$model->patient->user->name:"";
            $subject = "Pathology Lab Report - ".$name;
            $from = 'santuchal@gmail.com'; //TODO
            $toCS = Yii::$app->params['adminEmail'];
            $to = isset($model->patient->user)?$model->patient->user->email:Yii::$app->params['adminEmail'];
            $template = "report";

            if(file_exists($file_path)) {
                Globals::sendMailWithAttachment($template, $data, $from, $to, $subject, $file_path, [$toCS]);
            }

            if(Yii::$app->request->isAjax) {
                echo json_encode([
                    'status' => 'success'
                ]);
                Yii::$app->end();
            } else {
                return $this->redirect(['index']);
            }
        }
    }

    /**
     * Deletes an existing Reports model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->is_deleted = 1;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Reports model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reports the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reports::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
