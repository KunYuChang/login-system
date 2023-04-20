<?php

namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    public static function send($to, $subject, $text, $html)
    {
        // 創建一個實例，傳遞 true 參數以啟用異常處理
        $mail = new PHPMailer(true);

        try {
            // 伺服器設定
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'yourmailtrapusername';
            $mail->Password   = 'yourmailtrappassword';
            $mail->Port       = 2525;

            // 寄件人 / 收件人
            $mail->setFrom('admin@system.com');
            $mail->addAddress($to);

            // 內容
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $subject;
            $mail->Body    = $html;
            $mail->AltBody = $text;

            if($mail->send()) {
                echo "郵件已寄出";
            } else {
                echo '郵件未寄出';
            }

        } catch (Exception $e) {
            echo "無法發送郵件。錯誤訊息: {$mail->ErrorInfo}";
        }
    }
}