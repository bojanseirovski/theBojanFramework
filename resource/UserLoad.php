<?php

namespace BojanGles\Resources;

/**
 * UserLoad
 *
 * @author bseirovski
 */
class UserLoad  extends \BojanGles\lib\AppResource {
	
	public function get($request,$db) {
		$this->response = array('Error' => true ,'ErrorMessage'=>'Under construction.');
		return $this->response;
	}
}
