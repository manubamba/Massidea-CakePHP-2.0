<?php

class CampaignsController extends AppController
{



	function beforeFilter() {
		parent::beforeFilter();
	}
	function browse() {
		$now = new DateTime();
		$now  = date("Y-m-d");
		//debug($now);
		
		$this->set(compact('activeCampaigns'));
		$this->set(compact('forthcomingCampaigns'));
		$this->set(compact('endedCampaigns'));
	}
	
	function getRecentActive() {
		$this->autoLayout = false;
		$now = new DateTime();
		$now  = date("Y-m-d");
		$activeCampaigns = $this->Campaign->find('all',	array(
					'limit' => 10,
					'order' => 'Campaign.created DESC',
					'fields' => array('name', 'lead','end_time', 'start_time', 'id'),
					'conditions' => array(
						 "AND" => array (
							'start_time <' => $now,
							'end_time >' => $now
		)
		)
		));
		$this->set(compact("activeCampaigns")) ;
	}
	
	function getRecentForthcoming(){
		$this->autoLayout = false;
		$now = new DateTime();
		$now  = date("Y-m-d");
		$forthcomingCampaigns = $this->Campaign->find('all', array(
					'limit' => 10,
					'order' => 'Campaign.created DESC',
					'fields' => array('name', 'lead','end_time', 'start_time', 'id'),
					'conditions' => array(
						'start_time >' => $now,
		)
		));
		
		$this->set(compact("forthcomingCampaigns")) ;
		
	}
	
	
	function getRecentEnded() {
		$this->autoLayout = false;
		$now = new DateTime();
		$now  = date("Y-m-d");
		$endedCampaigns = $this->Campaign->find('all', array(
					'limit' => 10,
					'order' => 'Campaign.created DESC',
					'recursive' => 0,
					'fields' => array(
						'name', 
						'lead',
						'end_time', 
						'start_time', 
						'id'
		),
					'conditions' => array(			
						'end_time <' => $now
		)
		));
		
		$this->set(compact("endedCampaigns")) ;
	}

}
?>