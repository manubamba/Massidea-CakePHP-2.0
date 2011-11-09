<?php
App::uses('AppController', 'Controller');
/**
 * Campaigns Controller
 *
 * @property Campaign $Campaign
 */
class CampaignsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Campaign->recursive = 0;
		$this->set('campaigns', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Campaign->id = $id;
		if (!$this->Campaign->exists()) {
			throw new NotFoundException(__('Invalid campaign'));
		}
		$this->set('campaign', $this->Campaign->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Campaign->create();
			if ($this->Campaign->save($this->request->data)) {
				$this->Session->setFlash(__('The campaign has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The campaign could not be saved. Please, try again.'));
			}
		}
		$comments = $this->Campaign->Comment->find('list');
		$contents = $this->Campaign->Content->find('list');
		$files = $this->Campaign->File->find('list');
		$flags = $this->Campaign->Flag->find('list');
		$groups = $this->Campaign->Group->find('list');
		$languages = $this->Campaign->Language->find('list');
		$links = $this->Campaign->Link->find('list');
		$personalTags = $this->Campaign->PersonalTag->find('list');
		$privateMessages = $this->Campaign->PrivateMessage->find('list');
		$ratings = $this->Campaign->Rating->find('list');
		$relatedCompanies = $this->Campaign->RelatedCompany->find('list');
		$tags = $this->Campaign->Tag->find('list');
		$towns = $this->Campaign->Town->find('list');
		$users = $this->Campaign->User->find('list');
		$this->set(compact('comments', 'contents', 'files', 'flags', 'groups', 'languages', 'links', 'personalTags', 'privateMessages', 'ratings', 'relatedCompanies', 'tags', 'towns', 'users'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Campaign->id = $id;
		if (!$this->Campaign->exists()) {
			throw new NotFoundException(__('Invalid campaign'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Campaign->save($this->request->data)) {
				$this->Session->setFlash(__('The campaign has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The campaign could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Campaign->read(null, $id);
		}
		$comments = $this->Campaign->Comment->find('list');
		$contents = $this->Campaign->Content->find('list');
		$files = $this->Campaign->File->find('list');
		$flags = $this->Campaign->Flag->find('list');
		$groups = $this->Campaign->Group->find('list');
		$languages = $this->Campaign->Language->find('list');
		$links = $this->Campaign->Link->find('list');
		$personalTags = $this->Campaign->PersonalTag->find('list');
		$privateMessages = $this->Campaign->PrivateMessage->find('list');
		$ratings = $this->Campaign->Rating->find('list');
		$relatedCompanies = $this->Campaign->RelatedCompany->find('list');
		$tags = $this->Campaign->Tag->find('list');
		$towns = $this->Campaign->Town->find('list');
		$users = $this->Campaign->User->find('list');
		$this->set(compact('comments', 'contents', 'files', 'flags', 'groups', 'languages', 'links', 'personalTags', 'privateMessages', 'ratings', 'relatedCompanies', 'tags', 'towns', 'users'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Campaign->id = $id;
		if (!$this->Campaign->exists()) {
			throw new NotFoundException(__('Invalid campaign'));
		}
		if ($this->Campaign->delete()) {
			$this->Session->setFlash(__('Campaign deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Campaign was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
