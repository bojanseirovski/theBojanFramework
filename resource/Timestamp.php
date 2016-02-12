<?php
namespace BojanGles\Resources;

/**
 * Timestamp
 *
 * @author bseirovski
 */
class Timestamp extends \BojanGles\lib\AppResource{
	
	public function get($request=null){
		return array('Timestamp'=>time());
	}
}
