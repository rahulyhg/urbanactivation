<?php
class PropertiesStatus extends AppModel {
	var $name = 'PropertiesStatus';
	var $displayField = 'id';
	var $validate = array(
		'status' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter status name.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
