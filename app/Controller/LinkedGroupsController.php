<?php
/**
 *  LinkedroupsController
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
 *  LinkedGroupsController - class
 *	TODO: User checks when users done.
 *  @package        controllers
 *  @author         Manu Bamba
 *  @copyright      Manu Bamba
 *  @license        GPL v2
 *  @version        1.0
 */
 
class LinkedGroupsController extends AppController {
	public $uses = array('Group', 'LinkedGroup');
// 	public $components = array('RequestHandler');
	public $helpers = null; //Set helpers off
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->autoRender = false;
		$this->autoLayout = false;

	}
		
	/**
	 * list action - method
	 * Lists linked groups
	 * @author Manu Bamba
	 */
	public function getList($groupId) {			
			if (!empty($groupId)) {	
				$groupLinks = $this->LinkedGroup->findAllByFrom($groupId, array('To.id','To.name'));
				echo json_encode($groupLinks);
            } else {
				$this->redirect('/');
			}
	}
	
	/**
	 * add action - method
	 * Links two things together
	 * TODO: Data validation and check that user who tries to add the link has privileges
	 * @author Jari Korpela
	 */
	public function add() {
// 		debug($this->data); die;
// 		if ($this->RequestHandler->isAjax()) {
			if (!empty($this->request)) {	
// 				$this->saveData['LinkedGroup']['from'] = $this->data['from'];
// 				$this->saveData['LinkedGroup']['to'] = $this->data['to'];
				$this->LinkedGroup->Save($this->data);		
				echo 1;
			} else {
				$this->redirect('/');
			}
// 		} else {
// 			$this->redirect('/');
// 		}
	}
	
	/**
	 * delete action - method
	 * Deletes a link between Ids
	 * TODO: Data validation and check that user who tries to delete the link has privileges
	 * @author Jari Korpela
	 */
	public function delete() {
		if ($this->RequestHandler->isAjax()) {
			if (!empty($this->params['form'])) {
				$to = $this->params['form']['to'];
				$from = $this->params['form']['from'];
				$this->Nodes->removeLink($from,$to);
				echo 1;
			}
		} else {
			$this->redirect('/');
		}
	}
}