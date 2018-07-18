<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 14.07.2018
 * Time: 21:15
 */

namespace frontend\services\Contact;
use frontend\forms\ContactForm;
use yii\mail\MailerInterface;


class ContactService
{
    private $mailer;
    private $adminEmail;

    public function __construct($adminEmail,MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        $this->adminEmail = $adminEmail;
    }
    public function send(ContactForm $form):void
    {
        $sent=\Yii::$app->mailer->compose()
            ->setTo($this->adminEmail)
            ->setSubject($form->subject)
            ->setTextbody($form->body)
            ->send();
        if (!$sent){
            throw new \RuntimeException('Sending error');
        }

    }

}