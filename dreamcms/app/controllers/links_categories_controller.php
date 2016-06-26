<?php
class LinksCategoriesController extends AppController {

	var $name = 'LinksCategories';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			$this->LinksCategory->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('LinksCategory'=>array('order' => array('LinksCategory.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('LinksCategory'=>array('order' => array('LinksCategory.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('LinksCategory'=>array('conditions' => array('LinksCategory.category LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('LinksCategory'=>array('conditions' => array('LinksCategory.category LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('linksCategories', $this->paginate());
			$hasNoLinkItems = $this->LinksCategory->find('all', array('conditions'=> 'LinksCategory.id NOT IN (SELECT Links.category_id from links AS Links)'));
			$this->set('hasNoLinkItems',$hasNoLinkItems);
			$this->set('helpURL','links');
		}
	}

	function view($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(__('Invalid links category', true), array('action' => 'index'));
			}
			$this->set('LinksCategory', $this->LinksCategory->read(null, $id));
			$this->set('helpURL','links');
		}
	}

	function add() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!empty($this->data)) {
				$this->LinksCategory->create();
				if ($this->LinksCategory->save($this->data)) {
					$this->flash(__('LinksCategory saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$moduleHeading = 'link categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','links');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'LinksCategory',
				$this->LinksCategory->validate,
				__('Save failed, fix the following errors:', true),
				'LinksCategoryAddForm'
			);
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!$id && empty($this->data)) {
				$this->flash(sprintf(__('Invalid links category', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->LinksCategory->save($this->data)) {
					$this->flash(__('The links category has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->LinksCategory->read(null, $id);
			}		
			$this->layout='add-edit';
			$moduleHeading = 'link categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','links');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'LinksCategory',
				$this->LinksCategory->validate,
				__('Save failed, fix the following errors:', true),
				'LinksCategoryEditForm'
			);
		}
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid links category', true)), array('action' => 'index'));
			}
			if ($this->LinksCategory->delete($id)) {
				$this->flash(__('Links category deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Links category was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
