<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "configs/php/database.php";
require 'vendor/autoload.php';
session_start();

function send_Reciept($connect, $data, $store_name, $user_email, $transaction_id, $amount_due, $total_quantity, $cash, $change)
{
    if (isset($_SESSION["token"])) {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        try {
            $body = "<div style='background-color:white;width:400px;height:auto;'>
             <center><img src='https://cdn.discordapp.com/attachments/781800902515752992/942332375461937172/logo.png'
              style='width:70px;height:70px;vertical-alignment:center;padding-top:10px;'>
              <p style='font-size:12px'>Interconnected Point Of Sales</p>
              </center>
              <h2 style='text-align:center'>" . $store_name . " Reciept</h2>
               <br>" . $data . "
               <hr style='width:full'>
               <div style='background-color:white;font-weight:bold;'>
               <center>
               <span style='font-size:15px;text-align:center;width:100%;background:white;'>Amount Due:</span>
               <span style='font-size:15px;text-align:center;width:100%;background:white;'>" . $amount_due . "</span>
               <br>
               <span style='font-size:15px;text-align:center;width:100%;background:white;'>Total Quantity: </span>
               <span style='font-size:15px;text-align:center;width:100%;background:white;'>" . $total_quantity . "</span>
               <br>
               <span style='font-size:15px;text-align:center;width:100%;background:white;'>Cash: </span>
               <span style='font-size:15px;text-align:center;width:100%;background:white;'>" . $cash . "</span>
               <br>
               <span style='font-size:15px;text-align:center;width:100%;background:white;'>Change: </span>
               <span style='font-size:15px;text-align:center;width:100%;background:white;'>" . $change . "</span>
               </center>
               </div>
               </div>";
            //Server settings
            $mail->SMTPDebug = 0; // for detailed debug output
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->Username   = "";
            $mail->Password   = "";
            //Recipients
            $mail->setFrom('acument.discord.bot@gmail.com', 'No-Reply');
            $mail->addAddress($user_email, $transaction_id);     //Add a recipient


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "Transaction Reciept ID:" . $transaction_id;
            $mail->Body    = $body;
            $mail->AltBody = "Use email client that support html.";

            $mail->send();
            return '200:Email Sent successfully';
        } catch (Exception $e) {
            return "500:Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        return "401:Unauthorize access . Please login first.";
    }
}
