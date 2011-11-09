<?php
/**
 *  UsersController
 *
 *  This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License
 *  as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 *  warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
 *  more details.
 *
 *  You should have received a copy of the GNU General Public License along with this program; if not, write to the Free
 *  Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 *  License text found in /license/
 */

/**
 *  UsersController - class
 *  Maintains groups related actions (browse, view, edit, delete...)
 *	TODO: -
 *  @package        Controllers
 *  @author         Manu Bamba
 *  @copyright      Manu Bamba
 *  @license        GPL v2
 *  @version        1.0
 */

class GroupsController extends AppController {
	function beforeFilter() {
		parent::beforeFilter();		
	}
	function browse() {
		$this->Group->contain(array(
			'Campaign.id',
			'GroupsUser.User.id'
		));
		$recentGroups = $this->Group->find('all',
			array(
					'limit' => 10,
					'order' => 'Group.created DESC',
					'fields' => array('Group.name', 'Group.lead')
				)
		);
		$campaignCount = null;
		$memberCount = null;
		
		foreach ($recentGroups as $group) {
			$campaignCount[$group['Group']['id']] = sizeof($group['Campaign']);
			$memberCount[$group['Group']['id']] = sizeof($group['GroupsUser']);
		}
		$this->set('groups', $recentGroups);
		$this->set('campaignCount', $campaignCount);
		$this->set('memberCount', $memberCount);
	}

	function view($groupId) {
// 		debug($this->Session);
		$userRole = $this->getUserRole($groupId);
		debug($userRole);
		$group = $this->Group->find('first', array(
					'conditions' => array(
						'Group.id' => $groupId
					),
					'contain' => array(
						'Campaign' => array(
							'fields' => array(
								'id',
								'name',
								'start_time',
								'end_time'
							),
							'limit' =>2,
							'order' =>'end_time DESC'
						),
						'LinkedGroups' => array(
							'limit' => 2,
							'fields' => array(
								'id',
								'name'
							)
						),
						'GroupsUser' => array(
							'limit' => 2,
							'conditions' => array(
								'UserRole.name' => 'Admin'
							),
							'fields' => array(
								'id',
								'username'
							),
							'recursive' => 1
						)						
					),
					'fields' => array(
						'id',
						'name',
						'lead',
						'created'
					),
					'recursive' => 2					
		));		
		debug($group); die;
		
		$campaign_count = $this->Group->find('first', array(
			'contain' => array(
				'Campaign' => array(
					'fields' => array(
						'id'
					)
				)
			),
			'fields' => 'id',
			'conditions' => array(
				'id' => $groupId
			)
		));
		$campaign_count = count($campaign_count['Campaign']);
		$linked_group_count = $this->Group->find('first', array(
					'contain' => array(
						'LinkedGroups' => array(
							'fields' => array(
								'id'
							)
						)
					),
					'fields' => 'id',
					'conditions' => array(
						'id' => $groupId
					)
		));
		
		$linked_group_count = count($linked_group_count['LinkedGroups']);		
// 		debug($linked_group_count);
		$administrators = $this->Group->GroupsUser->find('all', array(
			'fields' => array(
				'User.username',
				'User.id'
			),
			'conditions' => array(
				'UserRole.name' => 'Member'
			),
			'limit' => 2,
			'recursive' => 1
		));
		$admin_count = $this->Group->GroupsUser->find('count', array(
			'conditions' => array(
				'UserRole.name' => 'Admin',
				'Group.id' => $groupId
			)
		));
		$this->set('content_sidebar', 'left');
		$this->set('group', $group);
		$this->set('administrators', $administrators);
		$this->set('admin_count', $admin_count);
		$this->set('campaign_count', $campaign_count);
		$this->set(compact('recent_linked_groups'));
		$this->set(compact('linked_group_count'));
		$this->set(compact('userRole'));
		
	}
	
	function linkedGroups($groupId) {
		$this->set('content_sidebar', 'left');
		$this->set('groupId', $groupId);
		$this->set('group', $group);
	}
	function campaigns($groupId) {
		$now = new DateTime();
		$active_campaigns = null;
		$forthcoming_campaigns = null;
		$ended_campaigns = null;
		if(!empty($group['Campaign'])) {
			foreach($group['Campaign'] as $campaign) {
				if($campaign['start_time'] < $now && $campaign['end_time'] > $now) {
					$active_campaigns[] = $campaign;
				}
				if($campaign['end_time'] < $now) {
					$ended_campaigns[] = $campaign;
				}
				if($campaign['start_time'] > $now) {
					$forthcoming_campaigns[] = $campaign;
				}
			}
		}
		$this->set('active_campaigns', $active_campaigns);
		$this->set('ended_campaigns', $ended_campaigns);
		$this->set('forthcoming_campaigns', $forthcoming_campaigns);
		$this->set('content_sidebar', 'left');
		$this->set('group', $group);
		$this->set(compact('userIsAdmin'));
	}
	
	function getCampaignList($groupId) {		
		$this->autoRender = false;
		$this->autoLayout = false;
		$campaigns = $this->Group->find('first', array(
							'conditions' => array(
								'Group.id' => $groupId
							),
							'contain' => array(
								'Campaign' => array(
									'fields' => array(
										'id',
										'name',
										'start_time',
										'end_time'
									),
									'order' =>'end_time DESC'
								)
							),
							'fields' => array(
								'id'
							),
							'recursive' => 2					
		));
		echo json_encode($campaigns);
	}
	function getMemberList($groupId) {
		$this->autoRender = false;
		$this->autoLayout = false;
		$campaigns = $this->Group->find('first', array(
								'conditions' => array(
									'Group.id' => $groupId
								),
								'contain' => array(
									'GroupsUser.User' => array(
										'fields' => array(
											'id',
											'username'
										),
									)
								),
								'fields' => array(
									'id'
								),
								'recursive' => 2					
		));
		echo json_encode($campaigns);
	}
	function getUserRole($groupId, $userId = null) {
		$userId = $userId == null ? $this->userId : $userId;
		$userIsAdmin = $this->Group->GroupsUser->find('first', array(
										'conditions' => array(
											'User.id' => $userId,
											'Group.id' => $groupId
										),
										'recursive' => 2					
		));		
		return $userIsAdmin['UserRole']['name'];
	}
}

