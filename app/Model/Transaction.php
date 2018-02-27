<?php
App::uses('AppModel', 'Model');
/**
 * Transaction Model
 *
 * @property Wallet $Wallet
 * @property Category $Category
 */
class Transaction extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'amount';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'amount' => array(
			'rule' => array('naturalNumber'),
			'message' => 'Giá trị giao dịch phải là số tự nhiên lớn hơn 0'
		),
		'create_date' => array(
			'date' => array(
				'rule' => array('date'),
				'message' => 'Ngày tháng nhập vào không đúng. Vui lòng thử lại'
			),
		),
	);

	public function beforeSave($options = array()) {
		if(!empty($this->data['Transaction']['note'])){
			$this->data['Transaction']['slug'] = $this->create_slug($this->data['Transaction']['note']);
		} else{
			$this->data['Transaction']['slug'] = $this->create_slug($this->data['Transaction']['create_date']);
		}
		return true;
	}

	public function check_amount($check){
		if($this->data['amount'] > 0){
			return true;
		} else{
			return false;
		}
	}

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Wallet' => array(
			'className' => 'Wallet',
			'foreignKey' => 'wallet_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
