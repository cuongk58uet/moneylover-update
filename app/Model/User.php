<?php
App::uses('AppModel', 'Model');
App:: uses('BlowfishPasswordHasher' , 'Controller/Component/Auth' );
/**
 * User Model
 *
 * @property Wallet $Wallet
 */
class User extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'username';
	public $actsAs = array('Containable');

/**
 * Validation rules
 *
 * @var array
 */

	// The Associations below have been created with all possible keys, those that are not needed can be removed


	public $validate = array(
		'username' => array(
			'required' => array(
				'rule' => 'notBlank' ,
				'message' => 'Tên đăng nhập không được trống'
				),
			'unique' => array(
				'rule' =>'isUnique',
				'message' => 'Tên tài khoản đã tồn tại. Vui lòng thử lại'
				),
			'minlength' => array(
				'rule' => array('minlength', 5),
				'message' => 'Tên đăng nhập ít nhất 5 kí tự'
				)
			),
		'password' => array(
			'required' => array(
				'rule' => 'notBlank' ,
				'message' => ' Mật khẩu không được trống'),
			'minlength' => array(
				'rule' => array('minlength',8),
				'message' => 'Mật khẩu tối thiểu 8 kí tự'
			)
		),
		'confirm_password' => array(
				'required' => array(
					'rule' => 'notBlank' ,
					'message' => ' Xác nhận mật khẩu không được trống'),
				'check_confirm_password' => array(
					'rule' => 'check_confirm_password',
					'message' => 'Xác nhận mật khẩu không đúng'
				)
			),
		'email' => array(
			'required' => array(
				'rule' => 'email',
				'message' => 'Email không được trống'
				),
			'unique' => array(
				'rule' =>'isUnique',
				'message' => 'Email này đã được đăng kí. Vui lòng thử lại'
				)
			),

		'role' => array(
			'valid' => array(
				'rule' => array('inList' , array('admin' , 'author' )),
				'message' => 'Vui lòng nhập giá trị' ,
				'allowEmpty' => true)),

		'avatar' => array(
	        'rule' => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
	        'message' => 'Vui lòng chọn file hình ảnh dạng gif/ jpg/ jpeg/ png',
	        'allowEmpty' => true
	    ),
	    'phone' => array(
	    	'rule' => array('numeric'),
	    	'message' => 'Vui lòng nhập số điện thoại của bạn'
	    	)
		);


	public function beforeSave($options = array()) {
		if(isset($this->data['User']['password'])){
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data['User']['password'] = $passwordHasher->hash($this->data['User']['password']);
		}
		if(isset($this->data['User']['username'])) {
			$user = $this->findByUsername($this->data['User']['username']);
			if(!empty($user)){
				unset($this->data['User']['username']);
			}
		}
		return true;
	}

	public function check_confirm_password($check){
		$password = $this->data['User']['password'];
		$confirm_password = $this->data['User']['confirm_password'];
		if(strcmp($password, $confirm_password) == 0){
			return true;
		} else{
			return false;
		}
	}

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Wallet' => array(
			'className' => 'Wallet',
			'foreignKey' => 'user_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Transaction' => array(
			'className' => 'Transaction',
			'foreignKey' => 'user_id',
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
