<?php
namespace BojanGles\Resources;

/**
 * Transaction
 *
 * @author bseirovski
 */
class Transaction extends \BojanGles\lib\AppResource {
	
	public function get($request){
		
		$data = json_decode($request->post(),true);
		
		$expectedParams = array('TransactionId','UserId','CurrencyAmount','Verifier');
		
		if(!$request->valid($expectedParams, $data)){
			$this->response = array('Error' => true ,'ErrorMessage'=>'Invalid request.');
		}
		else{
			try{
				$query = 'SELECT * FROM trans WHERE TransactionId=:tid;';
				$exists = $this->db->runQuery($query,array(':tid'=>$data['TransactionId']) ,true);
				
				if(count($exists)>0){
					$this->response = array('Error' => true ,'ErrorMessage'=>'The transaction '.$data['TransactionId'].' exists.');
				}
				else{
					$secureString = $this->config['secret'].$data['TransactionId'].$data['UserId'].$data['CurrencyAmount'];
					if($data['Verifier']==$secureString){
					
						$query = 'INSERT INTO trans(TransactionId,UserId,CurrencyAmount) VALUES(:tid,:uid,:curr);';

						$dbParams = array(':tid'=>$data['TransactionId'],':uid'=>$data['UserId'],':curr'=>$data['CurrencyAmount']);

						$this->db->runQuery($query,$dbParams);
						$this->response = array('Success'=>true);
					}
					else{
						$this->response = array('Error' => true ,'ErrorMessage'=>'Invalid value for verification string.');						
					}
				}
			} 
			catch (\Exception $ex) {
				$this->log->error($ex->getMessage());
				$this->response = array('Error' => true ,'ErrorMessage'=>'System error.');
			}
		}
		
		return $this->response;
	}
	
}
