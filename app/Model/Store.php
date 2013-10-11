<?php
App::uses('AppModel', 'Model');
/**
 * Store Model
 *
 * @property User $User
 */
class Store extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'Stores';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'key';

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
		'key' => array(
			'A_Za_z0_9' => array(
				'rule' => array('custom', '/^[A-Za-z0-9\.-]+$/'),
				'message' => 'Alphanumerics, dots, and dashes only',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'data' => array(
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


	public function beforeSave($options = array()) {
		// if (isset($this->data[$this->alias]['password'])) {
	 //        $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
	 //    }
		$this->data[$this->alias]['user_id'] = AuthComponent::user('id');
		return true;
	}

}
