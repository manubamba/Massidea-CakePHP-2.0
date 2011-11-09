<?php
App::uses('AppModel', 'Model');
/**
 * Flag Model
 *
 * @property User $User
 * @property Campaign $Campaign
 * @property Content $Content
 * @property User $User
 * @property Inbox $Inbox
 */
class Flag extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'flagged_uri';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
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
			'joinTable' => 'campaigns_flags',
			'foreignKey' => 'flag_id',
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
			'joinTable' => 'contents_flags',
			'foreignKey' => 'flag_id',
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
		'User' => array(
			'className' => 'User',
			'joinTable' => 'flags_users',
			'foreignKey' => 'flag_id',
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
		),
		'Inbox' => array(
			'className' => 'Inbox',
			'joinTable' => 'inbox_flags',
			'foreignKey' => 'flag_id',
			'associationForeignKey' => 'inbox_id',
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
