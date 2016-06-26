<?php
class PropertiesTypesController extends AppController {

	var $name = 'PropertiesTypes';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			$this->PropertiesType->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('PropertiesType'=>array('order' => array('PropertiesType.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('PropertiesType'=>array('order' => array('PropertiesType.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('PropertiesType'=>array('conditions' => array('PropertiesType.type LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('PropertiesType'=>array('conditions' => array('PropertiesType.type LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('propertiesTypes', $this->paginate());
			$hasNoPropertiesItems = $this->PropertiesType->find('all', array('conditions'=> 'PropertiesType.id NOT IN (SELECT Properties.type_id from properties AS Properties)'));
			$this->set('hasNoPropertiesItems',$hasNoPropertiesItems);
			$moduleHeading = 'property types';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','properties');
		}
	}

	function view($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(__('Invalid properties type', true), array('action' => 'index'));
			}
			$this->set('propertiesType', $this->PropertiesType->read(null, $id));
			$this->set('helpURL','properties');
		}
	}

	function add() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!empty($this->data)) {
				$this->PropertiesType->create();
				if ($this->PropertiesType->save($this->data)) {
					$this->flash(__('Propertiestype saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$moduleHeading = 'property types';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','properties');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'PropertiesType',
				$this->PropertiesType->validate,
				__('Save failed, fix the following errors:', true),
				'PropertiesTypeAddForm'
			);
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!$id && empty($this->data)) {
				$this->flash(sprintf(__('Invalid properties type', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->PropertiesType->save($this->data)) {
					$this->flash(__('The properties type has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->PropertiesType->read(null, $id);
			}		
			$this->layout='add-edit';
			$moduleHeading = 'property types';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','properties');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'PropertiesType',
				$this->PropertiesType->validate,
				__('Save failed, fix the following errors:', true),
				'PropertiesTypeEditForm'
			);
		}
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid properties type', true)), array('action' => 'index'));
			}
			if ($this->PropertiesType->delete($id)) {
				$this->flash(__('Properties type deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Properties type was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
