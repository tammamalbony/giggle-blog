<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class MailComponent extends CApplicationComponent
{
    public $Host ;
    public $Username ;
    public $Password;
    public $Port;
    public $SMTPSecure;
    public $SMTPAuth ;
    public $From;
    public $FromName ;

    public function init()
    {
        require_once(Yii::getPathOfAlias('application.vendor.phpmailer.phpmailer.src.PHPMailer').'.php');
        require_once(Yii::getPathOfAlias('application.vendor.phpmailer.phpmailer.src.SMTP').'.php');
    }

    public function sendMail($to, $subject, $body)
    {
        $mail = new PHPMailer(true); // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = $this->Host;
            $mail->SMTPAuth = $this->SMTPAuth;
            $mail->Username = $this->Username;
            $mail->Password = $this->Password;
            $mail->SMTPSecure = $this->SMTPSecure;
            $mail->Port = $this->Port;

            //Recipients
            $mail->setFrom($this->From, $this->FromName);
            $mail->addAddress($to);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            Yii::log("Mailer Error: " . $mail->ErrorInfo, CLogger::LEVEL_ERROR);
            return false;
        }
    }
}
