<?php
App::uses('AppModel', 'Model');
/**
 * Campaign Model
 *
 * @property Content $Content
 * @property File $File
 * @property Flag $Flag
 * @property Group $Group
 * @property Language $Language
 * @property Link $Link
 * @property PersonalTag $PersonalTag
 * @property PrivateMessage $PrivateMessage
 * @property Rating $Rating
 * @property RelatedCompany $RelatedCompany
 * @property Tag $Tag
 * @property Town $Town
 * @property User $User
 * @property Linked $Linked
 */
class Campaign extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
	public $actsAs = array('Containable');
/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		
		'Content' => array(
			'className' => 'Content',
			'joinTable' => 'campaigns_contents',
			'foreignKey' => 'campaign_id',
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
		'File' => array(
			'className' => 'File',
			'joinTable' => 'campaigns_files',
			'foreignKey' => 'campaign_id',
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
		'Flag' => array(
			'className' => 'Flag',
			'joinTable' => 'campaigns_flags',
			'foreignKey' => 'campaign_id',
			'associationForeignKey' => 'flag_id',
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
		'Group' => array(
			'className' => 'Group',
			'joinTable' => 'campaigns_groups',
			'foreignKey' => 'campaign_id',
			'associationForeignKey' => 'group_id',
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
			'joinTable' => 'campaigns_languages',
			'foreignKey' => 'campaign_id',
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
			'joinTable' => 'campaigns_links',
			'foreignKey' => 'campaign_id',
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
			'joinTable' => 'campaigns_personal_tags',
			'foreignKey' => 'campaign_id',
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
			'joinTable' => 'campaigns_private_messages',
			'foreignKey' => 'campaign_id',
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
			'joinTable' => 'campaigns_ratings',
			'foreignKey' => 'campaign_id',
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
			'joinTable' => 'campaigns_related_companies',
			'foreignKey' => 'campaign_id',
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
		'Tag' => array(
			'className' => 'Tag',
			'joinTable' => 'campaigns_tags',
			'foreignKey' => 'campaign_id',
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
			'joinTable' => 'campaigns_towns',
			'foreignKey' => 'campaign_id',
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
		'User' => array(
			'className' => 'User',
			'joinTable' => 'campaigns_users',
			'foreignKey' => 'campaign_id',
			'associationForeignKey' => 'user_id',
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
