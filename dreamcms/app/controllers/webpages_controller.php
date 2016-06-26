<?php
class WebpagesController extends AppController {

	var $name = 'Webpages';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript','Ajax', 'CustomDisplayFunctions','JQValidator.JQValidator');

	function index() {
		$this->Webpage->recursive = 0;
		$sortable = false; //disable sorting by default
		$recordCount = $this->Webpage->find('count');
		if(isset($_GET['sort_list']) && trim($_GET['sort_list']=='true')) {//sorting enabled
			$sortable = true;
			$this->paginate = Set::merge($this->paginate,array('Webpage'=>array('order' => array('Webpage.position' => 'ASC'),'limit'=>$recordCount)));
		} elseif(isset($_GET['sel'])){
			if(trim($_GET['sel']=='all')){	
				$this->paginate = Set::merge($this->paginate,array('Webpage'=>array('order' => array('Webpage.position' => 'ASC'),'limit'=>$recordCount)));
			} else {
				//find total count of records
				$recordCount = $this->Webpage->find('count',array('conditions' => array('Webpage.title LIKE' => ''.trim($_GET['sel']).'%')));
				$this->paginate = Set::merge($this->paginate,array('Webpage'=>array('conditions' => array('Webpage.title LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>$recordCount)));
			}
		} elseif(isset($_GET['group'])){
			if((int)trim($_GET['group'])>0){
				$recordCount = $this->Webpage->find('count',array('conditions' => array('Webpage.category_id =' => (int)trim($_GET['group']))));
				$this->paginate = Set::merge($this->paginate,array('Webpage'=>array('conditions' => array('Webpage.category_id =' => (int)trim($_GET['group'])),'limit'=>$recordCount)));
			}
		} elseif(isset($_GET['search'])){
			//find total count of records
			$recordCount = $this->Webpage->find('count',array('conditions' => array('Webpage.title LIKE' => '%'.trim($_GET['search']).'%')));
			$this->paginate = Set::merge($this->paginate,array('Webpage'=>array('conditions' => array('Webpage.title LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>$recordCount)));
		} else {
			$this->paginate = Set::merge($this->paginate,array('Webpage'=>array('order' => array('Webpage.position' => 'ASC'),'limit'=>$recordCount)));
		}
		$this->set('pages', $this->paginate());
		$this->set('instructionText','You can drag and drop the items below to set the order.');
		$this->set('orderStatus', 'PAGE Ordering Succesfully Saved!');
		$this->set('sortable',$sortable);
		$pageLimit = 10;
		$this->set('pageLimit',$pageLimit);
		$this->loadModel('PagesCategory'); //if it's not already loaded
		$options = $this->PagesCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$this->set('helpURL','pages');
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid page', true), array('action' => 'index'));
		}
		$this->set('page', $this->Webpage->read(null, $id));
		$this->layout='front-end-website';
		$moduleHeading = "what we do";
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','pages');
	}

	function add() {
		if (!empty($this->data)) {
			$this->Webpage->create();
			if ($this->Webpage->save($this->data)) {
				$this->flash(__('Webpage saved.', true), array('action' => 'index'));
			} else {
			}
		}
		$this->layout='add-edit';
		$ckeditorClass = '';
		$this->set('ckeditorClass', $ckeditorClass);
		$ckfinderPath = Configure::read('Company.wysiwyg').'dreamcms/app/webroot/js/ckfinder/';
		$this->set('ckfinderPath', $ckfinderPath);
		$this->loadModel('PagesCategory'); //if it's not already loaded
		$options = $this->PagesCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$moduleHeading = 'pages';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('maxPosition',$this->Webpage->find('count'));
		$this->set('helpURL','pages');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Webpage',
			$this->Webpage->validate,
			__('Save failed, fix the following errors:', true),
			'WebpageAddForm'
		);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid page', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Webpage->save($this->data)) {
				$this->flash(__('The page has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Webpage->read(null, $id);
		}
		$this->layout='add-edit';
		$ckeditorClass = '';
		$this->set('ckeditorClass', $ckeditorClass);
		$ckfinderPath = Configure::read('Company.wysiwyg').'dreamcms/app/webroot/js/ckfinder/';
		$this->set('ckfinderPath', $ckfinderPath);
		$this->loadModel('PagesCategory'); //if it's not already loaded
		$options = $this->PagesCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$moduleHeading = 'pages';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','pages');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Webpage',
			$this->Webpage->validate,
			__('Save failed, fix the following errors:', true),
			'WebpageEditForm'
		);
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid page', true)), array('action' => 'index'));
		}
		if ($this->Webpage->delete($id)) {
			$this->flash(__('Webpage deleted', true), array('action' => 'index'));
		}
		$this->flash(__('Webpage was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	
	function publish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid page', true)), array('action' => 'index'));
		}
		if ($this->Webpage->saveField('live',1,false)) {
			$this->flash(__('Webpage published', true), array('action' => 'index'));
		}
		$this->flash(__('Webpage was not published', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function unpublish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid page', true)), array('action' => 'index'));
		}
		if ($this->Webpage->saveField('live',0,false)) {
			$this->flash(__('Webpage unpublished', true), array('action' => 'index'));
		}
		$this->flash(__('Webpage was not unpublished', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	/** Receives ajax request from index **/
	function order(){
	//loop through the data sent via the ajax call
		foreach ($this->params['form']['webpages'] as $order => $id){
			$data['Webpage']['position'] = $order;
			$this->Webpage->id = $id;
			if($this->Webpage->saveField('position',$order)) {
				//we have success!
			} else {
				//deal with possible errors!
			}
		}
		$this->autoRender=false;
	}
	function deletefile($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid File Name', true)), array('action' => 'index'));
		}
		if($this->Webpage->saveField('photo','')){
			//we have successfully deleted file from DB
			$this->redirect(array('action' => 'edit/'.$id));
		} else {
			//deal with possible errors!
		}
		$this->autoRender=false;
	}
}
