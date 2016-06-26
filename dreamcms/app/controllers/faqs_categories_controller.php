<?php
class FaqsCategoriesController extends AppController {

	var $name = 'FaqsCategories';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			$this->FaqsCategory->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('FaqsCategory'=>array('order' => array('FaqsCategory.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('FaqsCategory'=>array('order' => array('FaqsCategory.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('FaqsCategory'=>array('conditions' => array('FaqsCategory.category LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('FaqsCategory'=>array('conditions' => array('FaqsCategory.category LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('faqsCategories', $this->paginate());
			$hasNoFaqsItems = $this->FaqsCategory->find('all', array('conditions'=> 'FaqsCategory.id NOT IN (SELECT Faqs.category_id from faqs AS Faqs)'));
			$this->set('hasNoFaqsItems',$hasNoFaqsItems);
			$this->set('helpURL','faqs');
		}
	}

	function view($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(__('Invalid faqs category', true), array('action' => 'index'));
			}
			$this->set('faqsCategory', $this->FaqsCategory->read(null, $id));
			$this->set('helpURL','faqs');
		}
	}

	function add() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!empty($this->data)) {
				$this->FaqsCategory->create();
				if ($this->FaqsCategory->save($this->data)) {
					$this->flash(__('Faqscategory saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$moduleHeading = 'faq categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','faqs');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'FaqsCategory',
				$this->FaqsCategory->validate,
				__('Save failed, fix the following errors:', true),
				'FaqsCategoryAddForm'
			);
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!$id && empty($this->data)) {
				$this->flash(sprintf(__('Invalid faqs category', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->FaqsCategory->save($this->data)) {
					$this->flash(__('The faqs category has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->FaqsCategory->read(null, $id);
			}		
			$this->layout='add-edit';
			$moduleHeading = 'faq categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','faqs');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'FaqsCategory',
				$this->FaqsCategory->validate,
				__('Save failed, fix the following errors:', true),
				'FaqsCategoryEditForm'
			);
		}
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid faqs category', true)), array('action' => 'index'));
			}			
			if ($this->FaqsCategory->delete($id)) {
				$this->flash(__('Faqs category deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Faqs category was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
