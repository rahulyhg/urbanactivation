<?php
class PropertiesType extends AppModel {
	var $name = 'PropertiesType';
	var $displayField = 'id';
	var $validate = array(
		'type' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter type name.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
