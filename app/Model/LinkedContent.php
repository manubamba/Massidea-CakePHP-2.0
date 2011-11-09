<?php
App::uses('AppModel', 'Model');
/**
 * LinkedContent Model
 *
 */
class LinkedContent extends AppModel {
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
				'className' => 'Content',
				'foreignKey' => 'from',
				'conditions' => '',
				'fields' => '',
				'order' => ''
	),
			'To' => array(
				'className' => 'Content',
				'foreignKey' => 'to',
				'conditions' => '',
				'fields' => '',
				'order' => ''
	)
	);
	
}
