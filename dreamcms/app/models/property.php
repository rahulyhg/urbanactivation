<?php
class Property extends AppModel {
	var $name = 'Property';
	var $displayField = 'title';

	function beforeValidate() {
		// join teams into csv
		if(!empty($this->data['Property']['numBedrooms'])) {
			$this->data['Property']['numBedrooms'] = join(',', $this->data['Property']['numBedrooms']);
		}
		if(!empty($this->data['Property']['numBathrooms'])) {
			$this->data['Property']['numBathrooms'] = join(',', $this->data['Property']['numBathrooms']);
		}
		if(!empty($this->data['Property']['numParking'])) {
			$this->data['Property']['numParking'] = join(',', $this->data['Property']['numParking']);
		}
	
		return true;
	}

	function afterSave($created) {  
		//	var_dump($this);   // TEST
		//	echo $this->id." :: "; // TEST
		// reset any values that may have existed - needs to be recalculated on each 'save'
		$this->data["Property"]["GMLat"] = 0;
		$this->data["Property"]["GMLng"] = 0;
		if(isset($this->data["Property"]["address"])) {  // avoid this code if the function executes from the index.ctp file
			if(strlen($this->data["Property"]["address"])>0 && strlen($this->data["Property"]["suburb"])>0 && strlen($this->data["Property"]["state"])>0) {
				// obtain GPS co-ordinates from Google Maps
				$location = urlencode($this->data["Property"]["address"]." ".$this->data["Property"]["suburb"]." ".$this->data["Property"]["state"]." ".$this->data["Property"]["postcode"]." Australia");
				$var = file_get_contents("http://maps.google.com.au/maps?output=js&q=$location"); 
				$x = split("latlng:{", $var);
				$y = split("},ssdetailseditable", $x[1]);
				$latlong=explode(",",$y[0]); 
				//$lat = substr(substr($latlong[0], 0, -1), 5); 
				$this->data["Property"]["GMLat"] = str_replace("lat:", "", $latlong[0]);
				//$long = substr(substr($latlong[1], 0, -1), 5); 
				$this->data["Property"]["GMLng"] = str_replace("}", "", str_replace("lng:", "", $latlong[1]));
				//echo "<br>".$this->data["Property"]["GMLat"].", ".$this->data["Property"]["GMLng"];  //TEST
				//echo "<br>update properties set GMLat=".$this->data["Property"]["GMLat"].", GMLng=".$this->data["Property"]["GMLng"]." where id=".$this->id;  // TEST
			}
			$this->query("update properties set GMLat=".$this->data["Property"]["GMLat"].", GMLng=".$this->data["Property"]["GMLng"]." where id=".$this->id);
		}
		return true;
	}

	var $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter title of the property.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'shortDescription' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter some text in the Short Description.',
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
//		'featured' => array(
//			'numeric' => array(
//				'rule' => array('numeric'),
//				'message' => 'Featured value must be numeric.',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
		'live' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Live value must be numeric.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'position' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Position value must be numeric.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'category_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Category value must be numeric.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
