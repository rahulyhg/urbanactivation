<?php
class NewsController extends AppController {

	var $name = 'News';
	var $components = array('JQValidator.JQValidator','RSS');
	var $helpers = array('Form', 'Html', 'Javascript', 'Time', 'FormatEpochToDate', 'CustomDisplayFunctions','JQValidator.JQValidator');
	
	function index() {
		$this->News->recursive = 0;		
		$recordCount = $this->News->find('count');
		if(isset($_GET['sel'])){
			if(trim($_GET['sel']=='all')){	
				$this->paginate = Set::merge($this->paginate,array('News'=>array('order' => array('News.startDate' => 'DESC'),'limit'=>$recordCount)));
			} else {
				//find total count of records
				$recordCount = $this->News->find('count',array('conditions' => array('News.title LIKE' => ''.trim($_GET['sel']).'%')));
				$this->paginate = Set::merge($this->paginate,array('News'=>array('conditions' => array('News.title LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>$recordCount)));
			}
		} elseif(isset($_GET['group'])){
			if((int)trim($_GET['group'])>0){
				//find total count of records
				$recordCount = $this->News->find('count',array('conditions' => array('News.category_id =' => (int)trim($_GET['group']))));
				$this->paginate = Set::merge($this->paginate,array('News'=>array('conditions' => array('News.category_id =' => (int)trim($_GET['group'])),'limit'=>$recordCount)));
			}
		} elseif(isset($_GET['search'])){
			//find total count of records
			$recordCount = $this->News->find('count',array('conditions' => array('News.title LIKE' => '%'.trim($_GET['search']).'%')));
			$this->paginate = Set::merge($this->paginate,array('News'=>array('conditions' => array('News.title LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>$recordCount)));
		} else {
			$this->paginate = Set::merge($this->paginate,array('News'=>array('order' => array('News.startDate' => 'DESC'),'limit'=>$recordCount)));	
		}
		$this->set('news', $this->paginate());		
		$this->loadModel('NewsCategory'); //if it's not already loaded
		$options = $this->NewsCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$pageLimit = 10;
		$this->set('pageLimit',$pageLimit);
		$this->set('helpURL','news');
		$this->RSS->writeFeed(); //generate RSS XML when the index page loads
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid news', true), array('action' => 'index'));
		}
		$this->set('news', $this->News->read(null, $id));
		$this->layout='front-end-website';
		$moduleHeading = 'our news';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','news');
	}

	function add() {
		if (!empty($this->data)) {
			$this->News->create();
			if ($this->News->save($this->data)) {
				$this->flash(__('News saved.', true), array('action' => 'index'));
			} else {
			}
		}
		$this->layout='add-edit';
		$ckeditorClass = '';
		$this->set('ckeditorClass', $ckeditorClass);
		$ckfinderPath = Configure::read('Company.wysiwyg').'dreamcms/app/webroot/js/ckfinder/';
		$this->set('ckfinderPath', $ckfinderPath);
		$this->loadModel('NewsCategory'); //if it's not already loaded
		$options = $this->NewsCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
//		$team = ClassRegistry::init('Team');
//		$teams_list = $team->find('all');
//		$this->set('teams_list',$teams_list);
//		$branch = ClassRegistry::init('Branch');
//		$branches_list = $branch->find('all');
//		$this->set('branches_list',$branches_list);
		$moduleHeading = 'news items';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','news');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'News',
			$this->News->validate,
			__('Save failed, fix the following errors:', true),
			'NewsAddForm'
		);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid news', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->News->save($this->data)) {
				$this->flash(__('The news has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->News->read(null, $id);
		}
		$this->layout='add-edit';
		$ckeditorClass = '';
		$this->set('ckeditorClass', $ckeditorClass);
		$ckfinderPath = Configure::read('Company.wysiwyg').'dreamcms/app/webroot/js/ckfinder/';
		$this->set('ckfinderPath', $ckfinderPath);
		$this->loadModel('NewsCategory'); //if it's not already loaded
		$options = $this->NewsCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
//		$team = ClassRegistry::init('Team');
//		$teams_list = $team->find('all');
//		$this->set('teams_list',$teams_list);
//		$branch = ClassRegistry::init('Branch');
//		$branches_list = $branch->find('all');
//		$this->set('branches_list',$branches_list);
		$moduleHeading = 'news items';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','news');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'News',
			$this->News->validate,
			__('Save failed, fix the following errors:', true),
			'NewsEditForm'
		);		
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid news', true)), array('action' => 'index'));
		}
		if ($this->News->delete($id)) {
			$this->flash(__('News deleted', true), array('action' => 'index'));
		}
		$this->flash(__('News was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function publish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid news', true)), array('action' => 'index'));
		}
		if ($this->News->saveField('live',1,false)) {
			$this->flash(__('News published', true), array('action' => 'index'));
		}
		$this->flash(__('News was not published', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function unpublish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid news', true)), array('action' => 'index'));
		}
		if ($this->News->saveField('live',0,false)) {
			$this->flash(__('News unpublished', true), array('action' => 'index'));
		}
		$this->flash(__('News was not unpublished', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
}
?>