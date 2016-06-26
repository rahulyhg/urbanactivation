<?php
class PropertiesRegion extends AppModel {
	var $name = 'PropertiesRegion';
	var $displayField = 'id';
	var $validate = array(
		'region' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter region name.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
