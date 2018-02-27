<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 * @property Transaction $Transaction
 */
class Category extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'category_name';

	public $validate = array(
		'category_name' => array(
			'required' => array(
				'rule' => 'notBlank' ,
				'message' => 'Tên danh mục không được trống'
				),
			'unique' => array(
				'rule' =>'isUnique',
				'message' => 'Tên danh mục đã tồn tại. Vui lòng thử lại'
				),
			)
		);


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Transaction' => array(
			'className' => 'Transaction',
			'foreignKey' => 'category_id',
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

}
