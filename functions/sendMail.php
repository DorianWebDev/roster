<?php
//Send roster file by mail

require_once("functions.php");



if( isset($_POST['rosterId']) )
{
    $mails = getMailsFromRoster($_POST['rosterId']);
    
    $to = "coin.valentina@gmail.com";
    
    foreach($mails as $m)
    {
        $to .= ', '.$m;
    }
    
    $from = "coin.valentina@gmail.com";
    $subject = "New Roster - Noosa Hot Bread Shop (Hasting St.)";
    $message = "
    --- Hasting St. Roster ---
    
    Hi, Check out the new roster:
    
    http://rost.doriantrevisan.com/functions/addRoster.php?loadRoster=".$_POST['rosterId']."
    
    reply by e-mail at coin.valentina@gmail.com
    or by text at 0404 159272
    to confirm your availability.
    
    Thank you,
    
    
    Your friendly management
    Val.
    ";
    $headers = "Reply-To:" . $from. "\r\n";
    $headers.= "From: ".$from. "\r\n";
    
    if( mail($to, $subject, $message, $headers) )
    {
        header('Location: /index.php');
    }
    else
    {
        echo '<p>Mail NOT sent!</p>';
    }
}
else
{
    echo '<p>Mail NOT sent!</p>';
}