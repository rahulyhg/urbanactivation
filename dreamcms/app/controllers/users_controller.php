<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator');      
	
	function beforeFilter() {        
		parent::beforeFilter();        
		$this->Auth->loginRedirect = array('controller' => 'pages', 'action' => 'display', 'home');    
	}
	
	/****
	*  The AuthComponent provides the needed functionality
	*  for login, so you can leave this function blank.
	***/
	function login() {
		$this->set('title_for_layout', 'Login to access Website Content Management System');
		$this->layout = 'admin';	
	}
	
	function logout() {
		$this->redirect($this->Auth->logout());
	}
	
	function index() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			$this->set('title_for_layout', 'Active Users');
			$this->User->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('User'=>array('order' => array('User.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('User'=>array('order' => array('User.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('User'=>array('conditions' => array('User.name LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['group'])){
				if((int)trim($_GET['group'])>0){
					$this->paginate = Set::merge($this->paginate,array('User'=>array('conditions' => array('User.group_id =' => (int)trim($_GET['group'])),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){
				$this->paginate = Set::merge($this->paginate,array('User'=>array('conditions' => array("User.name LIKE '%".trim($_GET['search'])."%' OR User.username LIKE '%".trim($_GET['search'])."%'"),'limit'=>'10')));
			}
			$this->set('users', $this->paginate());
			$this->loadModel('Groups'); //if it's not already loaded
			$options = $this->Groups->find('all'); //or whatever conditions you want
			$this->set('options',$options);
			$this->set('helpURL','users');
		}
	}

	function view($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			$this->set('title_for_layout', 'View Active Users');
			if (!$id) {
				$this->flash(__('Invalid user', true), array('action' => 'index'));
			}
			$this->set('user', $this->User->read(null, $id));
			$this->set('helpURL','users');
		}
	}

	function add() {		
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			$this->set('title_for_layout', 'Add New Users');
			if (!empty($this->data)) {
				$this->User->create();
				if ($this->User->save($this->data)) {
					$this->flash(__('User saved.', true), array('action' => 'index'));
				} else {
				}
			}
			$this->layout='add-edit';
			$ckeditorClass = '';
			$this->set('ckeditorClass', $ckeditorClass);
			$ckfinderPath = Configure::read('Company.url').'dreamcms/app/webroot/js/ckfinder/';
			$this->set('ckfinderPath', $ckfinderPath);
			$this->loadModel('Groups'); //if it's not already loaded
			$options = $this->Groups->find('all'); //or whatever conditions you want
			$this->set('options',$options);
			$moduleHeading = 'users';
			$this->loadModel('UserStatuses'); //if it's not already loaded
			$us_options = $this->UserStatuses->find('all'); //or whatever conditions you want
			$this->set('us_options',$us_options);
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','users');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'User',
				$this->User->validate,
				__('Save failed, fix the following errors:', true),
				'UserAddForm'
			);
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			$this->set('title_for_layout', 'Edit Users');
			if (!$id && empty($this->data)) {
				$this->flash(sprintf(__('Invalid user', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->User->save($this->data)) {
					$this->flash(__('The user has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->User->read(null, $id);
			}
			$this->layout='add-edit';
			$ckeditorClass = '';
			$this->set('ckeditorClass', $ckeditorClass);
			$ckfinderPath = Configure::read('Company.url').'dreamcms/app/webroot/js/ckfinder/';
			$this->set('ckfinderPath', $ckfinderPath);
			$this->loadModel('Groups'); //if it's not already loaded
			$options = $this->Groups->find('all'); //or whatever conditions you want
			$this->set('options',$options);
			$this->loadModel('UserStatuses'); //if it's not already loaded
			$us_options = $this->UserStatuses->find('all'); //or whatever conditions you want
			$this->set('us_options',$us_options);
			$moduleHeading = 'users';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','users');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'User',
				$this->User->validate,
				__('Save failed, fix the following errors:', true),
				'UserEditForm'
			);
		}
	}

	function changepassword($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			$this->set('title_for_layout', 'Edit Users');
			if (!$id && empty($this->data)) {
				$this->flash(sprintf(__('Invalid user', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->User->save($this->data)) {
					$this->flash(__('The user has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->User->read(null, $id);
			}
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid user', true)), array('action' => 'index'));
		}
		if ($this->User->delete($id)) {
			$this->flash(__('User deleted', true), array('action' => 'index'));
		}
		$this->flash(__('User was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
}
