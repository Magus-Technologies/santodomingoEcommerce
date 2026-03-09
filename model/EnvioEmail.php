<?php

/*define("HOST_SMTP","smtp.zoho.com");
define("USER_SMTP","pedidos@compuvisionperu.pe");
define("CLAVE_SMTP","C4p1cu4$$$");
define("PUERTO_SMTP","587");*/

define("HOST_SMTP","mail.apperpan.com");
define("USER_SMTP","envios@apperpan.com");
define("CLAVE_SMTP","C4p1cu4$$");
define("PUERTO_SMTP","465");

require "../utils/lib/phpmailer/vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EnvioEmail
{
    private $mail;


    public function __construct()
    {
        
	    $this->mail =  new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = HOST_SMTP;
        $this->mail->SMTPAuth = true;
        $this->mail->Username = USER_SMTP;
        $this->mail->Password = CLAVE_SMTP;
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port = PUERTO_SMTP;
        // HTML
        $this->mail->isHTML(true);
        $this->mail->CharSet = 'UTF-8';

    }
    public function esHTML($estado){
        $this->mail->isHTML($estado);
        return $this;
    }
    public function de($email,$nombre){
        $this->mail->setFrom($email,$nombre);
        return $this;
    }
    public function addReplicarA($email,$nombre){
        $this->mail->addReplyTo($email,$nombre);
        return $this;
    }

    public function addEmail($email,$nombre=''){
        $this->mail->addAddress($email,$nombre);
        return $this;
    }
    public function addCC($email,$nombre){
        $this->mail->addCC($email,$nombre);
        return $this;
    }
    public function addBCC($email,$nombre){
        $this->mail->AddBCC($email,$nombre);
        return $this;
    }
    public function addArchivo($ruta,$nombre=null){
        if (is_null($nombre)){
            $this->mail->addAttachment($ruta);
        }else{
            $this->mail->addAttachment($ruta, $nombre);
        }
        return $this;
    }
    public function setasunto($text){
        $this->mail->Subject = $text;
        return $this;
    }
    public function cuerpo($text){
        $this->mail->Body = $text;
        return $this;
    }
    public function cuerpoAlternativo($text){
        $this->mail->AltBody = $text;
        return $this;
    }
    public function enviar(){
        return $this->mail->send();
    }
    public function error(){
        return $this->mail->ErrorInfo;
    }
}
