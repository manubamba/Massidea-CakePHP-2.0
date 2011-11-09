<?php
App::uses('AppModel', 'Model');
/**
 * Group Model
 *
 * @property CommentsGroup $CommentsGroup
 * @property Campaign $Campaign
 * @property Content $Content
 * @property Country $Country
 * @property File $File
 * @property Language $Language
 * @property Link $Link
 * @property PersonalTag $PersonalTag
 * @property PrivateMessage $PrivateMessage
 * @property Rating $Rating
 * @property RelatedCompany $RelatedCompany
 * @property Request $Request
 * @property Tag $Tag
 * @property Town $Town
 * @property User $User
 * @property Linked $Linked
 */
class Group extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $actsAs = array('Containable');
	public $displayField = 'name';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'closed' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
	
	public $hasMany = array(
			'CommentsGroup' => array(
				'className' => 'CommentsGroup',
				'foreignKey' => 'group_id',
				'dependent' => false,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			),
			'GroupsUser' => array(
				'className' => 'GroupsUser',
				'foreignKey' => 'group_id',
				'dependent' => false,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Campaign' => array(
			'className' => 'Campaign',
			'joinTable' => 'campaigns_groups',
			'foreignKey' => 'group_id',
			'associationForeignKey' => 'campaign_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Content' => array(
			'className' => 'Content',
			'joinTable' => 'contents_groups',
			'foreignKey' => 'group_id',
			'associationForeignKey' => 'content_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Country' => array(
			'className' => 'Country',
			'joinTable' => 'countries_groups',
			'foreignKey' => 'group_id',
			'associationForeignKey' => 'country_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'File' => array(
			'className' => 'File',
			'joinTable' => 'files_groups',
			'foreignKey' => 'group_id',
			'associationForeignKey' => 'file_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Language' => array(
			'className' => 'Language',
			'joinTable' => 'groups_languages',
			'foreignKey' => 'group_id',
			'associationForeignKey' => 'language_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Link' => array(
			'className' => 'Link',
			'joinTable' => 'groups_links',
			'foreignKey' => 'group_id',
			'associationForeignKey' => 'link_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'PersonalTag' => array(
			'className' => 'PersonalTag',
			'joinTable' => 'groups_personal_tags',
			'foreignKey' => 'group_id',
			'associationForeignKey' => 'personal_tag_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'PrivateMessage' => array(
			'className' => 'PrivateMessage',
			'joinTable' => 'groups_private_messages',
			'foreignKey' => 'group_id',
			'associationForeignKey' => 'private_message_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Rating' => array(
			'className' => 'Rating',
			'joinTable' => 'groups_ratings',
			'foreignKey' => 'group_id',
			'associationForeignKey' => 'rating_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'RelatedCompany' => array(
			'className' => 'RelatedCompany',
			'joinTable' => 'groups_related_companies',
			'foreignKey' => 'group_id',
			'associationForeignKey' => 'related_company_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
// 		'Request' => array(
// 			'className' => 'Request',
// 			'joinTable' => 'groups_requests',
// 			'foreignKey' => 'group_id',
// 			'associationForeignKey' => 'request_id',
// 			'unique' => true,
// 			'conditions' => '',
// 			'fields' => '',
// 			'order' => '',
// 			'limit' => '',
// 			'offset' => '',
// 			'finderQuery' => '',
// 			'deleteQuery' => '',
// 			'insertQuery' => ''
// 		),
		'Tag' => array(
			'className' => 'Tag',
			'joinTable' => 'groups_tags',
			'foreignKey' => 'group_id',
			'associationForeignKey' => 'tag_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Town' => array(
			'className' => 'Town',
			'joinTable' => 'groups_towns',
			'foreignKey' => 'group_id',
			'associationForeignKey' => 'town_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'LinkedGroups' => array(
			'className' => 'Group',
			'joinTable' => 'linked_groups',
			'foreignKey' => 'from',
			'associationForeignKey' => 'to',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

}
