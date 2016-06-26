<?php
class ProjectsLocation extends AppModel {
	var $name = 'ProjectsLocation';
	var $displayField = 'id';
	var $validate = array(
		'location' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter location.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
