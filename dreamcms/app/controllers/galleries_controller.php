<?php
class GalleriesController extends AppController {

	var $name = 'Galleries';
	var $components = array('RequestHandler','JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript','Ajax', 'CustomDisplayFunctions','JQValidator.JQValidator');

	function index() {
		$this->Gallery->recursive = -1;
		$this->paginate['Gallery'] = array(
			'limit' => 12
		);
		$galleries = $this->paginate('Gallery');
		$this->set(compact('galleries'));
	}

	function add() {
		if (!empty($this->data)) {

			if ($this->Gallery->save($this->data)) {
				$result = '<div id="status">success</div>';
				$result .= '<div id="message">Successfully Uploaded</div>';
			} else {
				$result = "<div id='status'>error</div>";
				$result .= '<div id="message">'. $this->Gallery->validationErrors['file'] .'</div>';
			}

			$this->RequestHandler->renderAs($this, 'ajax');
			$this->set('result', $result);
			$this->render('../elements/ajax');
		}
		$moduleHeading = 'galleries';
		$this->set('moduleHeading',$moduleHeading);		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Gallery',
			$this->Gallery->validate,
			__('Save failed, fix the following errors:', true),
			'GalleryAddForm'
		);
	}

	function html5() {
		$this->layout = 'html5';
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Image', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Gallery->delete($id)) {
			$result = "success";
		}else{
			$result = "failed";
		}
		$this->RequestHandler->renderAs($this, 'ajax');
		$this->set('result', $result);
		$this->render('../elements/ajax');
	}

}
?>