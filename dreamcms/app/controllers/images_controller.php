<?php
class ImagesController extends AppController {

	var $name = 'Images';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions', 'ImageGallery', 'JQValidator.JQValidator'); 
	
	function index($id=0) {
		$this->layout='none';

		$this->Image->recursive = 0;
		$this->paginate = Set::merge($this->paginate,array('Image'=>array('order' => array('Image.id' => 'ASC'),'conditions' => array('Image.property_id =' => $id), 'limit'=>'100')));
		//$this->set('images', $this->paginate());
		/*if(isset($_GET['sel'])){
			if(trim($_GET['sel']=='all')){	
				$this->paginate = Set::merge($this->paginate,array('Image'=>array('order' => array('Image.id' => 'ASC'),'limit'=>'50')));
			} else {
				$this->paginate = Set::merge($this->paginate,array('Image'=>array('conditions' => array('Image.name LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'25')));
			}
		}
		if(isset($_GET['cat'])){
			if((int)trim($_GET['cat'])>0){
				$this->paginate = Set::merge($this->paginate,array('Image'=>array('conditions' => array('Image.categorie_id =' => (int)trim($_GET['cat'])),'limit'=>'25')));
			}
		}
		if(isset($_GET['search'])){			
			$this->paginate = Set::merge($this->paginate,array('Image'=>array('conditions' => array('Image.name LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'25')));
		}
		$this->set('images', $this->paginate());
		$this->loadModel('Category'); //if it's not already loaded
		$options = $this->Category->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$this->set('helpURL','gallery');*/
	}

	function view_images($key = NULL, $id = -1) {
		//echo $key . "::". $id . "<br>";
		$this->layout='none';

		$this->loadModel('Images');
		$optionsImages = $this->Images->find('all', array(
			'conditions' => array(
				'OR' => array(
					array('Images.property_id'=> $id), 
					array('key' => $key)
				),
				"AND" =>  array (array('remove' => 0)
				)
			),
			'order'=>array('Images.position'=>'ASC')
		)); //or whatever conditions you want
		$this->set('optionsImages',$optionsImages);
		$this->set('orderStatus', 'PROPERTY IMAGES Succesfully Loaded!');
		/*if (!$id) {
			$this->flash(__('Invalid image', true), array('action' => 'index'));
			//$this->Session->setFlash(__('Invalid image', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('image', $this->Image->read(null, $id));
		$this->layout='front-end-website';
		$moduleHeading = "image gallery";
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','gallery');*/
	}

	function add() {		
		$this->layout='basic';
		$filesUploadedError = false;
		

		// TODO: Add folder structure when uploading so multiple users can manage images simultaniously
		if(isset($this->params['form']['uploadFileName'])) {		
			$imageFolderName = ((integer)$this->params['form']['id']==0) ? $this->params['form']['key'] : $this->params['form']['id'];

			// create directories based on id or key if they don't exist
			if(!is_dir(WWW_ROOT.'uploads/'.$this->params['form']['df'].'/'.$imageFolderName)) {		
				mkdir(WWW_ROOT.'uploads/'.$this->params['form']['df'].'/'.$imageFolderName);               // base
				mkdir(WWW_ROOT.'uploads/'.$this->params['form']['df'].'/'.$imageFolderName.'/files');      // sub
				mkdir(WWW_ROOT.'uploads/'.$this->params['form']['df'].'/'.$imageFolderName.'/thumbnails'); // sub
			}

			foreach($this->params['form']['uploadFileName'] as $v) {
				var_dump($v);
				// move main image
				$filesUploadedFlag = false;
				if(file_exists(WWW_ROOT.'../views/uploads/server/php/files/'.$v)) {
					if(copy(WWW_ROOT.'../views/uploads/server/php/files/'.$v, WWW_ROOT.'uploads/'.$this->params['form']['df'].'/'.$imageFolderName.'/files/'.$v)) {
						unlink(WWW_ROOT.'../views/uploads/server/php/files/'.$v);
						$filesUploadedFlag = true;
					}
				}
				// move thumbnail image
				if(file_exists(WWW_ROOT.'../views/uploads/server/php/files/thumbnail/'.$v)) {
					if(copy(WWW_ROOT.'../views/uploads/server/php/files/thumbnail/'.$v, WWW_ROOT.'uploads/'.$this->params['form']['df'].'/'.$imageFolderName.'/thumbnails/'.$v)) {
						unlink(WWW_ROOT.'../views/uploads/server/php/files/thumbnail/'.$v);
					}
				}
				
				if($filesUploadedFlag) {
					// TODO: determine last position in list based on id (if applicable)
					$this->Image->create();
					// add record to DB
					$objectArray = array(
						'Image' => array(
						'name' => '',
						'location' => $v,
						'live' => 1,
						'property_id' => (integer)$this->params['form']['id'],
						'confirmed' => 0,
						'key' => $this->params['form']['key'],
						'position' => 100
						)
					);
					var_dump($objectArray);
					$this->Image->save($objectArray);
					//$this->flash(__('Images saved.', true));
					echo "<br>".(($this->Image->save($objectArray)) ? "pass" : "fail");
				} else {
					$filesUploadedError = true;
				}
			}
		}
		if($filesUploadedError)
			$this->uploadError();
		else
			$this->delete(); // remove residual images

		$this->closeModalWindow();  // close window after moving neccessary files
	}

	function delete($key = NULL) {		
		$this->layout='basic';
		$this->set('orderStatus', 'PROPERTY IMAGES Upload Cancelled!');

		// delete all file from upload directory
		// TODO: move to helper class?
		$handleFolder = array("files", "thumbnails");
//		while(@is_dir(WWW_ROOT."img/properties/".$key) || is_null($key)) {
			foreach($handleFolder as $f) {
				$handleBasePath = WWW_ROOT."../views/uploads/server/php/".$f;
				echo $handleBasePath." : 1<br>";
				if(!is_null($key)) $handleBasePath = WWW_ROOT."uploads/properties/".$key."/".$f;
				echo $handleBasePath." : 2<br>";
				$handle = opendir($handleBasePath);
				while($name = readdir($handle)) {
					if(!($name=="." || $name=="..")) {
						@unlink ($handleBasePath."/".$name);
					}
				}
				closedir($handle);
				if(!is_null($key)) rmdir(WWW_ROOT."uploads/properties/".$key."/".$f);
			}
			if(!is_null($key)) rmdir(WWW_ROOT."uploads/properties/".$key);
//		}
		$this->closeModalWindow();  // close window after moving neccessary files
	}

	function delete_image($id, $key = NULL, $pid = NULL) {
		$this->layout='none';
		$this->set('orderStatus', 'Selected PROPERTY IMAGE deleted');
		
		// NOTE: this will only mark the item as "to delete" on submit.
		//       the image is removed from the edit/add page image list
		if(isset($id) && is_numeric($id)) {
			// update DB record
			$this->Image->updateAll(array('remove' => 1), array('id =' => $id));
			//$this->view_images($key, $pid);
			$this->redirect(array('action' => 'view_images/'.$key.'/'.$pid));
		}
	}
/*		if(!empty($this->data)) {
			$this->Image->create();
			
			// how to ensure unique file names?
			// TODO: Code to warn user about duplicate files
			$newName = $this->Image->saveImage($this->params['data']['Image']['location'],100,"ht",80);
			if(isset($newName))
			{
				$this->params['data']['Image']['location'] = $newName;
			}
			else
			{
				$this->params['data']['Image']['location'] = null;
				// TODO: Write code to graciously exit if Photo::saveImage fails for now just die()
				//die("I am sorry to fail you my master but I could not save your photo");
			}
			
			if ($this->Image->save($this->data)) {
				$this->flash(__('The image has been saved', true), array('action' => 'index'));
				//$this->Session->setFlash(__('The image has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
			}
		}
		$categories = $this->Image->Categorie->find('list');
		$tags = $this->Image->Tag->find('list');
		$this->set(compact('categories', 'tags'));
		$this->layout='add-edit';
		$moduleHeading = 'image gallery';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','gallery');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Image',
			$this->Image->validate,
			__('Save failed, fix the following errors:', true),
			'ImageAddForm'
		);
	}*/

	function edit($id = null) {
/*		$imageData = $this->Image->read();
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid image', true), array('action' => 'index'));
			//$this->Session->setFlash(__('Invalid image', true));
			//$this->redirect(array('action' => 'index'));
		}
		
		if (!empty($this->data)) {
			// Is there a new picture?
			if($this->params['data']['Image']['location'] != $imageData['Image']['location']){
				if ($this->params['data']['Image']['location']['error'] == 0)
				{
					// Delete the picture
					$this->Image->delImage($imageData['Image']['location']);
					$newName = $this->Image->saveImage($this->params['data']['Image']['location'],100,"ht",80);
					if(isset($newName))
					{
						$this->params['data']['Image']['location'] = $newName;
					}
					else
					{
						$this->params['data']['Image']['location'] = null;
						// TODO: Write code to graciously exit if Photo::saveImage fails for now just die()
						die("I am sorry to fail you my master but I could not save your photo");
					}
				}
				else
				{
					// no new picture so keep the old link-location
					$this->params['data']['Image']['location'] = $imageData['Image']['location'];
				}
			}
			##
			if ($this->Image->save($this->data)) {
				$this->flash(__('The image has been saved', true), array('action' => 'index'));
				//$this->Session->setFlash(__('The image has been saved', true));
				//$this->redirect(array('action' => 'index'));
			} else {
			}
			##
		}
		if (empty($this->data)) {
			$this->data = $this->Image->read(null, $id);
		}
		$categories = $this->Image->Categorie->find('list');
		$tags = $this->Image->Tag->find('list');
		$this->set(compact('categories', 'tags'));
		$this->layout='add-edit';
		$moduleHeading = 'image gallery';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','gallery');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Image',
			$this->Image->validate,
			__('Save failed, fix the following errors:', true),
			'ImageEditForm'
		);*/
	}

/*	function delete($id = null) {
		$imageData = $this->Image->read();
		if (!$id) {
			$this->flash(__('Invalid image', true), array('action' => 'index'));
			//$this->Session->setFlash(__('Invalid id for image', true));
			//$this->redirect(array('action'=>'index'));
		}
		if ($this->Image->delete($id)) {
			$this->Image->delImage($imageData['Image']['location']);
			$this->flash(__('The image has been deleted', true), array('action' => 'index'));
			//$this->Session->setFlash(__('Image deleted', true));
			//$this->redirect(array('action'=>'index'));
		}
		$this->flash(__('The image was not deleted', true), array('action' => 'index'));
		//$this->Session->setFlash(__('Image was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function deletefile($id = null, $fldName = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid File Name', true)), array('action' => 'index'));
		}
		if($id > 0 && strlen($fldName)>0){
			if($this->Image->saveField($fldName,'')){
				//we have successfully deleted file from DB
				$this->redirect(array('action' => 'edit/'.$id));
			}
		} else {
			//deal with possible errors!
		}
		$this->autoRender=false;
	}*/
	
	
	/*function publish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid image', true)), array('action' => 'index'));
		}
		if ($this->Image->saveField('live',1,false)) {
			$this->flash(__('Image published', true), array('action' => 'index'));
		}
		$this->flash(__('Image was not published', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function unpublish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid image', true)), array('action' => 'index'));
		}
		if ($this->Image->saveField('live',0,false)) {
			$this->flash(__('Image unpublished', true), array('action' => 'index'));
		}
		$this->flash(__('Image was not unpublished', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}*/
	
	function closeModalWindow() {
		echo('<script type="text/javascript" language="javascript">self.parent.tb_remove();</script>');
	}
	
	function uploadError() {
		echo('<script type="text/javascript" language="javascript">alert("Please note that not all the selected files were uploaded or there were no files selected!")</script>');
	}
	
	function order(){
	//loop through the data sent via the ajax call
		echo "<script>alert('hi');</script>";
		foreach ($this->params['form']['images'] as $order => $id){
			$data['Image']['position'] = $order;
			$this->Image->id = $id;
			//if($this->Image->saveField('position',$order)) {
			if($this->Image->updateAll(array('Image.position' => $order), array('Image.id' => $id))){
				//we have success!
				$this->render('sql');
			} else {
				$this->render('sql');
				//deal with possible errors!
			}
		}
		$this->autoRender=false;
	}

}
?>