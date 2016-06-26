<?php
class ProjectsCategoriesController extends AppController {

	var $name = 'ProjectsCategories';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			$this->ProjectsCategory->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('ProjectsCategory'=>array('order' => array('ProjectsCategory.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('ProjectsCategory'=>array('order' => array('ProjectsCategory.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('ProjectsCategory'=>array('conditions' => array('ProjectsCategory.category LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('ProjectsCategory'=>array('conditions' => array('ProjectsCategory.category LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('projectsCategories', $this->paginate());
			$hasNoProjectItems = $this->ProjectsCategory->find('all', array('conditions'=> 'ProjectsCategory.id NOT IN (SELECT Projects.category_id from projects AS Projects)'));
			$this->set('hasNoProjectItems',$hasNoProjectItems);
			$this->set('helpURL','projects');
		}
	}

	function view($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(__('Invalid projects category', true), array('action' => 'index'));
			}
			$this->set('projectsCategory', $this->ProjectsCategory->read(null, $id));
			$this->set('helpURL','projects');
		}
	}

	function add() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!empty($this->data)) {
				$this->ProjectsCategory->create();
				if ($this->ProjectsCategory->save($this->data)) {
					$this->flash(__('Projectscategory saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$moduleHeading = 'project categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','projects');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'ProjectsCategory',
				$this->ProjectsCategory->validate,
				__('Save failed, fix the following errors:', true),
				'ProjectsCategoryAddForm'
			);
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!$id && empty($this->data)) {
				$this->flash(sprintf(__('Invalid projects category', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->ProjectsCategory->save($this->data)) {
					$this->flash(__('The projects category has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->ProjectsCategory->read(null, $id);
			}		
			$this->layout='add-edit';
			$moduleHeading = 'project categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','projects');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'ProjectsCategory',
				$this->ProjectsCategory->validate,
				__('Save failed, fix the following errors:', true),
				'ProjectsCategoryEditForm'
			);
		}
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid projects category', true)), array('action' => 'index'));
			}
			if ($this->ProjectsCategory->delete($id)) {
				$this->flash(__('Projects category deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Projects category was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
