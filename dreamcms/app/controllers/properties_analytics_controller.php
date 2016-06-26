<?php

class PropertiesAnalyticsController extends AppController {
    var $name = 'PropertiesAnalytics';  
    var $uniqueProperties = array();
    function formatSeoPageName($pageName){
        $pageName = str_replace('-', ' ', $pageName);
        $pageName = ucwords($pageName);
        return $pageName;
    }
    
    function tokenizeAndFormHTMLSelectOptions($data){
        $data = trim($data, ' ,');
        $ids = explode(',', $data);       
        
        $propertiesName = array();
        
        foreach($ids as $pId){
        if(!empty($pId)){
            $propName = $this->PropertiesAnalytic->query("SELECT `seo_page_name` from `properties` WHERE id=$pId");
            $pageName = $this->formatSeoPageName($propName[0]['properties']['seo_page_name']); 
            $propertiesName[] = $pageName;         
        }  
       }
        return $propertiesName;
    }
    
    function getUniqueProprties($visitedProperties){
        $visitedProperties = trim($visitedProperties, ' ,');
        if(empty($visitedProperties)){
            return;
        }
        $iDs = explode(',', $visitedProperties);       
        foreach ($iDs as $pID){
            if( empty($this->uniqueProperties[$pID]) ){
            $this->uniqueProperties[$pID] = $pID;
            }
        }
    }
    
    function getPropertiesSeoName(){
        $query = "SELECT `id`, `seo_page_name` from `properties` where id IN (";
        foreach ($this->uniqueProperties as $key => $value) {
            $query .=  $key . ', ';
        }
        
        $query = rtrim($query, ', ');
        $query .= ') order by id DESC';
        
        echo $query;
        $properties = $this->PropertiesAnalytic->query($query);
       
        foreach($properties as $property){
           $pID = $property['properties']['id'];
           $this->uniqueProperties[$pID] =  $this->formatSeoPageName($property['properties']['seo_page_name']);
       }    
    }
    
    function getAllVisitedProperties($analytics){
        $this->uniqueProperties = array();
        foreach($analytics as $analytic){   
            $visitedProperties = $analytic['PropertiesAnalytic']['visited_properties_ids'];          
            $this->getUniqueProprties($visitedProperties);
        }
        // get properties names
        $this->getPropertiesSeoName();
    }

    function index() {
		$this->PropertiesAnalytic->recursive = 0;
		$sortable = false; //disable sorting by default
		$recordCount = $this->PropertiesAnalytic->find('count'); 
                $pageLimit = 50;
                
                
		if(isset($_GET['sort_list']) && trim($_GET['sort_list']=='true')) {//sorting enabled
			$sortable = true;
		}                 
                $this->paginate = Set::merge($this->paginate,array('PropertiesAnalytic'=>array('order' => array('PropertiesAnalytic.logintime' => 'DESC'),'limit'=>$pageLimit)));
		$propertiesanalytics = $this->paginate();
                $this->set('propertiesanalytics', $propertiesanalytics);
                
		$this->set('instructionText','You can drag and drop the items below to set the order.');
		$this->set('orderStatus', 'PROPERTIES Analytics Ordering Succesfully Saved!');
		$this->set('sortable', $sortable);		
		$this->set('pageLimit', $pageLimit);                
                $visitedPages = array();
                
                foreach($propertiesanalytics as $analytic){
                    $visitedProperties = $analytic['PropertiesAnalytic']['visited_properties_ids'];                   
                    $visitedPages[] = $this->tokenizeAndFormHTMLSelectOptions($visitedProperties);    
                }
                
                //var_dump($propertiesanalytics[1]['PropertiesAnalytic']['visited_properties_ids']);
		//$this->loadModel('PropertiesCategory'); //if it's not already loaded
		//$options = $this->PropertiesCategory->find('all'); //or whatever conditions you want
		//$this->set('options',$options);
		$this->set('helpURL', 'propertiesanalytics');
                $this->set('visitedPages', $visitedPages);
	}
        
        function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid entry', true)), array('action' => 'index'));
		}
		if ($this->PropertiesAnalytic->delete($id)) {
			$this->flash(__('Row deleted', true), array('action' => 'index'));
		}
		$this->flash(__('Row was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
        
        function export_excel(){
            // increase memory limit in PHP
            ini_set('memory_limit', '512M');  
            $analytics = $this->PropertiesAnalytic->find('all');
            $this->set('analytics', $analytics);
            $this->getAllVisitedProperties($analytics);
            $this->set('uniqueProperties', $this->uniqueProperties);
            $this->render('analytics_db_export_xls', 'analytics_db_export_xls');
        }
        
}

