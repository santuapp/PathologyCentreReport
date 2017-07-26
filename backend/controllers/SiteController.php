<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Reports;
use common\models\ReportsSearch;
use common\models\PatientTestsSearch;
use mPDF;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'view', 'download-report'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
	
	public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ReportsSearch();
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

        $model = Reports::findOne($id);

        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionLogin()
    {
        $this->layout = false;
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
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
}
