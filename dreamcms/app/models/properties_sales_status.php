<?php
class PropertiesSalesStatus extends AppModel {
	var $name = 'PropertiesSalesStatus';
	var $displayField = 'id';
	var $validate = array(
		'sales_status' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter sales_status name.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
