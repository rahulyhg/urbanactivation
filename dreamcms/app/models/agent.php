<?php
class Agent extends AppModel {
	var $name = 'Agent';
	var $displayField = 'title';
	
	private  $id_deleted;
	function beforeDelete($cascade = true) {
		$this->id_deleted = $this->id;
		return true;
	}
	
	
	var $validate = array(
		'firstname' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter first name of the Agent.',				
			),
		),
		    
		'lastname' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter last name of the Agent.',				
			),
		),            
            'email' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter member email.',				
			),
		),
            'phone' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter member contact phone.',				
			),
		),
            
            'company' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter company.',				
			),
		),
	);
}
