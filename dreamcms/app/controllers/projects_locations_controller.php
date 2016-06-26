<?php
class ProjectsLocationsController extends AppController {

	var $name = 'ProjectsLocations';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			$this->ProjectsLocation->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('ProjectsLocation'=>array('order' => array('ProjectsLocation.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('ProjectsLocation'=>array('order' => array('ProjectsLocation.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('ProjectsLocation'=>array('conditions' => array('ProjectsLocation.location LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('ProjectsLocation'=>array('conditions' => array('ProjectsLocation.location LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('projectsLocations', $this->paginate());
			$hasNoProjectItems = $this->ProjectsLocation->find('all', array('conditions'=> 'ProjectsLocation.id NOT IN (SELECT Projects.location_id from projects AS Projects)'));
			$this->set('hasNoProjectItems',$hasNoProjectItems);
			$moduleHeading = 'property locations';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','projects');
		}
	}

	function view($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(__('Invalid projects location', true), array('action' => 'index'));
			}
			$this->set('projectsLocation', $this->ProjectsLocation->read(null, $id));
			$this->set('helpURL','projects');
		}
	}

	function add() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!empty($this->data)) {
				$this->ProjectsLocation->create();
				if ($this->ProjectsLocation->save($this->data)) {
					$this->flash(__('Projectslocation saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$moduleHeading = 'property locations';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','projects');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'ProjectsLocation',
				$this->ProjectsLocation->validate,
				__('Save failed, fix the following errors:', true),
				'ProjectsLocationAddForm'
			);
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!$id && empty($this->data)) {
				$this->flash(sprintf(__('Invalid projects location', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->ProjectsLocation->save($this->data)) {
					$this->flash(__('The projects location has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->ProjectsLocation->read(null, $id);
			}		
			$this->layout='add-edit';
			$moduleHeading = 'property locations';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','projects');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'ProjectsLocation',
				$this->ProjectsLocation->validate,
				__('Save failed, fix the following errors:', true),
				'ProjectsLocationEditForm'
			);
		}
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid projects location', true)), array('action' => 'index'));
			}
			if ($this->ProjectsLocation->delete($id)) {
				$this->flash(__('Projects location deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Projects location was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
