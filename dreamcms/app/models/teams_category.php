<?php
class TeamsCategory extends AppModel {
	var $name = 'TeamsCategory';
	var $displayField = 'id';
	var $validate = array(
		'category' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter category name.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
