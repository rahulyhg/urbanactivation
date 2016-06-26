<?php
@set_magic_quotes_runtime(false);
ini_set('magic_quotes_runtime', 0);
require_once ("phpmailer/class.phpmailer.php5.php");
require_once 'inc/connection.php';

/*function emailActivateNewAgent($memberId, $firstName, $memberEmail, $password){
    $mail = new PHPMailer();
    $mail->IsMail();
    $mail->IsHTML(true);
    $mail->AddEmbeddedImage('../images/email-logo.png', 'logo');
    $adminEmail = 'subhash@echo3.com.au';
    
    $emailMsg = emailMsgActivatedNewMembershipForAgent($memberId, $firstName, $memberEmail, $password);
    
    echo $emailMsg;
	
    $mail->AddReplyTo($adminEmail, 'UA'); 
    $mail->AddAddress($memberEmail);      
    $mail->SetFrom($adminEmail,'UA');
    $mail->Subject = "UA | Your Membership Approved";

    $mail->MsgHTML($emailMsg);

    $mail->Send();
}*/

function emailNewMembershipRequest($memberId, $firstName, $lastName, $memberEmail)  {
    emailNewMembershipToAgent($memberId, $firstName, $lastName, $memberEmail);
    emailNewMembershipToAdmin($memberId, $firstName, $lastName, $memberEmail);
}


function emailNewMembershipToAgent($memberId, $firstName, $lastName, $memberEmail){
    $mail = new PHPMailer();
    $mail->IsMail();
    $mail->IsHTML(true);
    $mail->AddEmbeddedImage('./images/email-logo.png', 'logo');
    $adminEmail = getSettingValue('adminEmail');
    
    $emailMsg = emailMsgNewMembershipForAgent($memberId, $firstName);
	
    $mail->AddReplyTo($adminEmail, 'Urban Activation Administrator'); 
    $mail->AddAddress($memberEmail);      
    $mail->SetFrom($adminEmail,'Urban Activation Administrator');
    $mail->Subject = "Urban Activation Agent Portal - Approval Pending";

    $mail->MsgHTML($emailMsg);

    $mail->Send();
}

function emailNewMembershipToAdmin($memberId, $firstName, $lastName, $memberEmail){
    $mail = new PHPMailer();
    $mail->IsMail();
    $mail->IsHTML(true);
    $mail->AddEmbeddedImage('./images/email-logo.png', 'logo');
    $adminEmail = getSettingValue('adminEmail');
    
    $emailMsg = emailMsgNewMembershipToAdmin($memberId, $firstName, $lastName);
	
    //$mail->AddReplyTo($memberEmail, 'UA'); 
    $mail->AddAddress($adminEmail);      
    $mail->SetFrom($adminEmail,'Urban Activation Administrator');
    $mail->Subject = "Urban Activation | New Agent Membership Request ID: $memberId";

    $mail->MsgHTML($emailMsg);

    $mail->Send();
}

function emailMembershipPasswordReset($memberId, $firstName, $resetToken, $memberEmail)  {
	
        $mail = new PHPMailer();
	$mail->IsMail();
	$mail->IsHTML(true);
	$mail->AddEmbeddedImage('./images/email-logo.png', 'logo');
	
        $adminEmail = getSettingValue('adminEmail');
        
	$emailMsg = emailMsgAgentPasswordReset($memberId, $firstName, $resetToken);
	
	$mail->AddReplyTo($adminEmail, 'Urban Activation Administrator'); 
	$mail->AddAddress($memberEmail);      
	$mail->SetFrom($adminEmail,'Urban Activation Administrator');
	$mail->Subject = "Urban Activation Administrator | Password Reset";
	
	$mail->MsgHTML($emailMsg);
	
	$mail->Send();
}

function emailMsgNewMembershipForAgent($memberId, $firstName)  {	
	$emailMsg = getMsgHead();
	
	$emailMsg .= "<br/>Hi $firstName,<br/><br/>";
	$emailMsg .= "Thank you for requesting access to the Urban Activation Agents Portal.<br/>";
	$emailMsg .= "<p>Your request is currently being reviewed. Once approved by the Urban Activation Administrator you will receive your login details via email. This will usually occur within 24 hours.</p><br/>";
	$emailMsg .= "<p><strong>Note:</strong> If you don’t receive your password within 48 hours please check your Junk folder or contact us at <a href='mailto:admin@agent.urbanactivation.com.au'><strong>admin@agent.urbanactivation.com.au</strong></a>.</p><br/>";
	$emailMsg .= "If you have any queries in the meantime please contact us.<br/><br/>";
        $emailMsg .= "Regards<br/><br/>Urban Activation Administrator<br>1300 750 000";
	
        $emailMsg .= getMsgFooter();
	
	return ($emailMsg);
}

function emailMsgNewMembershipToAdmin($memberId, $firstName, $lastName){	
	$emailMsg = getMsgHead();
	
	$adminName = getSettingValue('adminName');
        $emailMsg .= "<br/>Hi $adminName,<br/>";
	$emailMsg .= "New agent membership request is waiting for your approval.<br/>";
	$emailMsg .= "New agent name is <strong>$firstName" . " $lastName</strong> and membership number is: <strong> $memberId </strong><br/>";
	
	$emailMsg .= "Agent will receive login details once approved by CMS admin.<br/><br/>";
	
        $emailMsg .= getMsgFooter();
	
	return ($emailMsg);
}

function emailMsgAgentPasswordReset($memberId, $firstName, $resetToken)  {	
        global $site_path;    
        $emailMsg = getMsgHead();

        $site_path = rtrim($site_path, "/");
        $emailMsg = "<br/>Hi " . $firstName . ",<br/>";

        $emailMsg .= "We have received a request to reset your password.  If this was sent in error or was not requested by you please ignore this email and nothing will change.  "
        . "<br>To change your password, please click <a href='$site_path/password-reset/" . $memberId . "/" . $iToken . "'><strong>Reset Password</strong></a>.<br/>";

        $emailMsg .= "OR copy/paste below link in browser<br>$site_path/password-reset/$memberId/$iToken<br/>";

        $emailMsg .= getMsgFooter();
        return $emailMsg;
}

function emailMsgActivatedNewMembershipForAgent($memberId, $firstName, $memberEmail, $password)  {	
    global $site_path;
    $site_path = rtrim($site_path, "/");
    $emailMsg = getMsgHead();
	
	$emailMsg .= "<br/>Hi $firstName,<br/><br/>";
	$emailMsg .= "Thanks for joining Urban Activation Agents group.<br/>";
	$emailMsg .= "Your membership account has been activated. Your login details are below.<br/>";
	
	$emailMsg .= "Email: $memberEmail<br/>";
        $emailMsg .= "Password: $password<br/><br/>";
        $emailMsg .= "You can login by clicking <a href='$site_path/login'><strong>Login Now</strong></a><br/>" ;
        $emailMsg .= "OR copy/paste this link into your browser: $site_path/login <br/><br/>";
	
        $emailMsg .= getMsgFooter();
	
	return ($emailMsg);
}


function getMsgHead()  {
    global $site_path;	
    $emailMsg = "<html>";
    $emailMsg .= "<head>";
    $emailMsg .= "<style>";
    $emailMsg .= "body { font: 14px/18px normal Arial,Helvetica,sans-serif; width: 600px; color: #333333;}";
    $emailMsg .= "h1 {color: #000000; font-size:16px; line-height: 120%; font-weight: bold; padding: 15px 0;}";
    $emailMsg .= "h2 { color: #333333; font-weight: bold; font-size: 16px; line-height: 110%; padding: 15px 0 5px 0; border-bottom: 1px #e8e8e8 solid}";
    $emailMsg .= "h3 {color: #7777777; font-weight: bold; font-size: 14px; padding: 0px 0 0 0;}";
    $emailMsg .= "h4 {color: #777777; font-weight: normal; font-size: 13px; padding: 0px 0 0 0;}";
    $emailMsg .= "p {font-size:14px; line-height: 140%; padding: 10px 0 0 0; }";
    $emailMsg .= "li {font-size:13px; line-height: 110%; padding: 10px 0 0 0; }";
    $emailMsg .= "</style>";
    $emailMsg .= "</head>";
    $emailMsg .= "<body>";
    //$emailMsg .= "<a href='$site_path'><img src='cid:logo'></a>";

    return ($emailMsg);	
}

function getMsgFooter()  {
    global $site_path;	
    $emailMsg .= "<br><br><a href='$site_path'><img src='cid:logo'></a>";
    //$emailMsg .= "<a href='$site_path'><img src='cid:thanks'></a>";
    $emailMsg .= "</body>";
    $emailMsg .= "</html>";
	
    return ($emailMsg);		
}
?>