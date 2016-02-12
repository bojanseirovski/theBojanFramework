<?php

namespace BojanGles\Resources;

/**
 * UserSave
 *
 * @author bseirovski
 */
class LeaderboardGet  extends \BojanGles\lib\AppResource {
	
	public function get($request,$db) {
		$this->response = array('Error' => true ,'ErrorMessage'=>'Under construction.');
		
		return $this->response;
	}
}

