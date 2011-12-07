<?php

class CampaignsController extends AppController
{



	function beforeFilter() {
		parent::beforeFilter();
	}
	function browse() {
		
	}
	
	function getRecentActive() {
		$this->autoLayout = false;
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
	
	function add($groupId = null) {
		if($this->userId) {
			//debug($this->request);
			if(!empty($this->data)) {
				if ($this->request->is('post')) {	// post(not get) method is used from the view of this function and the data is passed from form in html.
					$this->request->data['Group'] = array(
						array(
							'id' => $groupId				
						)
					);
					if($this->Campaign->saveAll($this->data)) {
						$campaignId = $this->Campaign->id;
						$this->Session->setFlash('The campaign has been successfully added');
						$this->redirect(array(
															'controller' => 'Campaigns',
															'action' => 'view', $campaignId
						));
					}
						
				} else {
					$this->redirect('/');
				}
			}
		} else {
			$this->redirect(array(
					'controller' => 'Users',
					'action' => 'login'
			));
		}
		$this->set(compact('groupId')) ;
	}
	
	
}
?>