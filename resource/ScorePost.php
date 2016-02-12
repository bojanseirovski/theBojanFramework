<?php

namespace BojanGles\Resources;

/**
 * ScorePost
 *
 * @author bseirovski
 */
use \BojanGles\lib\util\Score as Sutil;
use \BojanGles\lib\util\User as Uutil;

class ScorePost extends \BojanGles\lib\AppResource {

	public function get($request) {

		$data = json_decode($request->post(), true);

		$expectedParams = array('UserId', 'LeaderboardId', 'Score');

		if (!$request->valid($expectedParams, $data)) {
			$this->response = array('Error' => true, 'ErrorMessage' => 'Invalid request.');
		} 
		else {

			$score = $this->maxScoreForUserAndLboard($data['UserId'],$data['LeaderboardId']);
			$maxScoreForLeaderboard = Sutil::high($score);

			if ($data['Score'] > $maxScoreForLeaderboard) {
				$querySaveScore = 'INSERT INTO leaderboard(UserId,LeaderboardId,Score) VALUES(:uid, :lbid, :scor);';
				$dbParamsSaveScore = array(':uid' => $data['UserId'], ':lbid' => $data['LeaderboardId'], ':scor' => $data['Score']);
				$this->db->runQuery($querySaveScore, $dbParamsSaveScore);
			}

			$hs = $this->getOtherHighScores();

			$rank =1;
			if(isset($hs)){
				foreach($hs as $key=>$oneScore){
					$rank++;
					if($oneScore==$maxScoreForLeaderboard){
						break;
					}
				}
			}
			$this->response['UserId'] = $data['UserId'];
			$this->response['LeaderboardId'] = $data['LeaderboardId'];
			$this->response['Score'] = ($data['Score'] > $maxScoreForLeaderboard)?$data['Score']:$maxScoreForLeaderboard;
			$this->response['Rank'] = $rank;
		}
		return $this->response;
	}

	private function maxScoreForUserAndLboard($UserId,$LeaderboardId){
			$query = 'SELECT * FROM leaderboard WHERE UserId=:uid and LeaderboardId=:lbid;';
			$query = 'SELECT * FROM leaderboard WHERE UserId=:uid ;';
			$dbParams = array(':uid' => $UserId, ':lbid' => $LeaderboardId);
			$dbParams = array(':uid' => $UserId);
			return $this->db->runQuery($query, $dbParams, true);
	}


	private function getUidsForLboard($lbid = null) {
		$query = 'SELECT DISTINCT UserId FROM leaderboard ';
		$dbParams = array();
		if (isset($lbid)) {
			$query .= 'WHERE LeaderboardId=:lbid ';
			$dbParams[':lbid'] = $lbid;
		}

		$allRawUids = $this->db->runQuery($query, $dbParams, true);

		$allUids = array();
		foreach ($allRawUids as $oneUid) {
			$allUids[] = $oneUid['UserId'];
		}

		return $allUids;
	}

	private function getOtherHighScores() {
		$query = 'SELECT DISTINCT Score FROM leaderboard GROUP BY Score,UserId,LeaderboardId ORDER BY Score DESC;';
		$hs = $this->db->runQuery($query, null, true);
	}

}
