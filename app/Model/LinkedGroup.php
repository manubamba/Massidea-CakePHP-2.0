<?php
App::uses('AppModel', 'Model');
/**
 * LinkedGroup Model
 *
 */
class LinkedGroup extends AppModel {
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'from' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'to' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	public $belongsTo = array(
			'From' => array(
				'className' => 'Group',
				'foreignKey' => 'from',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			),
			'To' => array(
				'className' => 'Group',
				'foreignKey' => 'to',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			)
	);
	
}
