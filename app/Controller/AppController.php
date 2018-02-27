<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $helper = array('Time');
    

	public $components = array(
		'Session',
		'Auth' => array(
			'authError' => 'Bạn cần phải đăng nhập để tiếp tục',
			'flash' => array(
				'key' => 'authenticate',
				'element' => 'default',
				'params' => array('class' => 'alert alert-danger')
				),
			'loginRedirect' => array(
				'controller' => 'transactions' ,
				'action' => 'index'
		),
			'logoutRedirect' => array(
				'controller' => 'users' ,
				'action' => 'login' 
				//'home'
		),
		'authenticate' => array(
			'Form' => array(
				'passwordHasher' => 'Blowfish'
			)
		)
		
	)
);
	public function beforeFilter() {
		$this->Auth->allow('add');
		$user = $this->get_user();
		$this->loadModel('User');
		$this->set('user_info',$this->User->findById($user['id']));
	}

	public function get_user(){
		if($this->Auth->login()){
			return $this->Auth->user();
		}
	}
}
