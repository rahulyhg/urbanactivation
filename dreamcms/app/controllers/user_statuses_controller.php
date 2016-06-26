<?php
class UserStatusesController extends AppController {

	var $name = 'UserStatuses';

	function index() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			$this->UserStatus->recursive = 0;
			$this->set('userStatuses', $this->paginate());
			$this->set('helpURL','users');
		}
	}

	function view($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(__('Invalid user status', true), array('action' => 'index'));
			}
			$this->set('userStatus', $this->UserStatus->read(null, $id));
			$this->set('helpURL','users');
		}
	}

	function add() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!empty($this->data)) {
				$this->UserStatus->create();
				if ($this->UserStatus->save($this->data)) {
					$this->flash(__('Userstatus saved.', true), array('action' => 'index'));
				} else {
				}
			}
			$this->set('helpURL','users');
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!$id && empty($this->data)) {
				$this->flash(sprintf(__('Invalid user status', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->UserStatus->save($this->data)) {
					$this->flash(__('The user status has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->UserStatus->read(null, $id);
			}
			$this->set('helpURL','users');
		}
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid user status', true)), array('action' => 'index'));
			}
			if ($this->UserStatus->delete($id)) {
				$this->flash(__('User status deleted', true), array('action' => 'index'));
			}
			$this->flash(__('User status was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
