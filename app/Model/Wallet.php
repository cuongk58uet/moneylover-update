<?php
App::uses('AppModel', 'Model');
/**
 * Wallet Model
 *
 * @property User $User
 * @property Transaction $Transaction
 */
class Wallet extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'wallet_name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
		'wallet_name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			)
		),
		'currency' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			)
		),
		'banlances' => array(
			'rule' => array('naturalNumber', true),
			'message' => 'Số dư phải là một tự nhiên'
			)
	);

	public function beforeSave($options = array()) {
		if(!empty($this->data['Wallet']['wallet_name'])){
			$this->data['Wallet']['slug'] = $this->create_slug($this->data['Wallet']['wallet_name']);
		}
		return true;
	}

	// The Associations below have been created with all possible keys, those that are not needed can be removed

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
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Transaction' => array(
			'className' => 'Transaction',
			'foreignKey' => 'wallet_id',
			'dependent' => true,
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

}
