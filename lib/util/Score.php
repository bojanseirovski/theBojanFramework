<?php
namespace BojanGles\lib\util;
/**
 * Score util class
 *
 * @author bseirovski
 */

class Score {
	public static function high($scores){
		$highest = 0;
		$oneDimArray = array();
		
		foreach($scores as $onescore){
			$oneDimArray['LeaderboardId'] = $onescore['Score'];
		}
		if(count($oneDimArray)){
			$highest = max($oneDimArray);
		}
		
		return $highest;
	}
	
}
