<?php

 // Campaigns Edit method
 


class CampaignsController extends AppController {
	function beforeFilter() {
		parent::beforeFilter();
	}

	function edit($campaignId = null) {
		$campaign = $this->Campaign->find('first', array(
			'conditions' => array(
				'id' => $campaignId
			),
			
		));
		
		$groupId = $campaign['Group'][0]['id'];
	if($this->getUserRole($groupId) == 'Admin') {
		if($this->request->data) {
			//debug($this->request->data);
			if($this->Campaign->save($this->request->data)) {
			
		//	$this->redirect('/')

			}
		} else {
			//debug($this->request->data);	
			$this->data = $campaign;
		}
	} else {
		$this->redirect('/');
	}
		
// 		
// 		} else {
// 			$this->redirect('/');	
// 		}
		
	}
		
// 			if($this->request->data) {
// 				if($this->Campaign->save($this->request->data)) {
					
// 				}
// 			} else {
				
			
// 		} else {
// 			$this->Campaign->id = $campaignId;
// 			$this->data = $this->Campaign->read();
		
// 			//$this->redirect('/');
// 		}
		

function getUserRole($groupId, $userId = null) {
		$userId = ($userId == null) ? $this->userId : $userId;
		$userIsAdmin = $this->Campaign->Group->GroupsUser->find('first', array(
										'conditions' => array(
											'User.id' => $userId,
											'Group.id' => $groupId
										),
										'recursive' => 2					
		));		
		return $userIsAdmin['UserRole']['name'];
	}
	
}	

	
	/*function edit($campaignId = null) {	
		if($this->getUserRole($campaignId) == 'Admin')
		if($this->request->data) {
			//debug($this->data);
			if($this->Campaign->save($this->request->data)) {											
			}
			else {
			
			}
		} else {
		$this->Campaign->id = $campaignId;
		$this->data = $this->Campaign->read();
			
		//debug($campaignId);
// 		$this->redirect('/');
			}
	}
	
	//debug($this->data);
	function getUserRole($campaignId = null) {
		$groupId = $groupId == null ? $this->groupId : $groupId;
		$groupIsAdmin = $this->Campaign->CampaignsUser->find('first', array(
											'conditions' => array(
												'User.id' => $groupId,
												'Campaign.id' => $campaignId
		),
											'recursive' => 2					
		));
		return $groupIsAdmin['UserRole']['name'];
	}
}

**/