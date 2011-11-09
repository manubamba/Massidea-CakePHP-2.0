<?php
App::uses('AppController', 'Controller');
/**
 * Contents Controller
 *
 */
class ContentsController extends AppController {
	public $components = array('Cookie', 'CookieValidation');
	public $validContentTypes = array('challenge','idea','vision');	
// 	public $uses = array('Contents','Language','LinkedContent','Tags', 'RelatedCompanies','Baseclasses');
	
	
	public function browse($contentType = 'all') {		
		if($contentType = $this->validateContentType($contentType)) {
			$contents = $this->Content->find('all',	
				array(
					'limit' => 10,
					'order' => 'Content.created DESC',
					'conditions' => array(
						'class' => $contentType
					)
					
				)
			);			
		}
		else {
			$contents = $this->Content->find('all',	
				array(
					'limit' => 10,
					'order' => 'Content.created DESC'
				)
			);
			$contentType = 'all';
		}		
		$userIdsAndCounts = array();	
		foreach($contents as $content) {
			if(isset($content['User']['id']) && !isset($userIdsAndCounts[$content['User']['id']])) {
				$userIdsAndCounts[$content['User']['id']] = $this->Content->find('count',
					array(
						'conditions' => array(
							'user_id' => $content['User']['id']
						)
					)
				);
			}
		}
	
		$this->set('contentCounts',$userIdsAndCounts);
		$this->set('content_type',$contentType);
		$this->set('contents',$contents);
	}
	/**
	* add action - method
	* Adds content
	*
	* Routes that direct to this action are:
	* Router::connect('/contents/add/*', array('controller' => 'contents', 'action' => 'add'));
	*
	* @author	Jari Korpela
	* @param	enum $content_type Accepted values: 'all', 'challenge', 'idea', 'vision'
	* @param	int	$related To what content this content will be linked to
	*/
	public function add($contentType = 'challenge', $related = 0) {
	
		if(isset($this->userId)) {
				
			if(!$contentType = $this->Content_->validateContentType($contentType)) {
				//We validate the contentType received from url to prevent XSS.
				$this->redirect('/');
			}
	
			if (!empty($this->data)) {
				// If form has been posted
				$this->data['Node']['type'] = 'Content'; //Set Node type
				$this->data['Privileges']['creator'] = $this->userId; // Set creator to the logged in user
	
				if($this->data['Node']['published'] == 1) {
					$this->data['Privileges']['privileges'] = '755'; // Set basic privileges
				} else {
					$this->data['Privileges']['privileges'] = '700'; // Set privileges so that other users cant read it
				}
	
				if(in_array($contentType,$this->validContentTypes)) {
					$this->data['Node']['class'] = $contentType;
				}
	
				$this->Content_->setAllContentDataForSave($this->data);
				$this->Tag_->setTagsForSave($this->data['Tags']['tags'],$this->data['Privileges']);
				$this->Company_->setCompaniesForSave($this->data['Companies']['companies'],$this->data['Privileges']);
	
	
				if($this->Content_->saveContent() !== false) {
					//If saving the content was successfull then...
					//TODO: This area is missing a method to link the $related content to this content. Should be done when the link method is ready.
						
					$this->Tag_->linkTagsToObject($this->Content_->getContentId()); //We have content ID after content has been saved
					$this->Company_->linkCompaniesToObject($this->Content_->getContentId());
	
					$this->Session->setFlash('Your content has been successfully saved.', 'flash'.DS.'successfull_operation');
	
					if($this->Content_->getContentPublishedStatus() === "1") {
						$this->redirect(array('controller' => 'contents', 'action' => 'view', $this->Content_->getContentId()));
					} else {
						$this->redirect(array('controller' => 'contents', 'action' => 'edit', $this->Content_->getContentId()));
					}
				} else {
					$this->Session->setFlash('Your content has NOT been successfully saved.');
				}
			}
				
			//$this->helpers[] = 'TinyMce.TinyMce'; //Commented out for future use...
				
	
			$this->set('language_list',$this->Language->find('list',array('order' => array('Language.name' => 'ASC'))));
			$this->set('content_type',$contentType);
	
		} else {
			$this->redirect('/');
		}
	
	}
	
	/**
	 * edit action - method
	 * Edits content
	 *
	 * Routes that direct to this action are:
	 * Router::connect('/contents/edit/*', array('controller' => 'contents', 'action' => 'edit'));
	 *
	 * @author	Jari Korpela
	 * @param	int $contentId
	 */
	public function edit($contentId = -1) {
		if(isset($this->userId)) {
				
			if (!empty($this->data)) {
				// If form has been posted
				
	
				//check that the content id is owned by the user
				$content = $this->Nodes->find(array('type' => 'Content', 'Privileges.creator' => $this->userId, 'Privileges.id' => $contentId),array(),true);
	
				if(empty($content)) {
					$this->Session->setFlash('You dont own that content so go away!');
					$this->redirect('/');
				}
	
				$this->data['Privileges'] = $content[0]['Privileges'];
	
				if($this->data['Node']['published'] == 1) {
					$this->data['Privileges']['privileges'] = '755'; // Set basic privileges
				} else {
					$this->data['Privileges']['privileges'] = '700'; // Set privileges so that other users cant read it
				}
	
				$this->data['Node']['type'] = 'Content';
				$this->data['Node']['id'] = $contentId;
				$this->data['Node']['class'] = $content[0]['Node']['class'];
	
				//$this->data['Privileges']['creator'] = NULL;
				$this->Content_->setAllContentDataForSave($this->data);
	
				$this->Tag_->setTagsForSave($this->data['Tags']['tags'],array('privileges' => 555, 'creator' => $this->userId));
				$this->Company_->setCompaniesForSave($this->data['Companies']['companies'],array('privileges' => 555, 'creator' => $this->userId));
	
				$contentBeforeSave = $content;
				$childsToDelete = $contentBeforeSave[0]['Child'];
	
				foreach($childsToDelete as $key => $child) {
					foreach($this->Tag_->getNewAndExistingTags() as $tag) {
						if($child['id'] == $tag['Node']['id']) {
							unset($childsToDelete[$key]); continue 2;
						}
					}
					foreach($this->Company_->getNewAndExistingCompanies() as $company) {
						if($child['id'] == $company['Node']['id']) {
							unset($childsToDelete[$key]); continue 2;
						}
					}
				}
	
				if($this->Content_->saveContent() !== false) {
					//If saving the content was successfull then...
						
					$this->Content_->removeChildsFromContent($childsToDelete);
					$this->Tag_->linkTagsToObject($this->Content_->getContentId()); //We have content ID after content has been saved
					$this->Company_->linkCompaniesToObject($this->Content_->getContentId());
						
					$errors = array();
					if(empty($errors)) {
						$this->Session->setFlash('Your content has been successfully saved.', 'flash'.DS.'successfull_operation');
	
					} else {
						$this->Session->setFlash('Your content has NOT been successfully saved.');
					}
	
					if($this->Content_->getContentPublishedStatus() === "1") {
						$this->redirect(array('controller' => 'contents', 'action' => 'view', $this->Content_->getContentId()));
					} else {
						$this->redirect(array('controller' => 'contents', 'action' => 'edit',$contentId));
					}
	
				} else {
					$this->Session->setFlash('Your content has NOT been successfully saved.');
					$this->redirect('edit/'.$contentId);
				}
			} else {
				if($contentId == -1) {
					$this->redirect('/');
				}
				$this->Nodes->cache = false;
				$content = $this->Nodes->find(array('type' => 'Content', 'Contents.id' => $contentId),array(),true);
	
				if(empty($content)) {
					$this->Session->setFlash('Invalid content ID');
					$this->redirect('/');
				} else {
					$this->Content_->setAllContentDataForEdit($content[0]);
					$editData = $this->Content_->getContentDataForEdit();
					$this->data = $editData;
				}
				$this->set('language_list',$this->Language->find('list',array('order' => array('Language.name' => 'ASC'))));
				$this->set('content_type',$content[0]['Node']['class']);
			}
		} else {
			$this->redirect('/');
		}
	}
	
	/**
	 * view action - method
	 * Views content
	 *
	 * @author	Jari Korpela
	 * @param	int $contentId
	 */
	public function view($contentId = -1) {
		if($contentId == -1) {
			$this->redirect('/');
		}
		$this->set('content_class','contentWithTopAndSidebar');
		$content = $this->Content->find('first',
			array(
				'conditions'=>array(
					'Content.id' => $contentId
				)
			)
		);
		if(empty($content)) {
			$this->Session->setFlash('Invalid content ID');
			$this->redirect('/');
		}
// 		debug($content);
		$contentUserId = $content['User']['id'];
		$isOwner = $contentUserId == $this->userId;
	
		$contentUsername = $content['User']['username'];
	
		$contentSpecificData = $this->parseExternals($content['Content']['data']);
		$tags = array();
		$relatedCompanies = array();
		if(isset($content['Child'])) {
			foreach($content['Child'] as $child) {
				if($child['type'] == 'Tag') {
					$tags[] = $child;
				} elseif ($child['type'] == 'RelatedCompany') {
					$relatedCompanies[] = $child;
				}
			}
		}
		
		$linkedContents = $content['LinkedContents'];
		$linkedContentsCount = sizeof($linkedContents);
	
// 		debug($linkedContents);die;
	
	
		$cookies = $this->CookieValidation->getAndValidateCookies('expandStatus');
		$this->set('cookies',$cookies);
		$this->set('isOwner',$isOwner);
		$this->set('contentId',$contentId);
		$this->set('content',$content['Content']);
		$this->set('contentUserId',$contentUserId);
		$this->set('contentUsername',$contentUsername);
		$this->set('language',$content['Language']);
		$this->set('tags',$tags);
		$this->set('relatedCompanies',$relatedCompanies);
		$this->set('specific',$contentSpecificData);
		$this->set('linkedContents',$linkedContents);
		$this->set('linkedContentsCount',$linkedContentsCount);
	
	}
	
	/**
	* validateContentType
	* Validates and sets contents content type
	* @param string $contentType
	* @return object AddContent
	*/
	public function validateContentType($contentType) {
		if(($contentType === 'challenge') || ($contentType === 'idea') || ($contentType === 'vision')) {
			$this->_contentType = $contentType;
		} else {
			$this->_contentType = null;
		}
	
		return $this->_contentType;
	}
	
	/**
	* parseExternals
	* Parses string data formatted as (#key[base64encoded value]#otherkey[...]) to array
	* @author	Jussi Raitanen
	* @param	string $data - String to form into associative array
	* @return	array $data - Result array
	*/
	public function parseExternals($data) {
		$custom_types = array();
	
		$start_tag = 0;
		$start_data = 0;
		$end_data = 0;
		$nest_level = 0;
	
		for($i=0; $i < strlen($data); $i++) {
			$c = $data[$i];
	
			if ($c == '#') {
				if ($nest_level == 0 )
				$start_tag = $i +1;
			}
	
			if ($c == '[') {
				$nest_level++;
				if ($nest_level == 1)
				$start_data = $i +1;
			}
	
			if ($c == ']') {
				if ($nest_level == 1) {
					$end_data = $i -1;
	
					$tag = substr($data, $start_tag, $start_data - $start_tag -1);
					$type_data = substr($data, $start_data, $end_data - $start_data +1);
					$custom_types[$tag] = base64_decode($type_data);
				}
				$nest_level--;
			}
		}
	
		return $custom_types;
	}
	
}
