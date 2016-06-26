<?php
class TeamsController extends AppController {

	var $name = 'Teams';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript','Ajax', 'CustomDisplayFunctions','JQValidator.JQValidator');

	function index() {
		$this->Team->recursive = 0;
		$this->paginate = Set::merge($this->paginate,array('Team'=>array('order' => array('Team.position' => 'ASC'),'limit'=>'25')));
		if(isset($_GET['sel'])){
			if(trim($_GET['sel']=='all')){	
				$this->paginate = Set::merge($this->paginate,array('Team'=>array('order' => array('Team.position' => 'ASC'),'limit'=>'50')));
			} else {
				$this->paginate = Set::merge($this->paginate,array('Team'=>array('conditions' => array('Team.name LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'25')));
			}
		}		
		if(isset($_GET['group'])){
			if((int)trim($_GET['group'])>0){
				$this->paginate = Set::merge($this->paginate,array('Team'=>array('conditions' => array('Team.category_id =' => (int)trim($_GET['group'])),'limit'=>'25')));
			}
		}	
		if(isset($_GET['search'])){
			$this->paginate = Set::merge($this->paginate,array('Team'=>array('conditions' => array('Team.name LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'25')));
		}
		$this->set('teams', $this->paginate());
		$this->set('instructionText','You can drag and drop the items below to set the order.');
		$this->set('orderStatus', 'TEAMS Ordering Succesfully Saved!');
		$this->loadModel('TeamsCategory'); //if it's not already loaded
		$options = $this->TeamsCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$this->set('helpURL','teams');
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid team', true), array('action' => 'index'));
		}
		$this->set('team', $this->Team->read(null, $id));
		$this->layout='front-end-website';
		$moduleHeading = "our team";
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','teams');
	}

	function add() {
		if (!empty($this->data)) {
			$this->Team->create();			
			if ($this->Team->save($this->data)) {
				$this->flash(__('Team saved.', true), array('action' => 'index'));
			} else {
			}
		}
		$this->layout='add-edit';
		$ckeditorClass = '';
		$this->set('ckeditorClass', $ckeditorClass);
		$ckfinderPath = Configure::read('Company.url').'dreamcms/app/webroot/js/ckfinder/';
		$this->set('ckfinderPath', $ckfinderPath);
		$this->loadModel('TeamsCategory'); //if it's not already loaded
		$options = $this->TeamsCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$branch = ClassRegistry::init('Branch');
		$branches_list = $branch->find('all');
		$this->set('branches_list',$branches_list);
		$moduleHeading = 'teams';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('maxPosition',$this->Team->find('count'));
		$this->set('helpURL','teams');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Team',
			$this->Team->validate,
			__('Save failed, fix the following errors:', true),
			'TeamAddForm'
		);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid team', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Team->save($this->data)) {				
				//$this->loadModel('Upload'); //if it's not already loaded
				//$this->Upload->save($this->data['Team']['photo']);
				$this->flash(__('The team has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Team->read(null, $id);
		}
		$this->layout='add-edit';
		$ckeditorClass = '';
		$this->set('ckeditorClass', $ckeditorClass);
		$ckfinderPath = Configure::read('Company.url').'dreamcms/app/webroot/js/ckfinder/';
		$this->set('ckfinderPath', $ckfinderPath);
		$this->loadModel('TeamsCategory'); //if it's not already loaded
		$options = $this->TeamsCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$branch = ClassRegistry::init('Branch');
		$branches_list = $branch->find('all');
		$this->set('branches_list',$branches_list);
		$moduleHeading = 'teams';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','teams');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Team',
			$this->Team->validate,
			__('Save failed, fix the following errors:', true),
			'TeamEditForm'
		);
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid team', true)), array('action' => 'index'));
		}
		if ($this->Team->delete($id)) {
			$this->flash(__('Team deleted', true), array('action' => 'index'));
		}
		$this->flash(__('Team was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function publish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid Team Member', true)), array('action' => 'index'));
		}
		if ($this->Team->saveField('live',1,false)) {
			$this->flash(__('Team Member published', true), array('action' => 'index'));
		}
		$this->flash(__('Team Member was not published', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function unpublish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid Team Member', true)), array('action' => 'index'));
		}
		if ($this->Team->saveField('live',0,false)) {
			$this->flash(__('Team Member unpublished', true), array('action' => 'index'));
		}
		$this->flash(__('Team Member was not unpublished', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	/** Receives ajax request from index **/
	function order(){
	//loop through the data sent via the ajax call
		foreach ($this->params['form']['teams'] as $order => $id){
			$data['Team']['position'] = $order;
			$this->Team->id = $id;
			if($this->Team->saveField('position',$order)) {
				//we have success!
			} else {
				//deal with possible errors!
			}
		}
		$this->autoRender=false;
	}
	
	function deletefile($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid File Name', true)), array('action' => 'index'));
		}
		if($this->Team->saveField('photo','')){
			//we have successfully deleted file from DB
			$this->redirect(array('action' => 'edit/'.$id));
		} else {
			//deal with possible errors!
		}
		$this->autoRender=false;
	}
}
