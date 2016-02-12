<?php

namespace BojanGles\Resources;

/**
 * Description of Hello
 *
 * @author bseirovski
 */
class Hello {
	public function get($request){
		
		$data = json_decode($request->post(),true);
		
		$expectedParams = array('Hi');
		
		if(!$request->valid($expectedParams, $data)){
			$this->response = array('Error' => true ,'ErrorMessage'=>'Invalid request.');
		}
		else{
			$this->response = array('Success'=>true,'Data'=>'hello') ;				
		}
		return $this->response;
	}
}
