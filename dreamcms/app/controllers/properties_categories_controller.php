<?php
class PropertiesCategoriesController extends AppController {

	var $name = 'PropertiesCategories';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			$this->PropertiesCategory->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('PropertiesCategory'=>array('order' => array('PropertiesCategory.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('PropertiesCategory'=>array('order' => array('PropertiesCategory.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('PropertiesCategory'=>array('conditions' => array('PropertiesCategory.category LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('PropertiesCategory'=>array('conditions' => array('PropertiesCategory.category LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('propertiesCategories', $this->paginate());
			$hasNoPropertiesItems = $this->PropertiesCategory->find('all', array('conditions'=> 'PropertiesCategory.id NOT IN (SELECT Properties.category_id from properties AS Properties)'));
			$this->set('hasNoPropertiesItems',$hasNoPropertiesItems);
			$moduleHeading = 'property categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','properties');
		}
	}

	function view($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(__('Invalid properties category', true), array('action' => 'index'));
			}
			$this->set('propertiesCategory', $this->PropertiesCategory->read(null, $id));
			$this->set('helpURL','properties');
		}
	}

	function add() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!empty($this->data)) {
				$this->PropertiesCategory->create();
				if ($this->PropertiesCategory->save($this->data)) {
					$this->flash(__('Propertiescategory saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$moduleHeading = 'property categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','properties');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'PropertiesCategory',
				$this->PropertiesCategory->validate,
				__('Save failed, fix the following errors:', true),
				'PropertiesCategoryAddForm'
			);
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!$id && empty($this->data)) {
				$this->flash(sprintf(__('Invalid properties category', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->PropertiesCategory->save($this->data)) {
					$this->flash(__('The properties category has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->PropertiesCategory->read(null, $id);
			}		
			$this->layout='add-edit';
			$moduleHeading = 'prperty categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','properties');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'PropertiesCategory',
				$this->PropertiesCategory->validate,
				__('Save failed, fix the following errors:', true),
				'PropertiesCategoryEditForm'
			);
		}
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid properties category', true)), array('action' => 'index'));
			}
			if ($this->PropertiesCategory->delete($id)) {
				$this->flash(__('Properties category deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Properties category was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
