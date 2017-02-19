<?php
require 'api/SmtpApi.php';
function confirmEmail($login,$key,$e_mail){
    $pubkey = '
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDpPsjdjAZku5ysLCk6UXwQiMb7
EiogpTl1muUXmGjvTWz4fpAAWrZbqJy8cgdlesqRjIbsLNPVWrupvnMEOQKf/Trg
8a1Qggg2Exl/MKVNV8BkikalY1Jl6uKszFnSfoZ+mxYMTZ32IYnu/CIoLlzEuriq
8ElZ48yLna9+bxt71QIDAQAB
-----END PUBLIC KEY-----
';
    $oApi = new SmtpApi($pubkey);
    $text = '<div style="width: 100%;max-width: 600px; margin: auto; border: 1px solid #e3e3e3;">
        <div style="width: 100%; height: 50px; background-color: #EEEEEE;">
            <div style="display: block;margin-right: auto; margin-left: auto;"><img style="padding-top:5px;display: block;margin-right: auto; margin-left: auto;" src="https://polisbook.com/img/Logo_s.png"></div>
        </div>
        <div style="padding: 20px 40px">
            <h1 style="text-align: center; color: #607d8b;"><b>Welcome to PolisBook!</b></h1>
            <h3 style=" text-align: justify; color: #607d8b;"><b>Hello, '.$login.'!</b></h3>
            <p style="font-size: 20px; text-align: justify; font-weight: 600; color: #607d8b; white-space: normal;">Thank you for joining PolisBook. We hope that our service will be useful for you. To confirm your account click on the button below.</p>
            <div style="padding: 20px 0px">
                <button  style="height:40px; display: block;margin-right: auto; margin-left: auto;background-color: #607d8b;border-color: #607d8b;color: #fff;padding: 6px 12px;margin-bottom: 0;font-size: 14px;font-weight: normal;line-height: 1.42857143;text-align: center;white-space: nowrap;vertical-align: middle;-ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;ms-user-select: none;user-select: none;background-image: none;border: 1px solid transparent;"><a style="text-decoration: none;color: #ffffff;" href="https://polisbook.com/recovery?com=cnf&key='.$key.'">Confirm your account</a></button>
            </div>
            <p style="font-size: 20px; text-align: justify; font-weight: 600; color: #607d8b; white-space: normal;">If you have any questions or suggestions you can always <a href="https://polisbook.com/help">contact us</a>.</p>
        </div>
        <div style="height:50px;background-color:#EEEEEE;padding:0px 30px;">
            <p style="text-align:justify;color:#607d8b;white-space:normal;padding-top:15px"><b>With best regards, PolisBook.</b></p>
        </div>
    </div>';
    $email = array(
        'html' => $text,
        'text' => 'Hello, '.$login.'! Thank you for joining PolisBook. We hope that our service will be useful for you. To confirm your account <a href="https://polisbook.com/recovery?com=cnf&key='.$key.'">click here.</a>',
        'encoding' => 'UTF-8',
        'subject' => 'Welcome to PolisBook',
        'from' => array(
            'name' => 'PolisBook',
            'email' => 'support@polisbook.com'
        ),
        'to' => array(
            array(
                'name' => $login,
                'email' => $e_mail
            )
        )
    );
    $res = $oApi->send_email($email);
return $res;
}
function passwordEmail($login,$e_mail,$newPassword){
    $pubkey = '
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDpPsjdjAZku5ysLCk6UXwQiMb7
EiogpTl1muUXmGjvTWz4fpAAWrZbqJy8cgdlesqRjIbsLNPVWrupvnMEOQKf/Trg
8a1Qggg2Exl/MKVNV8BkikalY1Jl6uKszFnSfoZ+mxYMTZ32IYnu/CIoLlzEuriq
8ElZ48yLna9+bxt71QIDAQAB
-----END PUBLIC KEY-----
';
    $oApi = new SmtpApi($pubkey);
    $text = '<div style="width: 100%;max-width: 600px; margin: auto; border: 1px solid #e3e3e3;">
        <div style="width: 100%; height: 50px; background-color: #EEEEEE;">
            <div style="display: block;margin-right: auto; margin-left: auto;"><img style="padding-top:5px;display: block;margin-right: auto; margin-left: auto;" src="https://polisbook.com/img/Logo_s.png"></div>
        </div>
        <div style="padding: 20px 40px">
            <h1 style="text-align: center; color: #607d8b;"><b>Password recovery</b></h1>
            <h3 style=" text-align: justify; color: #607d8b;"><b>Hello, '.$login.'!</b></h3>
            <p style="font-size: 20px; text-align: justify; font-weight: 600; color: #607d8b; white-space: normal;">You were sent a request for password recovery. <br>Your new password:</p>
            <div style="padding: 20px 0px">
                <div  style="height:30px; display: block;margin-right: auto; margin-left: auto;background-color: #FFFFFF;color: #607d8b;padding: 6px 12px;margin-bottom: 0;font-size: 14px;font-weight: normal;line-height: 1.42857143;text-align: center;white-space: nowrap;vertical-align: middle;background-image: none;border: 1px solid transparent;border-color: #607d8b; width: 50%"><b>'.$newPassword.'</b></div>
            </div>
            <p style="font-size: 20px; text-align: justify; font-weight: 600; color: #607d8b; white-space: normal;">If you have any questions or suggestions you can always <a href="https://polisbook.com/help">contact us</a>.</p>
        </div>
        <div style="height:50px;background-color:#EEEEEE;padding:0px 30px;">
            <p style="padding-top: 15px;text-align:justify;color:#607d8b;white-space:normal;"><b>With best regards, PolisBook.</b></p>
        </div>
    </div>';
    $email = array(
        'html' => $text,
        'text' => 'You were sent a request for password recovery. 
                    Your new password: '.$newPassword.'.',
        'subject' => 'Password recovery',
        'from' => array(
            'name' => 'PolisBook',
            'email' => 'support@polisbook.com'
        ),
        'to' => array(
            array(
                'name' => $login,
                'email' => $e_mail
            )
        )
    );
    $res = $oApi->send_email($email);
return $res;
}