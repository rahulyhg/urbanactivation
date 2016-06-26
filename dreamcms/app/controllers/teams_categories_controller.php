<?php
class TeamsCategoriesController extends AppController {

	var $name = 'TeamsCategories';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			$this->TeamsCategory->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('TeamsCategory'=>array('order' => array('TeamsCategory.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('TeamsCategory'=>array('order' => array('TeamsCategory.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('TeamsCategory'=>array('conditions' => array('TeamsCategory.category LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('TeamsCategory'=>array('conditions' => array('TeamsCategory.category LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('teamsCategories', $this->paginate());
			$hasNoTeamItems = $this->TeamsCategory->find('all', array('conditions'=> 'TeamsCategory.id NOT IN (SELECT Teams.category_id from teams AS Teams)'));
			$this->set('hasNoTeamItems',$hasNoTeamItems);
			$this->set('helpURL','teams');
		}
	}

	function view($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(__('Invalid teams category', true), array('action' => 'index'));
			}
			$this->set('teamsCategory', $this->TeamsCategory->read(null, $id));
			$this->set('helpURL','teams');
		}
	}

	function add() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!empty($this->data)) {
				$this->TeamsCategory->create();
				if ($this->TeamsCategory->save($this->data)) {
					$this->flash(__('Teamscategory saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$moduleHeading = 'team categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','teams');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'TeamsCategory',
				$this->TeamsCategory->validate,
				__('Save failed, fix the following errors:', true),
				'TeamsCategoryAddForm'
			);
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!$id && empty($this->data)) {
				$this->flash(sprintf(__('Invalid teams category', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->TeamsCategory->save($this->data)) {
					$this->flash(__('The teams category has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->TeamsCategory->read(null, $id);
			}		
			$this->layout='add-edit';
			$moduleHeading = 'team categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','teams');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'TeamsCategory',
				$this->TeamsCategory->validate,
				__('Save failed, fix the following errors:', true),
				'TeamsCategoryEditForm'
			);
		}
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid teams category', true)), array('action' => 'index'));
			}
			if ($this->TeamsCategory->delete($id)) {
				$this->flash(__('Teams category deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Teams category was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
