<?php
namespace BojanGles\Resources;

/**
 * TransactionStats
 *
 * @author bseirovski
 */
class TransactionStats extends \BojanGles\lib\AppResource {
	private $uid;
	
	public function get($request){
		
		$data = json_decode($request->post(),true);
		
		$expectedParams = array('UserId');
		
		if(!$request->valid($expectedParams, $data)){
			$this->response = array('Error' => true ,'ErrorMessage'=>'Invalid request.');
		}
		else{
			$query = 'SELECT UserId,COUNT(*) AS TransactionCount ,SUM(CurrencyAmount) AS CurrencySum FROM trans WHERE UserId=:uid ;';

			$dbParams = array(':uid'=>$data['UserId']);

			$uidTrans = $this->db->runQuery($query,$dbParams,true);
			$uidTrans = isset($uidTrans[0])?$uidTrans[0]:null;
			if(isset($uidTrans) && isset($uidTrans['UserId']) && ($uidTrans['UserId']==$data['UserId'])){
				$this->response = $uidTrans ;				
			}
			else{
				$this->response = array('Error' => true ,'ErrorMessage'=>'No data for the specified user.');
			}
		}
		return $this->response;
	}
	
}
