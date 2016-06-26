<?php
class PropertiesSalesStatusesController extends AppController {

	var $name = 'PropertiesSalesStatuses';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			$this->PropertiesSalesStatus->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('PropertiesSalesStatus'=>array('order' => array('PropertiesSalesStatus.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('PropertiesSalesStatus'=>array('order' => array('PropertiesSalesStatus.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('PropertiesSalesStatus'=>array('conditions' => array('PropertiesSalesStatus.sales_status LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('PropertiesSalesStatus'=>array('conditions' => array('PropertiesSalesStatus.sales_status LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('propertiesSalesStatuses', $this->paginate());
			$hasNoPropertiesItems = $this->PropertiesSalesStatus->find('all', array('conditions'=> 'PropertiesSalesStatus.id NOT IN (SELECT Properties.sales_status_id from properties AS Properties)'));
			$this->set('hasNoPropertiesItems',$hasNoPropertiesItems);
			$moduleHeading = 'property sales statuses';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','properties');
		}
	}

	function view($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(__('Invalid property sales status', true), array('action' => 'index'));
			}
			$this->set('propertiesSalesStatus', $this->PropertiesSalesStatus->read(null, $id));
			$this->set('helpURL','properties');
		}
	}

	function add() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!empty($this->data)) {
				$this->PropertiesSalesStatus->create();
				if ($this->PropertiesSalesStatus->save($this->data)) {
					$this->flash(__('Propertiessales_status saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$moduleHeading = 'property sales statuses';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','properties');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'PropertiesSalesStatus',
				$this->PropertiesSalesStatus->validate,
				__('Save failed, fix the following errors:', true),
				'PropertiesSalesStatusAddForm'
			);
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!$id && empty($this->data)) {
				$this->flash(sprintf(__('Invalid property sales status', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->PropertiesSalesStatus->save($this->data)) {
					$this->flash(__('The property sales status has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->PropertiesSalesStatus->read(null, $id);
			}		
			$this->layout='add-edit';
			$moduleHeading = 'property sales statuses';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','properties');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'PropertiesSalesStatus',
				$this->PropertiesSalesStatus->validate,
				__('Save failed, fix the following errors:', true),
				'PropertiesSalesStatusEditForm'
			);
		}
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid property sales status', true)), array('action' => 'index'));
			}
			if ($this->PropertiesSalesStatus->delete($id)) {
				$this->flash(__('Property sales status deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Property sales status was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
