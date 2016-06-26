<?php
class ProjectsController extends AppController {

	var $name = 'Projects';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript','Ajax', 'CustomDisplayFunctions','JQValidator.JQValidator');

	function index() {
		$this->Project->recursive = 0;
		$this->paginate = Set::merge($this->paginate,array('Project'=>array('order' => array('Project.position' => 'ASC'),'limit'=>'10')));
		if(isset($_GET['sel'])){
			if(trim($_GET['sel']=='all')){	
				$this->paginate = Set::merge($this->paginate,array('Project'=>array('order' => array('Project.position' => 'ASC'),'limit'=>'30')));
			} else {
				$this->paginate = Set::merge($this->paginate,array('Project'=>array('conditions' => array('Project.title LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
			}
		}		
		if(isset($_GET['group'])){
			if((int)trim($_GET['group'])>0){
				$this->paginate = Set::merge($this->paginate,array('Project'=>array('conditions' => array('Project.category_id =' => (int)trim($_GET['group'])),'limit'=>'10')));
			}
		}	
		if(isset($_GET['search'])){
			$this->paginate = Set::merge($this->paginate,array('Project'=>array('conditions' => array('Project.title LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
		}
		$this->set('projects', $this->paginate());
		$this->set('instructionText','You can drag and drop the items below to set the order.');
		$this->set('orderStatus', 'PROJECTS Ordering Succesfully Saved!');
		$this->loadModel('ProjectsCategory'); //if it's not already loaded
		$options = $this->ProjectsCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$this->set('helpURL','projects');
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid project', true), array('action' => 'index'));
		}
		$this->set('project', $this->Project->read(null, $id));
		$this->layout='front-end-website';
		$moduleHeading = "our projects";
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','projects');
	}

	function add() {
		if (!empty($this->data)) {
			$this->Project->create();
			if ($this->Project->save($this->data)) {
				$this->flash(__('Project saved.', true), array('action' => 'index'));
			} else {
			}
		}
		$this->layout='add-edit';
		$ckeditorClass = '';
		$this->set('ckeditorClass', $ckeditorClass);
		$ckfinderPath = Configure::read('Company.url').'dreamcms/app/webroot/js/ckfinder/';
		$this->set('ckfinderPath', $ckfinderPath);
		$this->loadModel('ProjectsCategory'); //if it's not already loaded
		$options = $this->ProjectsCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$this->loadModel('ProjectsLocation'); //if it's not already loaded
		$locOptions = $this->ProjectsLocation->find('all'); //or whatever conditions you want
		$this->set('locOptions',$locOptions);
		$moduleHeading = 'projects';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('maxPosition',$this->Project->find('count'));
		$this->set('helpURL','projects');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Project',
			$this->Project->validate,
			__('Save failed, fix the following errors:', true),
			'ProjectAddForm'
		);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid project', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Project->save($this->data)) {
				$this->flash(__('The project has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Project->read(null, $id);
		}
		$this->layout='add-edit';
		$ckeditorClass = '';
		$this->set('ckeditorClass', $ckeditorClass);
		$ckfinderPath = Configure::read('Company.url').'dreamcms/app/webroot/js/ckfinder/';
		$this->set('ckfinderPath', $ckfinderPath);
		$this->loadModel('ProjectsCategory'); //if it's not already loaded
		$options = $this->ProjectsCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$this->loadModel('ProjectsLocation'); //if it's not already loaded
		$locOptions = $this->ProjectsLocation->find('all'); //or whatever conditions you want
		$this->set('locOptions',$locOptions);
		$moduleHeading = 'projects';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','projects');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Project',
			$this->Project->validate,
			__('Save failed, fix the following errors:', true),
			'ProjectEditForm'
		);
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid project', true)), array('action' => 'index'));
		}
		if ($this->Project->delete($id)) {
			$this->flash(__('Project deleted', true), array('action' => 'index'));
		}
		$this->flash(__('Project was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function publish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid Project', true)), array('action' => 'index'));
		}
		if ($this->Project->saveField('live',1,false)) {
			$this->flash(__('Project published', true), array('action' => 'index'));
		}
		$this->flash(__('Project was not published', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function unpublish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid Project', true)), array('action' => 'index'));
		}
		if ($this->Project->saveField('live',0,false)) {
			$this->flash(__('Project unpublished', true), array('action' => 'index'));
		}
		$this->flash(__('Project was not unpublished', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function markFeatured($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid Project', true)), array('action' => 'index'));
		}
		if ($this->Project->saveField('featured',1,false)) {
			$this->flash(__('Project marked as featured', true), array('action' => 'index'));
		}
		$this->flash(__('Project was not marked as featured', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function unmarkFeatured($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid Project', true)), array('action' => 'index'));
		}
		if ($this->Project->saveField('featured',0,false)) {
			$this->flash(__('Project removed from featured', true), array('action' => 'index'));
		}
		$this->flash(__('Project was not removed from featured', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	/** Receives ajax request from index **/
	function order(){
	//loop through the data sent via the ajax call
		foreach ($this->params['form']['projects'] as $order => $id){
			$data['Project']['position'] = $order;
			$this->Project->id = $id;
			if($this->Project->saveField('position',$order)) {
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
			if($this->Project->saveField($fldName,'')){
				//we have successfully deleted file from DB
				$this->redirect(array('action' => 'edit/'.$id));
			}
		} else {
			//deal with possible errors!
		}
		$this->autoRender=false;
	}
}
