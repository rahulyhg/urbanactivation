<?php
class BranchesController extends AppController {

	var $name = 'Branches';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript','Ajax', 'CustomDisplayFunctions','JQValidator.JQValidator');

	function index() {
		$this->Branch->recursive = 0;$this->paginate = Set::merge($this->paginate,array('Branch'=>array('order' => array('Branch.position' => 'ASC'),'limit'=>'25')));
		if(isset($_GET['sel'])){
			if(trim($_GET['sel']=='all')){	
				$this->paginate = Set::merge($this->paginate,array('Branch'=>array('order' => array('Branch.position' => 'ASC'),'limit'=>'50')));
			} else {
				$this->paginate = Set::merge($this->paginate,array('Branch'=>array('conditions' => array('Branch.title LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'25')));
			}
		}		
		/*if(isset($_GET['group'])){
			if((int)trim($_GET['group'])>0){
				$this->paginate = Set::merge($this->paginate,array('Branch'=>array('conditions' => array('Branch.category_id =' => (int)trim($_GET['group'])),'limit'=>'25')));
			}
		}	*/
		if(isset($_GET['search'])){
			$this->paginate = Set::merge($this->paginate,array('Branch'=>array('conditions' => array('Branch.title LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'25')));
		}
		$this->set('branches', $this->paginate());
		$this->set('instructionText','You can drag and drop the items below to set the order.');
		$this->set('orderStatus', 'BRANCH Ordering Succesfully Saved!');
		$this->loadModel('PagesCategory'); //if it's not already loaded
		$options = $this->PagesCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$this->set('helpURL','branches');
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid branch', true), array('action' => 'index'));
		}
		$this->set('branch', $this->Branch->read(null, $id));
		$this->layout='front-end-website';
		$moduleHeading = "branches";
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','branches');
	}

	function add() {
		if (!empty($this->data)) {
			$this->Branch->create();
			if ($this->Branch->save($this->data)) {
				$this->flash(__('Branch saved.', true), array('action' => 'index'));
			} else {
			}
		}
		$this->layout='add-edit';
		$ckeditorClass = '';
		$this->set('ckeditorClass', $ckeditorClass);
		$ckfinderPath = Configure::read('Company.url').'dreamcms/app/webroot/js/ckfinder/';
		$this->set('ckfinderPath', $ckfinderPath);
		//$this->loadModel('PagesCategory'); //if it's not already loaded
		//$options = $this->PagesCategory->find('all'); //or whatever conditions you want
		//$this->set('options',$options);
		$services = ClassRegistry::init('Pages');
		$services_list = $services->find('all', array('conditions' => array('Pages.category_id'=> 2)));
		$this->set('services_list',$services_list);
		$moduleHeading = 'branches';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('maxPosition',$this->Branch->find('count'));
		$this->set('helpURL','branches');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Branch',
			$this->Branch->validate,
			__('Save failed, fix the following errors:', true),
			'BranchAddForm'
		);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid branch', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Branch->save($this->data)) {
				$this->flash(__('The branch has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Branch->read(null, $id);
		}
		$this->layout='add-edit';
		$ckeditorClass = '';
		$this->set('ckeditorClass', $ckeditorClass);
		$ckfinderPath = Configure::read('Company.url').'dreamcms/app/webroot/js/ckfinder/';
		$this->set('ckfinderPath', $ckfinderPath);
		//$this->loadModel('PagesCategory'); //if it's not already loaded
		//$options = $this->PagesCategory->find('all'); //or whatever conditions you want
		//$this->set('options',$options);
		$services = ClassRegistry::init('Pages');
		$services_list = $services->find('all', array('conditions' => array('Pages.category_id'=> 2)));
		$this->set('services_list',$services_list);
		$moduleHeading = 'branches';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','branches');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Branch',
			$this->Branch->validate,
			__('Save failed, fix the following errors:', true),
			'BranchEditForm'
		);
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid branch', true)), array('action' => 'index'));
		}
		if ($this->Branch->delete($id)) {
			$this->flash(__('Branch deleted', true), array('action' => 'index'));
		}
		$this->flash(__('Branch was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	
	function publish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid branch', true)), array('action' => 'index'));
		}
		if ($this->Branch->saveField('live',1,false)) {
			$this->flash(__('Branch published', true), array('action' => 'index'));
		}
		$this->flash(__('Branch was not published', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function unpublish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid page', true)), array('action' => 'index'));
		}
		if ($this->Branch->saveField('live',0,false)) {
			$this->flash(__('Branch unpublished', true), array('action' => 'index'));
		}
		$this->flash(__('Branch was not unpublished', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	/** Receives ajax request from index **/
	function order(){
	//loop through the data sent via the ajax call
		foreach ($this->params['form']['branches'] as $order => $id){
			$data['Branch']['position'] = $order;
			$this->Branch->id = $id;
			if($this->Branch->saveField('position',$order)) {
				//we have success!
			} else {
				//deal with possible errors!
			}
		}
		$this->autoRender=false;
	}
}
