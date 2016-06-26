<?php
class LinksController extends AppController {

	var $name = 'Links';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript','Ajax', 'CustomDisplayFunctions','JQValidator.JQValidator');

	function index() {
		$this->Link->recursive = 0;
		$this->paginate = Set::merge($this->paginate,array('Link'=>array('order' => array('Link.position' => 'ASC'),'limit'=>'25')));
		if(isset($_GET['sel'])){
			if(trim($_GET['sel']=='all')){	
				$this->paginate = Set::merge($this->paginate,array('Link'=>array('order' => array('Link.position' => 'ASC'),'limit'=>'50')));
			} else {
				$this->paginate = Set::merge($this->paginate,array('Link'=>array('conditions' => array('Link.name LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'25')));
			}
		}		
		if(isset($_GET['group'])){
			if((int)trim($_GET['group'])>0){
				$this->paginate = Set::merge($this->paginate,array('Link'=>array('conditions' => array('Link.category_id =' => (int)trim($_GET['group'])),'limit'=>'25')));
			}
		}	
		if(isset($_GET['search'])){
			$this->paginate = Set::merge($this->paginate,array('Link'=>array('conditions' => array('Link.name LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'25')));
		}
		$this->set('links', $this->paginate());
		$this->set('instructionText','You can drag and drop the items below to set the order.');
		$this->set('orderStatus', 'Links Ordering Succesfully Saved!');
		$this->loadModel('LinksCategory'); //if it's not already loaded
		$options = $this->LinksCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$this->set('helpURL','links');
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Link', true), array('action' => 'index'));
		}
		$this->set('link', $this->Link->read(null, $id));
		$this->layout='front-end-website';
		$moduleHeading = "Links";
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','links');
	}

	function add() {
		if (!empty($this->data)) {
			$this->Link->create();			
			if ($this->Link->save($this->data)) {
				$this->flash(__('Link saved.', true), array('action' => 'index'));
			} else {
			}
		}
		$this->layout='add-edit';
		$ckeditorClass = '';
		$this->set('ckeditorClass', $ckeditorClass);
		$ckfinderPath = Configure::read('Company.url').'dreamcms/app/webroot/js/ckfinder/';
		$this->set('ckfinderPath', $ckfinderPath);
		$this->loadModel('LinksCategory'); //if it's not already loaded
		$options = $this->LinksCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$moduleHeading = 'Links';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('maxPosition',$this->Link->find('count'));
		$this->set('helpURL','links');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Link',
			$this->Link->validate,
			__('Save failed, fix the following errors:', true),
			'LinkAddForm'
		);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid Link', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Link->save($this->data)) {				
				//$this->loadModel('Upload'); //if it's not already loaded
				//$this->Upload->save($this->data['Link']['photo']);
				$this->flash(__('The Link has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Link->read(null, $id);
		}
		$this->layout='add-edit';
		$ckeditorClass = '';
		$this->set('ckeditorClass', $ckeditorClass);
		$ckfinderPath = Configure::read('Company.url').'dreamcms/app/webroot/js/ckfinder/';
		$this->set('ckfinderPath', $ckfinderPath);
		$this->loadModel('LinksCategory'); //if it's not already loaded
		$options = $this->LinksCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$moduleHeading = 'Links';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','links');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Link',
			$this->Link->validate,
			__('Save failed, fix the following errors:', true),
			'LinkEditForm'
		);
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid Link', true)), array('action' => 'index'));
		}
		if ($this->Link->delete($id)) {
			$this->flash(__('Link deleted', true), array('action' => 'index'));
		}
		$this->flash(__('Link was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function publish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid Link Member', true)), array('action' => 'index'));
		}
		if ($this->Link->saveField('live',1,false)) {
			$this->flash(__('Link Member published', true), array('action' => 'index'));
		}
		$this->flash(__('Link Member was not published', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function unpublish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid Link Member', true)), array('action' => 'index'));
		}
		if ($this->Link->saveField('live',0,false)) {
			$this->flash(__('Link Member unpublished', true), array('action' => 'index'));
		}
		$this->flash(__('Link Member was not unpublished', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	/** Receives ajax request from index **/
	function order(){
	//loop through the data sent via the ajax call
		foreach ($this->params['form']['links'] as $order => $id){
			$data['Link']['position'] = $order;
			$this->Link->id = $id;
			if($this->Link->saveField('position',$order)) {
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
		if($this->Link->saveField('logo','')){
			//we have successfully deleted file from DB
			$this->redirect(array('action' => 'edit/'.$id));
		} else {
			//deal with possible errors!
		}
		$this->autoRender=false;
	}
}
