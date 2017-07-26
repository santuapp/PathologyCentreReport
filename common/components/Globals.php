<?php

namespace common\components;

use Yii;
use yii\base\Component;

/*
 * Globals Components for global functions
 */
class Globals extends Component
{
    CONST VERSION = '0.0.1';

    /**
     * Send Mail
     * @param $template
     * @param $data
     * @param $from
     * @param $to
     * @param $subject
     * @param array $cc
     * @return bool
     */
    public static function sendMail($template, $data, $from, $to, $subject, $cc=[])
    {
        $mail = \Yii::$app->mailer->compose(['html' => $template], $data)
            ->setFrom($from)
            ->setTo($to)
            ->setCc($cc)
            ->setSubject($subject)
            ->send();
        return $mail;
    }

    /**
     * Send Mail with attachment
     * @param $template
     * @param $data
     * @param $from
     * @param $to
     * @param $subject
     * @param $attachFilePath
     * @param array $cc
     * @return bool
     */
    public static function sendMailWithAttachment($template, $data, $from, $to, $subject, $attachFilePath, $cc=[])
    {
        $message = Yii::$app->mailer->compose(['html' => $template], $data);
        $message->setFrom($from)
            ->setTo($to)
            ->setCc($cc)
            ->setSubject($subject);
        if(is_array($attachFilePath)){
            foreach($attachFilePath as $eachFile){
                $message->attach($eachFile);
            }
        } else {
            $message->attach($attachFilePath);
        }

        $mail = $message->send();
        return $mail;
    }
}