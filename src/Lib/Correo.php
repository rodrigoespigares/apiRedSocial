<?php
    namespace Lib;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    class Correo{
        private PHPMailer $mail;
        public function __construct()
        {
            $this->mail=new PHPMailer();
        } 
        /**
         * Función base para mandar un email.
         */
        public function sendMail($email, $token) {
            $this->mail->isSMTP();
            $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $this->mail->Host = 'smtp.gmail.com';
            $this->mail->Port = 465;
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'respigares.spam@gmail.com';
            $this->mail->Password = 'gmwiqixepllkwunf';

            // Establece quién enviará el mensaje.
            // Ten en cuenta que con Gmail solo puedes usar la dirección de tu cuenta (igual que Username)
            // o alias predefinidos que hayas configurado en tu cuenta.
            // No uses direcciones proporcionadas por el usuario aquí.
            $this->mail->setFrom('respigares.spam@gmail.com', 'ADMINISTRADOR');


            // Establece una dirección alternativa para las respuestas
            // Este es un buen lugar para poner direcciones proporcionadas por el usuario.
            $this->mail->addReplyTo('respigares.spam@gmail.com', 'ADMINISTRADOR');

            
            // Establece a quién se enviará el mensaje
            $this->mail->addAddress("$email");
            $this->mail->isHTML(true);
            //Establece la línea de asunto.
            $this->mail->Subject = 'Confirme su cuenta de Twitagram';

            // Reemplaza el cuerpo de texto plano con uno creado manualmente.
            $this->mail->Body = $this->crearHtml($email,$token);

            //Envia el mensaje, checkea los errores
            if (!$this->mail->send()) {
                echo 'Mailer Error: ' . $this->mail->ErrorInfo;
            } else {
                echo 'Message sent!';
            }
        }
        /**
         * Función para crear el HTML con el parametro usuario
         */
        public static function crearHtml($email,$token):string {
            $html="<!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Document</title>
            </head>
            <body>";
            $html.= "<h2>Hola $email</h2>";
            $html.="<h2>Confirma su cuenta:</h2>";
            $html.="<a href='".BASE_URL."confirmar/$token'>Verificar correo</a>";
            $html.="</body></html>";
            return $html;
        }
    }