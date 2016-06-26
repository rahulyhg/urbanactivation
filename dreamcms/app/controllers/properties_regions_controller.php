<?php
class PropertiesRegionsController extends AppController {

	var $name = 'PropertiesRegions';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			$this->PropertiesRegion->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('PropertiesRegion'=>array('order' => array('PropertiesRegion.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('PropertiesRegion'=>array('order' => array('PropertiesRegion.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('PropertiesRegion'=>array('conditions' => array('PropertiesRegion.region LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('PropertiesRegion'=>array('conditions' => array('PropertiesRegion.region LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('propertiesRegions', $this->paginate());
			$hasNoPropertiesItems = $this->PropertiesRegion->find('all', array('conditions'=> 'PropertiesRegion.id NOT IN (SELECT Properties.region_id from properties AS Properties)'));
			$this->set('hasNoPropertiesItems',$hasNoPropertiesItems);
			$moduleHeading = 'property regions';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','properties');
		}
	}

	function view($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(__('Invalid properties region', true), array('action' => 'index'));
			}
			$this->set('propertiesRegion', $this->PropertiesRegion->read(null, $id));
			$this->set('helpURL','properties');
		}
	}

	function add() {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!empty($this->data)) {
				$this->PropertiesRegion->create();
				if ($this->PropertiesRegion->save($this->data)) {
					$this->flash(__('Propertiesregion saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$moduleHeading = 'property regions';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','properties');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'PropertiesRegion',
				$this->PropertiesRegion->validate,
				__('Save failed, fix the following errors:', true),
				'PropertiesRegionAddForm'
			);
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!$id && empty($this->data)) {
				$this->flash(sprintf(__('Invalid properties region', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->PropertiesRegion->save($this->data)) {
					$this->flash(__('The properties region has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->PropertiesRegion->read(null, $id);
			}		
			$this->layout='add-edit';
			$moduleHeading = 'property regions';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','properties');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'PropertiesRegion',
				$this->PropertiesRegion->validate,
				__('Save failed, fix the following errors:', true),
				'PropertiesRegionEditForm'
			);
		}
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'properties','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid properties region', true)), array('action' => 'index'));
			}
			if ($this->PropertiesRegion->delete($id)) {
				$this->flash(__('Properties region deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Properties region was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
