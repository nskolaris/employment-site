<?php
App::uses('AppController', 'Controller');

class SlidesController extends AppController{

	var $uses = array('Slide');
    
	function beforeFilter(){
		parent::beforeFilter();
	}
	
	/* Sección Control */
	
	function control_index(){
		$slides = $this->Slide->find('all');
		$this->set(compact('slides'));
	}
	
	function control_add(){
		if(!empty($this->data)){
			foreach($this->data as $data){
				if(isset($data['id'])){
					$this->Slide->id = $data['id'];
				}else{
					$this->Slide->create();
				}
				if($data['image_name'] != ''){
					$this->save_slide($data['image_data'],$data['image_name']);
					$slide['Slide']['image'] = $data['image_name'];
				}
				$slide['Slide']['borrador'] = ($data['borrador']=='true'?1:0);
				$slide['Slide']['url'] = $data['url'];
				$this->Slide->save($slide);
			}
			echo 'ok';
		}
		exit;
	}
	
	function control_delete($id = null){
		if(!empty($id)){
			if($this->Slide->delete($id)){
				echo 'ok';
			}else{
				echo 'error';
			}
		}
		exit;
	}
	
	function save_slide($img_data, $name){
		if($file = $this->base64_to_jpeg($img_data,'img/slides/'.$name)){
			return $file;
		}else{
			return 'error';
		}
	}
}
?>