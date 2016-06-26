<?php
class PropertiesController extends AppController {

	var $name = 'Properties';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'Ajax', 'CustomDisplayFunctions', 'ImageGallery', 'JQValidator.JQValidator');
         
        function getCompletionDate()    {
            date_default_timezone_set('Australia/Victoria');  
            $year = date('Y');          
            $expirayDate = "31/12/" . $year;           
            return $expirayDate;
        } 
        
     function deleteFullDirectory($dir){
             if( !file_exists($dir) ){
                 return;
             }
            $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($it,
            RecursiveIteratorIterator::CHILD_FIRST);

            foreach($files as $file) {
                if ($file->isDir()){
                rmdir($file->getRealPath());
                } else {
                unlink($file->getRealPath());
                }
            }
            rmdir($dir);
        }
        
         function saveOtherDocsInDB($id, $propertyDirName = NULL){
            // rename directory to actual property id
            if( !empty($propertyDirName) && strlen($propertyDirName) == 8){
             rename(WWW_ROOT.'uploads/otherdocs/'.$propertyDirName, WWW_ROOT.'uploads/otherdocs/'.$id);
            }
            
            date_default_timezone_set('Australia/Victoria');
            $todayDate = date('Y-m-d');  
            $this->loadModel('Property'); //if it's not already loaded
           
            $uploadDirPath = WWW_ROOT . 'uploads/otherdocs/' . $id;
            $savedList =  @$_POST['saved_otherdocs_list']; 
            $newList =  @$_POST['added_otherdocs_list']; 
            $deletedList =  @$_POST['deleted_otherdocs_list'];
            // remove entry from db
             $arrayDelPosition = explode(',', $deletedList);
             foreach($arrayDelPosition as $position ){
             if(empty($position)){
                 continue;
             } 
             $this->Property->query("DELETE FROM `properties_multidocs` where pid = $id and position = $position;");
           }
            
            $arraySavedPosition = explode(',', $savedList);
            foreach($arraySavedPosition as $position ){
             if(empty($position)){
                 continue;
             }          
             $displayName = $_POST['PropertyOtherDoc_' . $position . '_displayname'];
             $fileName = $_POST['PropertyOtherDoc_' . $position];
             $fileAbsPath = $uploadDirPath . '/' . $fileName;
             $fileSize = 0;
             $fileSize = filesize($fileAbsPath);
            
             if($fileSize !== FALSE){
                 $fileSize = round($fileSize / 1024); // KB
             }
             else{
                 $fileSize = 0;
             }
             
             // if value is empty, delete the row from the table
             if(empty($displayName)){
                 $this->Property->query("DELETE FROM `properties_multidocs` where pid = $id and position = $position AND fieldname='otherdocs';");
             }
             else{
             $this->Property->query("UPDATE `properties_multidocs` SET displayname = '$displayName', filename='$fileName', filesize=$fileSize  where pid = $id and position = $position AND fieldname='otherdocs';");
             }
            }
            
            // insert new fields
             $arrayNewPosition = explode(',', $newList);
             foreach($arrayNewPosition as $position ){
             if(empty($position)){
                 continue;
             }            
             $displayName = $_POST['PropertyOtherDoc_' . $position . '_displayname'];
             $fileName = $_POST['PropertyOtherDoc_' . $position];
             $fileAbsPath = $uploadDirPath . '/' . $fileName;
             $fileSize = 0;
             $fileSize = filesize($fileAbsPath);
             if($fileSize !== FALSE){
                 $fileSize = round($fileSize / 1024); // KB
             }else{$fileSize = 0;}
             
             $query = "INSERT INTO `properties_multidocs` (`pid`, `position`, `fieldname`, `displayname`, `filename`, `dateuploaded`, `filesize`) "
                     . "VALUES($id, $position, 'otherdocs', '$displayName', '$fileName', '$todayDate', $fileSize)";
             //echo $query . '<br>';
             if(!empty($displayName)){
             $this->Property->query($query);
             }
           }
        }
        
	function index() {
		$this->Property->recursive = 0;
		$sortable = false; //disable sorting by default
		$recordCount = $this->Property->find('count'); 
                
                
		if(isset($_GET['sort_list']) && trim($_GET['sort_list']=='true')) {//sorting enabled
			$sortable = true;
			$this->paginate = Set::merge($this->paginate,array('Property'=>array('order' => array('Property.id' => 'DESC'),'limit'=>$recordCount)));
		} elseif(isset($_GET['sel'])){
			if(trim($_GET['sel']=='all')){	
				$this->paginate = Set::merge($this->paginate,array('Property'=>array('order' => array('Property.id' => 'DESC'),'limit'=>$recordCount)));
			} else {
				//find total count of records
				$recordCount = $this->Property->find('count',array('conditions' => array('Property.title LIKE' => ''.trim($_GET['sel']).'%')));
				$this->paginate = Set::merge($this->paginate,array('Property'=>array('conditions' => array('Property.title LIKE' => ''.trim($_GET['sel']).'%'),'order' => array('Property.id' => 'DESC'),'limit'=>$recordCount)));
			}
		} elseif(isset($_GET['group'])){
			if((int)trim($_GET['group'])>0){
				$recordCount = $this->Property->find('count',array('conditions' => array('Property.category_id =' => (int)trim($_GET['group']))));
				$this->paginate = Set::merge($this->paginate,array('Property'=>array('conditions' => array('Property.category_id =' => (int)trim($_GET['group'])),'order' => array('Property.id' => 'DESC'),'limit'=>$recordCount)));
			} else {
				$this->paginate = Set::merge($this->paginate,array('Property'=>array('order' => array('Property.id' => 'DESC'),'limit'=>$recordCount)));
			}
		} elseif(isset($_GET['search'])){
			//find total count of records
			$recordCount = $this->Property->find('count',array('conditions' => array('Property.title LIKE' => '%'.trim($_GET['search']).'%')));
			$this->paginate = Set::merge($this->paginate,array('Property'=>array('conditions' => array('Property.title LIKE' => '%'.trim($_GET['search']).'%'),'order' => array('Property.id' => 'DESC'),'limit'=>$recordCount)));
		} else {
                    $this->paginate = Set::merge($this->paginate,array('Property'=>array('order' => array('Property.id' => 'DESC'),'limit'=>$recordCount)));
		}
		$this->set('properties', $this->paginate());
		$this->set('instructionText','You can drag and drop the items below to set the order.');
		$this->set('orderStatus', 'PROPERTIES Ordering Succesfully Saved!');
		$this->set('sortable',$sortable);
		$pageLimit = 50;
		$this->set('pageLimit',$pageLimit);
		$this->loadModel('PropertiesCategory'); //if it's not already loaded
		$options = $this->PropertiesCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$this->set('helpURL','properties');
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid property', true), array('action' => 'index'));
		}
		$this->set('property', $this->Property->read(null, $id));
		$this->layout='front-end-website';
		$moduleHeading = "our properties";
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','properties');
	}

	function add() {
		if (!empty($this->data)) {
			$this->Property->create();
                        $this->data["Property"]["expected_completion_date"] = date('Y-m-d', strtotime(str_replace('/', '-', $this->data["Property"]["completiondate"])));
			if ($this->Property->save($this->data)) {
				//var_dump($this->data);  // TEST
				// obtain latest entry
				$newId = $this->Property->getLastInsertID();
                                // save other docs in db
                                $propertyDirName = $_POST['txtPropertyDirName'];
                                // rename main docs directory name
                                if( !empty($propertyDirName) && strlen($propertyDirName) == 8){
                                rename(WWW_ROOT."uploads/$propertyDirName", WWW_ROOT. "uploads/$newId");
                                }
                                $this->saveOtherDocsInDB($newId, $propertyDirName);
				// update images list with new id
				if(isset($this->params["form"]["ImageId"])) {
					foreach($this->params["form"]["ImageId"] as $v) {
						$res = $this->Property->query("update images set confirmed=1, property_id=".$newId." where id=".$v);
					}
					// rename directory containng images to 'id' value
					rename(WWW_ROOT.'uploads/properties/'.$this->data["Property"]["randomSeed"], WWW_ROOT.'uploads/properties/'.$newId);
				} else {
					// create base directory with no files (future use)
					mkdir(WWW_ROOT.'uploads/properties/'.$newId);               // base
					mkdir(WWW_ROOT.'uploads/properties/'.$newId.'/files');      // sub
					mkdir(WWW_ROOT.'uploads/properties/'.$newId.'/thumbnails'); // sub
				}

				// TO DO: remove images marked as deleted
//				$res = $this->Property->query("select * from images where remove=1 and `key`='".$this->data["Property"]["randomSeed"]."'");
//				var_dump($res[0]["images"]);
				
				$this->flash(__('Property saved.', true), array('action' => 'index'));
			} else {
				// error when saving
			}
		}
                //$this->data["Property"]["completiondate"] = $this->getCompletionDate();
		$this->layout='add-edit';
		$ckeditorClass = '';
		$this->set('ckeditorClass', $ckeditorClass);
		$ckfinderPath = Configure::read('Company.url').'dreamcms/app/webroot/js/ckfinder/';
		$this->set('ckfinderPath', $ckfinderPath);
		$this->loadModel('PropertiesCategory'); //if it's not already loaded
		$options = $this->PropertiesCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
//		$this->loadModel('PropertiesLocation'); //if it's not already loaded
//		$locOptions = $this->PropertiesLocation->find('all'); //or whatever conditions you want
//		$this->set('locOptions',$locOptions);
		$this->set('optionsState', $this->getStates());
		$this->loadModel('PropertiesRegion'); //if it's not already loaded
		$optionsRegion = $this->PropertiesRegion->find('all'); //or whatever conditions you want
		$this->set('optionsRegion',$optionsRegion);
		$this->loadModel('PropertiesType'); //if it's not already loaded
		$optionsType = $this->PropertiesType->find('all'); //or whatever conditions you want
		$this->set('optionsType',$optionsType);
		$this->loadModel('PropertiesStatus'); //if it's not already loaded
		$optionsStatus = $this->PropertiesStatus->find('all'); //or whatever conditions you want
		$this->set('optionsStatus',$optionsStatus);
		$this->loadModel('PropertiesSalesStatuses'); //if it's not already loaded
		$optionsSalesStatus = $this->PropertiesSalesStatuses->find('all'); //or whatever conditions you want
		$this->set('optionsSalesStatus',$optionsSalesStatus);
		$this->set('optionsBedrooms', $this->getBedrooms());
		$this->set('optionsBathrooms', $this->getBathrooms());
		$this->set('optionsParking', $this->getParking());
		// obtain all images (not required when adding)
		$this->set('randomSeed' , md5((rand(1,1000000)))); // key value
//		$this->loadModel('Images');
//		$optionsImages = $this->Images->find('all', array(
//			'conditions' => array('Images.property_id'=> 0),
//			'order'=>array('Images.position'=>'ASC')
//		)); //or whatever conditions you want
//		$this->set('optionsImages',$optionsImages);
		$this->set('orderStatus', 'PROPERTY IMAGES Ordering Succesfully Saved!');

		$moduleHeading = 'properties';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('maxPosition', $this->Property->find('count'));
		$this->set('helpURL','properties');               
		
                //javascript validations
		$this->JQValidator->addValidation
		(
			'Property',
			$this->Property->validate,
			__('Save failed, fix the following errors:', true),
			'PropertyAddForm'
		);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid property', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
			//$this->Property->create();
                    $this->data["Property"]["expected_completion_date"] = date('Y-m-d', strtotime(str_replace('/', '-', $this->data["Property"]["completiondate"])));
			if ($this->Property->save($this->data)) {
                            // save other docs edited data
                            $this->saveOtherDocsInDB($id);
//				echo $this->params["form"]["ImageId"]."<br>";
//				echo WWW_ROOT.'uploads/properties/'.$this->data["Property"]["randomSeed"]."<br>";
				if(isset($this->params["form"]["ImageId"]) && is_dir(WWW_ROOT.'uploads/properties/'.$this->data["Property"]["randomSeed"])) {
					for($i=0; $i<count($this->params["form"]["ImageId"]); $i++) {
						$v = $this->params["form"]["ImageId"][$i];       // image id
						$f = $this->params["form"]["ImageLocation"][$i]; // image filename
//						echo $v."<br>";
//						echo $f."<br>";
//						echo WWW_ROOT.'uploads/properties/'.$this->data["Property"]["randomSeed"].'/files/'.$f."<br>";
//						echo WWW_ROOT.'uploads/properties/'.$id.'/files/'.$f."<br>";
						$res = $this->Property->query("update images set confirmed=1, `key`=NULL, property_id=".$id." where id=".$v);
						if(file_exists(WWW_ROOT.'uploads/properties/'.$this->data["Property"]["randomSeed"].'/files/'.$f)) 
							copy(WWW_ROOT.'uploads/properties/'.$this->data["Property"]["randomSeed"].'/files/'.$f, WWW_ROOT.'uploads/properties/'.$id.'/files/'.$f);
						if(file_exists(WWW_ROOT.'uploads/properties/'.$this->data["Property"]["randomSeed"].'/thumbnails/'.$f)) 
							copy(WWW_ROOT.'uploads/properties/'.$this->data["Property"]["randomSeed"].'/thumbnails/'.$f, WWW_ROOT.'uploads/properties/'.$id.'/thumbnails/'.$f);
						
					}
				}
				// remove records from DB for images not needed, either marked as deleted or not confirmed (temporary)
				$res = $this->Property->query("delete from images where (remove=1 OR confirmed=0) and property_id=".$id);
				
				// TO DO: directory and file clean up
//				if(is_dir(WWW_ROOT.'uploads/properties/'.$this->data["Property"]["randomSeed"])) {
//					$res = $this->Property->query("select * from images where deleted confirmed=1, property_id=".$id." where id=".$v);
//				}
				$this->flash(__('Property saved.', true), array('action' => 'index'));
			} else {
				// error when saving
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Property->read(null, $id);
		}
                
		$this->layout='add-edit';
		$ckeditorClass = '';
		$this->set('ckeditorClass', $ckeditorClass);
		$ckfinderPath = Configure::read('Company.url').'dreamcms/app/webroot/js/ckfinder/';
		$this->set('ckfinderPath', $ckfinderPath);
		$this->loadModel('PropertiesCategory'); //if it's not already loaded
		$options = $this->PropertiesCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
//		$this->loadModel('PropertiesLocation'); //if it's not already loaded
//		$locOptions = $this->PropertiesLocation->find('all'); //or whatever conditions you want
//		$this->set('locOptions',$locOptions);
		$this->set('optionsState', $this->getStates());
		$this->loadModel('PropertiesRegion'); //if it's not already loaded
		$optionsRegion = $this->PropertiesRegion->find('all'); //or whatever conditions you want
		$this->set('optionsRegion',$optionsRegion);
		$this->loadModel('PropertiesType'); //if it's not already loaded
		$optionsType = $this->PropertiesType->find('all'); //or whatever conditions you want
		$this->set('optionsType',$optionsType);
		$this->loadModel('PropertiesStatus'); //if it's not already loaded
		$optionsStatus = $this->PropertiesStatus->find('all'); //or whatever conditions you want
		$this->set('optionsStatus',$optionsStatus);
		$this->loadModel('PropertiesSalesStatuses'); //if it's not already loaded
		$optionsSalesStatus = $this->PropertiesSalesStatuses->find('all'); //or whatever conditions you want
		$this->set('optionsSalesStatus',$optionsSalesStatus);
		$this->set('optionsBedrooms', $this->getBedrooms());
		$this->set('optionsBathrooms', $this->getBathrooms());
		$this->set('optionsParking', $this->getParking());
		// obtain all images (not required when adding)
		$this->set('randomSeed' , md5((rand(1,1000000)))); // key value
		$this->loadModel('Images');
		$optionsImages = $this->Images->find('all', array(
			'conditions' => array('Images.property_id'=>$id),
			'order'=>array('Images.position'=>'ASC')
		)); //or whatever conditions you want
		$this->set('optionsImages',$optionsImages);
		$this->set('orderStatus', 'PROPERTY IMAGES Ordering Succesfully Saved!');

		$moduleHeading = 'properties';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('maxPosition',$this->Property->find('count'));
		$this->set('helpURL','properties');
                $this->data["Property"]["completiondate"] = date('d/m/Y', strtotime($this->data["Property"]["expected_completion_date"]));    
                // other docs	
                $sortOrder = $this->data["Property"]['sortingorder'];
                if( empty($sortOrder) ) $sortOrder = 'position';
                $otherDocs = $this->PropertiesStatus->query("select * from properties_multidocs where pid=$id AND fieldname='otherdocs' ORDER BY $sortOrder;");	
                 $this->set('otherDocs', $otherDocs);
                // 
//javascript validations
		$this->JQValidator->addValidation
		(
			'Property',
			$this->Property->validate,
			__('Save failed, fix the following errors:', true),
			'PropertyAddForm'
		);
//		if (!empty($this->data)) {
//			if ($this->Property->save($this->data)) {
//				$this->flash(__('The property has been saved.', true), array('action' => 'index'));
//			} else {
//			}
//		}
//		if (empty($this->data)) {
//			$this->data = $this->Property->read(null, $id);
//		}
//		$this->layout='add-edit';
//		$ckeditorClass = '';
//		$this->set('ckeditorClass', $ckeditorClass);
//		$ckfinderPath = Configure::read('Company.url').'dreamcms/app/webroot/js/ckfinder/';
//		$this->set('ckfinderPath', $ckfinderPath);
//		$this->loadModel('PropertiesCategory'); //if it's not already loaded
//		$options = $this->PropertiesCategory->find('all'); //or whatever conditions you want
//		$this->set('options',$options);
//		$this->loadModel('PropertiesLocation'); //if it's not already loaded
//		$locOptions = $this->PropertiesLocation->find('all'); //or whatever conditions you want
//		$this->set('locOptions',$locOptions);
//		$moduleHeading = 'properties';
//		$this->set('moduleHeading',$moduleHeading);
//		$this->set('helpURL','properties');		
//		//javascript validations
//		$this->JQValidator->addValidation
//		(
//			'Property',
//			$this->Property->validate,
//			__('Save failed, fix the following errors:', true),
//			'PropertyEditForm'
//		);
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid property', true)), array('action' => 'index'));
		}
		if ($this->Property->delete($id)) {
                    // delete docs directories
                    $dirAbsPath = WWW_ROOT. "uploads/$id";
                    $this->deleteFullDirectory($dirAbsPath);
                    $dirAbsPath = WWW_ROOT . 'uploads/otherdocs/' . $id;   
                    $this->deleteFullDirectory($dirAbsPath);
                    // delete images from db
                    $this->Property->query("delete from images where property_id=$id");
                    // delete images from disk
                    $dirAbsPath = WWW_ROOT. "uploads/properties/$id";
                    $this->deleteFullDirectory($dirAbsPath);
                    
                    $this->flash(__('Property deleted', true), array('action' => 'index'));
		}
		$this->flash(__('Property was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function publish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid Property', true)), array('action' => 'index'));
		}
		if ($this->Property->saveField('live',1,false)) {
			$this->flash(__('Property published', true), array('action' => 'index'));
		}
		$this->flash(__('Property was not published', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function unpublish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid Property', true)), array('action' => 'index'));
		}
		if ($this->Property->saveField('live',0,false)) {
			$this->flash(__('Property unpublished', true), array('action' => 'index'));
		}
		$this->flash(__('Property was not unpublished', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function markFeatured($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid Property', true)), array('action' => 'index'));
		}
		if ($this->Property->saveField('featured',1,false)) {
			$this->flash(__('Property marked as featured', true), array('action' => 'index'));
		}
		$this->flash(__('Property was not marked as featured', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function unmarkFeatured($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid Property', true)), array('action' => 'index'));
		}
		if ($this->Property->saveField('featured',0,false)) {
			$this->flash(__('Property removed from featured', true), array('action' => 'index'));
		}
		$this->flash(__('Property was not removed from featured', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	/** Receives ajax request from index **/
	function order(){
	//loop through the data sent via the ajax call
		foreach ($this->params['form']['properties'] as $order => $id){
			$data['Property']['position'] = $order;
			$this->Property->id = $id;
			if($this->Property->saveField('position',$order)) {
				//we have success!
			} else {
				//deal with possible errors!
			}
		}
		$this->autoRender=false;
	}
	
	function deletefile($id = null, $fldName = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid File Name', true)), array('action' => 'index'));
		}
		if($id > 0 && strlen($fldName)>0){
			if($this->Property->saveField($fldName,'')){
				//we have successfully deleted file from DB
				$this->redirect(array('action' => 'edit/'.$id));
			}
		} else {
			//deal with possible errors!
		}
		$this->autoRender=false;
	}

	function imageLoader() {
		// code to be implemented later
		//$this->layout='ajax';
	}
	
	function getStates() {
		return array("VIC" => "Victoria", 
						"NSW" => "New South Wales", 
						"QLD" => "Queensland", 
						"ACT" => "Australian Capital Territory", 
						"TAS" => "Tasmania", 
						"SA"  => "South Australia", 
						"WA"  => "Western Australia", 
						"NT"  => "Norther Territory");
	}

	function getBedrooms() {
		return array(0 => "Studio", 
						1 => "1 Bedroom", 
						2 => "2 Bedrooms", 
						3 => "3 Bedrooms", 
						4 => "4 Bedrooms", 
						5 => "5+ Bedrooms");
	}

	function getBathrooms() {
		return array(0 => "No Bathrooms", 
						1 => "1 Bathroom", 
						2 => "2 Bathrooms", 
						3 => "3 Bathrooms", 
						4 => "4 Bathrooms", 
						5 => "5+ Bathrooms");
	}

	function getParking() {
		return array(0 => "No Parking", 
						1 => "1 Parking Space", 
						2 => "2 Parking Spaces", 
						3 => "3 Parking Spaces", 
						4 => "4 Parking Spaces", 
						5 => "5+ Parking Spaces");
	}
}
