<?php
class PropertiesStatusesController extends AppController {

	var $name = 'PropertiesStatuses';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			$this->PropertiesStatus->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('PropertiesStatus'=>array('order' => array('PropertiesStatus.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('PropertiesStatus'=>array('order' => array('PropertiesStatus.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('PropertiesStatus'=>array('conditions' => array('PropertiesStatus.status LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('PropertiesStatus'=>array('conditions' => array('PropertiesStatus.status LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('propertiesStatuses', $this->paginate());
			$hasNoPropertiesItems = $this->PropertiesStatus->find('all', array('conditions'=> 'PropertiesStatus.id NOT IN (SELECT Properties.status_id from properties AS Properties)'));
			$this->set('hasNoPropertiesItems',$hasNoPropertiesItems);
			$moduleHeading = 'property statuses';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','properties');
		}
	}

	function view($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(__('Invalid property status', true), array('action' => 'index'));
			}
			$this->set('propertiesStatus', $this->PropertiesStatus->read(null, $id));
			$this->set('helpURL','properties');
		}
	}

	function add() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!empty($this->data)) {
				$this->PropertiesStatus->create();
				if ($this->PropertiesStatus->save($this->data)) {
					$this->flash(__('Propertiesstatus saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$moduleHeading = 'property statuses';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','properties');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'PropertiesStatus',
				$this->PropertiesStatus->validate,
				__('Save failed, fix the following errors:', true),
				'PropertiesStatusAddForm'
			);
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!$id && empty($this->data)) {
				$this->flash(sprintf(__('Invalid property status', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->PropertiesStatus->save($this->data)) {
					$this->flash(__('The property status has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->PropertiesStatus->read(null, $id);
			}		
			$this->layout='add-edit';
			$moduleHeading = 'property statuses';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','properties');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'PropertiesStatus',
				$this->PropertiesStatus->validate,
				__('Save failed, fix the following errors:', true),
				'PropertiesStatusEditForm'
			);
		}
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid property status', true)), array('action' => 'index'));
			}
			if ($this->PropertiesStatus->delete($id)) {
				$this->flash(__('Property status deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Property status was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
