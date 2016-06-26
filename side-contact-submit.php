<?php

/* config start */

$emailAddress = 'info@urbanactivation.com.au';
//$emailAddress = 'test@echo3.com.au';

/* config end */

require $_SERVER['DOCUMENT_ROOT']."/phpmailer/class.phpmailer.php5.php";
session_start();

foreach($_POST as $k=>$v)
{
	if(ini_get('magic_quotes_gpc'))
	$_POST[$k]=stripslashes($_POST[$k]);
	
	$_POST[$k]=htmlspecialchars(strip_tags($_POST[$k]));
}


$err = array();

if(!checkLen('name'))
	$err[]='The name field is too short or empty!';

if(!checkLen('tel'))
	$err[]='The phone field is too short or empty!';
		
if(!checkLen('email'))
	$err[]='The email field is too short or empty!';
else if(!checkEmail($_POST['email']))
	$err[]='Your email is not valid!';

if(!checkLen('seminar'))
	$err[]='You have not selected a seminar location!';

if(!checkLen('enquiryType'))
	$err[]='You have not selected an enquiry type!';

if(!checkLen('message'))
	$err[]='The message field is too short or empty!';

if ((md5($_POST["txtCaptcha"]."echo3") != $_SESSION["security_code"]) && (isset($_SESSION["security_code"])))
	$err[]='The security code was wrong. Please try again!';

/*if((int)$_POST['captcha'] != $_SESSION['expect'])
	$err[]='The captcha code is wrong!';*/


if(count($err))
{
	if($_SERVER['HTTP_REFERER'])
	{
		$_SESSION['errStr'] = implode('<br />',$err);
		$_SESSION['post']=$_POST;
		
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}

	exit;
}

/**************************************************************
Send Email to the Administrator
**************************************************************/
$msg=
'Name:	'.$_POST['name'].'<br />
Phone:	'.$_POST['tel'].'<br />
Email:	'.$_POST['email'].'<br />'.
((isset($_POST['seminar']))?'Seminar:  '.$_POST['seminar']:'').'<br />
Enquiry Type:	'.$_POST['enquiryType'].'<br />
From Page URL: '.$_SERVER['HTTP_REFERER'].'<br /><br />
Message:<br /><br />

'.nl2br($_POST['message']).'

';


$mail = new PHPMailer();
$mail->IsMail();

$mail->AddReplyTo('info@urbanactivation.com.au', 'Urban Activation'); //LIVE
$mail->AddAddress($emailAddress); //change the config variable at Go Live
$mail->AddBCC('test@echo3.com.au', 'First Person');
$mail->SetFrom('info@urbanactivation.com.au','Urban Activation');
$mail->Subject = "Urban Activation | Quick Contact Form";

$mail->MsgHTML($msg);

$mail->Send();

/**************************************************************
Send Email to the User
**************************************************************/
$msgUser=
'Hi '.$_POST['name'].',<br /><br />
Thank you for submitting your enquiry.<br />
An Urban Activation representative will contact you shortly.<br /><br />
Regards,<br />
Urban Activation<br />
1300 750 000';


$mailUser = new PHPMailer();
$mailUser->IsMail();

$mailUser->AddReplyTo('info@urbanactivation.com.au', 'Urban Activation'); //LIVE
$mailUser->AddAddress($_POST['email']); //change the config variable at Go Live
$mailUser->SetFrom('info@urbanactivation.com.au','Urban Activation');
$mailUser->Subject = "Urban Activation | Enquiry Form";

$mailUser->MsgHTML($msgUser);

$mailUser->Send();


unset($_SESSION['post']);

$_SESSION['sent']=1;
	
if($_SERVER['HTTP_REFERER'])
	header('Location: '.$_SERVER['HTTP_REFERER']);	
exit;


function checkLen($str,$len=2)
{
	return isset($_POST[$str]) && mb_strlen(strip_tags($_POST[$str]),"utf-8") > $len;
}
function checkEmail($str)
{
	return preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $str);
}

?>