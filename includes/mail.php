<?php
// SendPulse's PHP Library: https://github.com/sendpulse/sendpulse-rest-api-php
require_once('api/sendpulseInterface.php');
require_once('api/sendpulse.php');
$text='<div style="height: 500px; width:300px; background-color: brown;"><h1>Hello!</h1></div>';
$SPApiProxy = new SendpulseApi( 'c49412f8b70d4808a3ea5b0bc1d9c2f2', '1ab29debd7edc2547d11763319352504', 'file' );
$email = array(
    'html'    => $text,
    'text'    => 'Your email text version goes here',
    'subject' => 'Testing SendPulse API',
    'from'    => array(
        'name'  => 'PolisBook',
        'email' => 'tech.polisbook@gmail.com'
    ),
    'to'      => array(
        array(
            'name'  => 'Nick Bronnikov',
            'email' => 'nickbronnikov@yandex.ru'
        )
    )
);
var_dump( $SPApiProxy->smtpSendMail( $email ) );