<?php

class Team extends AppModel {

	var $name = 'Team';

	var $displayField = 'name';

	function beforeValidate() {

		//join branches into csv

		if(!empty($this->data['Team']['branches'])) {

			$this->data['Team']['branches'] = join(',', $this->data['Team']['branches']);

		}

	

		return true;

	}

	var $validate = array(

		'name' => array(

			'notempty' => array(

				'rule' => array('notempty'),

				'message' => 'Please enter Name of the Team Member.',

				//'allowEmpty' => false,

				//'required' => false,

				//'last' => false, // Stop validation after this rule

				//'on' => 'create', // Limit validation to 'create' or 'update' operations

			),

		),

		'shortDescription' => array(

			'notempty' => array(

				'rule' => array('notempty'),

				'message' => 'Please enter some text in Short Description.',

				//'allowEmpty' => false,

				//'required' => false,

				//'last' => false, // Stop validation after this rule

				//'on' => 'create', // Limit validation to 'create' or 'update' operations

			),

		),

		'body' => array(

			'notempty' => array(

				'rule' => array('notempty'),

				'message' => 'Please enter some text in the Body.',

				//'allowEmpty' => false,

				//'required' => false,

				//'last' => false, // Stop validation after this rule

				//'on' => 'create', // Limit validation to 'create' or 'update' operations

			),

		),

		'phone' => array(

			'numeric' => array(

				'rule' => array('notempty'),

				'message' => 'Please enter valid phone number.',

				//'allowEmpty' => false,

				//'required' => false,

				//'last' => false, // Stop validation after this rule

				//'on' => 'create', // Limit validation to 'create' or 'update' operations

			),

		),

		'email' => array(

			'email' => array(

				'rule' => array('email'),

				'message' => 'Please enter valid email address.',

				//'allowEmpty' => false,

				//'required' => false,

				//'last' => false, // Stop validation after this rule

				//'on' => 'create', // Limit validation to 'create' or 'update' operations

			),

		),

		'role' => array(

			'notempty' => array(

				'rule' => array('notempty'),

				'message' => 'Please enter role of the Team Member.',

				//'allowEmpty' => false,

				//'required' => false,

				//'last' => false, // Stop validation after this rule

				//'on' => 'create', // Limit validation to 'create' or 'update' operations

			),

		),

		'live' => array(

			'numeric' => array(

				'rule' => array('numeric'),

				//'message' => 'Your custom message here',

				//'allowEmpty' => false,

				//'required' => false,

				//'last' => false, // Stop validation after this rule

				//'on' => 'create', // Limit validation to 'create' or 'update' operations

			),

		),

		'category_id' => array(

			'numeric' => array(

				'rule' => array('numeric'),

				'message' => 'Please select a category for this Team Member.',

				//'allowEmpty' => false,

				//'required' => false,

				//'last' => false, // Stop validation after this rule

				//'on' => 'create', // Limit validation to 'create' or 'update' operations

			),

		),

	);

}

