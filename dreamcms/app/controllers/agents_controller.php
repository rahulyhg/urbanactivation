<?php
App::import('Vendor', 'PhpMailer', array('file' => 'phpmailer' . DS . 'class.phpmailer.php5.php'));   
class AgentsController extends AppController {

	var $name = 'Agents';
	//var $components = array(array('JQValidator.JQValidator'), array('Email'));
        var $components = array('Email', 'JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'Ajax', 'CustomDisplayFunctions', 'ImageGallery', 'JQValidator.JQValidator');
        
        function generateUniquePassword($length = 8){
        return substr( md5(uniqid(mt_rand(), true)), 0, $length);
    }
    /***************** EMAIL ****************/
   function getSMTPMail(){
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    //$mail->CharSet = "UTF-8";
    //$mail->SMTPDebug = true;
    //$mail->SMTPSecure = "tls";
    $mail->Host = "mail.agent.urbanactivation.com.au";
    $mail->Port = 25;
    $mail->Username = "admin@agent.urbanactivation.com.au";
    $mail->Password = "D*B1(TQGI.2s";
    return $mail;
}
  function getMsgHead()  {
    //global $site_path;	
    $emailMsg = "<html>";
    $emailMsg .= "<head>";
    $emailMsg .= "<style>";
    $emailMsg .= "body { font: 14px/18px normal Arial,Helvetica,sans-serif; width: 600px; color: #333333;}";
    $emailMsg .= "h1 {color: #000000; font-size:16px; line-height: 120%; font-weight: bold; padding: 15px 0;}";
    $emailMsg .= "h2 { color: #004257; font-weight: bold; font-size: 16px; line-height: 110%; padding: 15px 0 5px 0; border-bottom: 1px #e8e8e8 solid}";
    $emailMsg .= "h3 {color: #1f8A70; font-weight: bold; font-size: 14px; padding: 0px 0 0 0;}";
    $emailMsg .= "h4 {color: #1f8A70; font-weight: normal; font-size: 13px; padding: 0px 0 0 0;}";
    $emailMsg .= "#order {width:600px; margin: 0 auto; text-align: left; padding: 20px ; border: 1px solid #e8e8e8; }";
    $emailMsg .= "p {font-size:14px; line-height: 140%; padding: 10px 0 0 0; }";
    $emailMsg .= "li {font-size:13px; line-height: 110%; padding: 10px 0 0 0; }";
    $emailMsg .= "</style>";
    $emailMsg .= "</head>";
    $emailMsg .= "<body>";
    //$emailMsg .= "<a href='$site_path'><img src='cid:logo'></a>";

    return ($emailMsg);	
}

function emailMsgActivatedNewMembershipForAgent($memberId, $firstName, $memberEmail, $password)  {	
        $emailMsg = $this->getMsgHead();
        $site_path = Configure::read('Company.url');
        $site_path = rtrim($site_path, "/");
	
	$emailMsg .= "<br/>Hi $firstName,<br/>";
	$emailMsg .= "Your access to the Urban Activation Agents Portal has now been activated and your login details are as follows.<br/>";
	
	$emailMsg .= "Email: $memberEmail<br/>";
        $emailMsg .= "Password: $password<br/><br/>";
        $emailMsg .= "You can login by clicking <a href='$site_path/login'><strong>Login Now</strong></a><br/>" ;
        $emailMsg .= "OR copy/paste this link into your browser: $site_path/login<br/>";
        $emailMsg .= "Regards<br/><br/>Urban Activation Administrator<br>1300 750 000";
       
	
	return ($emailMsg);
}

function sendMembershipApprovedEmail($memberId, $firstName, $memberEmail, $password, $adminEmail){

    $mail = new PHPMailer();
    $mail->IsMail();
    $mail->CharSet = "UTF-8";
    $mail->Encoding = "quoted-printable";
    $mail->IsHTML(true);
    //$mail = $this->getSMTPMail();
    $site_path = Configure::read('Company.url');
    //$mail->AddEmbeddedImage($site_path . 'images/email-logo.png', 'logo');
    
    $mail->AddReplyTo($adminEmail, 'Urban Activation Administrator'); 
    $mail->AddAddress($memberEmail);      
    $mail->SetFrom($adminEmail,'Urban Activation Administrator');
    $mail->Subject = "Urban Activation Agent Portal – Access Approved";
    $emailMsg = $this->emailMsgActivatedNewMembershipForAgent($memberId, $firstName, $memberEmail, $password);
    
    // footer
    $emailMsg .= "<br><br><a href='$site_path'><img src='{$site_path}images/email-logo.png'></a>";
    $emailMsg .= '</body></html>';    
    $mail->MsgHTML($emailMsg);

    $mail->Send();
    
/*$this->Email->to = $memberEmail;
$this->Email->subject = 'Urban Activation Agent Portal – Access Approved';
$this->Email->replyTo = $adminEmail;
$this->Email->from = $adminEmail; 
$this->Email->delivery = 'mail';
//Send as 'html', 'text' or 'both' (default is 'text')
$this->Email->sendAs = 'html'; // because we like to send pretty mail
$content = $this->emailMsgActivatedNewMembershipForAgent($memberId, $firstName, $memberEmail, $password);
$this->Email->xMailer = 'Urban Activation Website';
$this->Email->send($content); */ 
}
	function index() {
		$this->Agent->recursive = 0;
		$pageLimit = 50;
		$this->set('pageLimit',$pageLimit);
		
		$this->paginate = Set::merge($this->paginate,array('Agent'=>array('order' => array('Agent.lastname' => 'ASC'),'limit'=>$pageLimit)));
		if(isset($_GET['sel'])){
			if(trim($_GET['sel']=='all')){	
				$this->paginate = Set::merge($this->paginate,array('Agent'=>array('order' => array('Agent.lastname' => 'ASC'),'limit'=>$pageLimit)));
			} else {
				$this->paginate = Set::merge($this->paginate,array('Agent'=>array('conditions' => array('Agent.lastname LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>$pageLimit)));
			}
		}		
		if(isset($_GET['search'])){
			$this->paginate = Set::merge($this->paginate,array('Agent'=>array('conditions' => array('OR' => array('Agent.lastname LIKE' => '%'.trim($_GET['search']).'%', 'Agent.firstname LIKE' => '%'.trim($_GET['search']).'%', 'Agent.company LIKE' => '%'.trim($_GET['search']).'%')),'limit'=>$pageLimit)));
		}
		$this->set('agents', $this->paginate());		
		$this->set('helpURL','Agents');
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Agent', true), array('action' => 'index'));
		}
		$this->set('Agent', $this->Agent->read(null, $id));
		$this->layout='front-end-website';
		$moduleHeading = "our Agents";
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','Agents');
	}

	function add() {
		if (!empty($this->data)) {
			$this->Agent->create();
			if ($this->Agent->save($this->data)) {
				$this->flash(__('Agent saved.', true), array('action' => 'index'));
			} else {
			}
		}
                
                // default values                
                $this->data["Agent"]["password"] = $this->generateUniquePassword();
                $this->data["Agent"]["active"] = 1;
                $this->data["Agent"]["passworddefault"] = 1;
                
		$this->layout='add-edit';
		$ckeditorClass = '';
		$this->set('ckeditorClass', $ckeditorClass);
		$ckfinderPath = Configure::read('Company.url').'dreamcms/app/webroot/js/ckfinder/';
		$this->set('ckfinderPath', $ckfinderPath);		
		
		$moduleHeading = 'Agents';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('maxPosition',$this->Agent->find('count'));
		$this->set('helpURL','Agents');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Agent',
			$this->Agent->validate,
			__('Save failed, fix the following errors:', true),
			'AgentAddForm'
		);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid Agent', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
		// if agent is made active make new request false	
                    if($this->data['Agent']['active'] == 1){
                            $this->data['Agent']['newrequest'] = 0;
                        }
			if ($this->Agent->save($this->data)) {
				$this->flash(__('The Agent has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Agent->read(null, $id);
		}
		$this->layout='add-edit';
		$ckeditorClass = '';
		$this->set('ckeditorClass', $ckeditorClass);
		$ckfinderPath = Configure::read('Company.url').'dreamcms/app/webroot/js/ckfinder/';
		$this->set('ckfinderPath', $ckfinderPath);
		
		$moduleHeading = 'Agents';

		$this->set('orderStatus', 'Agent IMAGES Ordering Succesfully Saved!');

		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','Agents');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Agent',
			$this->Agent->validate,
			__('Save failed, fix the following errors:', true),
			'AgentEditForm'
		);
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid Agent', true)), array('action' => 'index'));
		}
		if ($this->Agent->delete($id)) {
			$this->flash(__('Agent deleted', true), array('action' => 'index'));
		}
		$this->flash(__('Agent was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
        
        function sendemail($id = null) {
            if (!$id) {
			$this->flash(sprintf(__('Invalid Agent', true)), array('action' => 'index'));
		}
            if (empty($this->data)) {
			$this->data = $this->Agent->read(null, $id);
		}
            if($this->data['Agent']['active'] == 1){
                    // send email
                // Send email to user
                $firstName = $this->data['Agent']['firstname'];
                $memberEmail = $this->data['Agent']['email'];
                $password = $this->data['Agent']['password'];
                $results = $this->Agent->query("SELECT `value` from settings WHERE `key` ='adminEmail'");
                $adminEmail = $results[0]['settings']['value'];                           
                $this->sendMembershipApprovedEmail($id, $firstName, $memberEmail, $password, $adminEmail);
                $this->flash(sprintf(__('Email has been sent', true)), array('action' => 'index'));
                }
             else {
                 $this->flash(sprintf(__('Agent Not Active', true)), array('action' => 'index'));
             }
        }
	
	function publish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid Agent', true)), array('action' => 'index'));
		}
                
                // read to get new request status
                $this->data = $this->Agent->read(null, $id);
                $newRequest = $this->data['Agent']['newrequest'];                 
                 
                
		if ( $this->Agent->saveField('active', 1,false) && $this->Agent->saveField('newrequest', 0, false) ) {
                    //TODO: Send email to user
                    if($newRequest == 1){
                            // Send email to user
                            $firstName = $this->data['Agent']['firstname'];
                            $memberEmail = $this->data['Agent']['email'];
                            $password = $this->data['Agent']['password'];
                            $results = $this->Agent->query("SELECT `value` from settings WHERE `key` ='adminEmail'");
                            $adminEmail = $results[0]['settings']['value'];
                           
                            $this->sendMembershipApprovedEmail($id, $firstName, $memberEmail, $password, $adminEmail);
                        }
                        
                    $this->flash(__('Agent published', true), array('action' => 'index'));                        
                        
		}
		$this->flash(__('Agent was not published', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function unpublish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid Agent', true)), array('action' => 'index'));
		}
		if ($this->Agent->saveField('active', 0,false)) {
			$this->flash(__('Agent unpublished', true), array('action' => 'index'));
		}
		$this->flash(__('Agent was not unpublished', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function markFeatured($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid Agent', true)), array('action' => 'index'));
		}
		if ($this->Agent->saveField('featured',1,false)) {
			$this->flash(__('Agent marked as featured', true), array('action' => 'index'));
		}
		$this->flash(__('Agent was not marked as featured', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function unmarkFeatured($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid Agent', true)), array('action' => 'index'));
		}
		if ($this->Agent->saveField('featured',0,false)) {
			$this->flash(__('Agent removed from featured', true), array('action' => 'index'));
		}
		$this->flash(__('Agent was not removed from featured', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	/** Receives ajax request from index **/
	function order(){
	//loop through the data sent via the ajax call
		foreach ($this->params['form']['Agents'] as $order => $id){
			$data['Agent']['position'] = $order;
			$this->Agent->id = $id;
			if($this->Agent->saveField('position', $order)) {
				//we have success!
			} else {
				//deal with possible errors!
			}
		}
		$this->autoRender=false;
	}
	
	function deletefile($id = null, $fldName = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid File Name', true)), array('action' => 'index'));
		}
		if($id > 0 && strlen($fldName)>0){
			if($this->Agent->saveField($fldName,'')){
				//we have successfully deleted file from DB
				$this->redirect(array('action' => 'edit/'.$id));
			}
		} else {
			//deal with possible errors!
		}
		$this->autoRender=false;
	}
}
