<?php
App::uses('AppController', 'Controller');
App::uses('File', 'Utility');
App:: uses('BlowfishPasswordHasher' , 'Controller/Component/Auth' );
App::uses('CakeEmail', 'Network/Email');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SecurityComponent $Security
 * @property SessionComponent $Session
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'Session','Tool','GoogleRecaptcha.GoogleRecaptcha');
	public $helpers = array('Number', 'GoogleRecaptcha.GoogleRecaptcha');


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$user_info = $this->get_user();
		$this->User->recursive = 1;
		$this->paginate = array(
			'Transaction' => array(
				'order' => array('create_date' => 'desc'),
				'limit' => 20,
				'conditions' => array('Transaction.user_id' => $user_info['id']),
				'paramType' => 'querystring'
			),
			'Wallet' => array(
				'limit' => 5,
				'conditions' => array('Wallet.user_id' => $user_info['id']),
				'paramType' => 'querystring'
			),
			'conditions' => array('User.id' => $user_info['id'])
			);
		$this->Paginator->settings = $this->paginate;
		$this->set('transactions', $this->paginate('Transaction'));
		$this->set('wallets', $this->paginate('Wallet'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view() {
		$users = $this->get_user();
		//pr($users); exit;
		$this->set('user', $this->User->findById($users['id']));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if($this->User->validates()){
				$register_code = md5($this->request->data['User']['username']);
				if($this->User->save($this->request->data)) {
					$this->User->saveField('avatar', '/img/default_avatar.png');
					$this->User->saveField('register_code', $register_code);
					$link_confirm = 'http://localhost:3000/moneylover/users/verify/register:'.$register_code.'/user:'.$this->data['User']['username'];

					$email = new CakeEmail();
					$email->config('smtp')
						->to(array($this->data['User']['email'] => $this->data['User']['fullname']))
						->subject('Đăng kí tài khoản thành công')
						->send('Đăng kí thành công tài khoản '.$this->data['User']['username'].' trên hệ thống MoneyLover .Vui lòng truy cập link sau để kích hoạt tài khoản '.$link_confirm);
					$this->Session->setFlash('Đăng kí tài khoản thành công. Vui lòng kiểm tra hộp thư để kích hoạt tài khoản. ', 'default', array('class' => 'alert alert-info'),'auth');
					$this->redirect('/dang-nhap');
				} else {
					$this->Session->setFlash('Có lỗi xảy ra. Vui lòng kiểm tra lại các thông tin và thử lại', 'default', null,'error');
					unset($this->request->data['User']['password']);
					unset($this->request->data['User']['confirm_password']);

				}
			} else{
				$this->Session->setFlash('Có lỗi xảy ra. Vui lòng kiểm tra lại các thông tin và thử lại', 'default', null,'error');
			}
		}
	}

	public function check_active($active){
		if($active != 0){
			return true;
		} else{
			return false;
		}
	}

	public function verify(){
    	//kiểm tra mã kích hoạt
	    if (!empty($this->passedArgs['register']) && !empty($this->passedArgs['user'])){
	        $username = $this->passedArgs['user'];
	        $register_code = $this->passedArgs['register'];
	        $user = $this->User->findByUsername($username);
	        if ($user['User']['actived'] == 0 ){
	            //check the token
	            if($user['User']['register_code'] == $register_code){
	            	$this->User->id  = $user['User']['id'];
	            	$this->User->saveField('actived', 1);
	            	$this->User->saveField('register_code', null);
	                $this->Session->setFlash('Kích hoạt tài khoản thành công', 'default', array('class' => 'alert alert-info'), 'auth');
	                $this->redirect('/dang-nhap');
	            } else{
	                $this->Session->setFlash('Mã kích hoạt không đúng', 'default', array('class' => 'alert alert-danger'), 'auth');
	                //$this->redirect('/users/register');
	            }
	        } else{
	            $this->Session->setFlash('Mã kích hoạt đã được sử dụng', 'default', array('class' => 'alert alert-danger'), 'auth');
	            //$this->redirect('/dang-ki');
	        }
	    } else{
	        $this->Session->setFlash('Mã kích hoạt không đúng. Vui lòng đăng kí tài khoản', 'default', array('class' => 'alert alert-danger'));
	        //$this->redirect('/dang-ki');
	    }
	}

/**
 * uploadFile method
 *
 * @throws NotFoundException
 * @param void
 * @return void
 */

	private function uploadFile(){
		$file = new File($this->request->data['User']['avatar']['tmp_name']);
		$file_name = $this->request->data['User']['avatar']['name'];
		if($file->copy(APP.'webroot/img/'.$file_name)){
			return true;
		} else {
			return false;
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Không tìm thấy trang'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(' Tài khoản đã được xóa.', 'default', array('class' => 'alert alert-danger'));
		} else {
			$this->Session->setFlash(' Tài khoản chưa được xóa. Vui lòng thử lại', 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function delete_avatar(){
		$user_info = $this->get_user();
		$this->User->id = $user_info['id'];
		$default_avatar = '/img/default_avatar.png';
		if($this->User->saveField('avatar', $default_avatar)){
			$this->Session->setFlash('Ảnh đại diện được đặt lại mặc định', 'default', null, 'success');
			$this->redirect(array('action' => 'change_info'));
		}else{
			$this->Session->setFlash('Có lỗi xảy ra', 'default', null, 'error');
			$this->redirect(array('action' => 'change_info'));
		}
	}


	public function beforeFilter() {
		parent:: beforeFilter();
		// Allow users to register and logout.
		$this->Auth->allow('add','forgot','confirm','verify');

	}

	public function login() {
		if ($this->request->is('post' )) {
			if ($this->Auth->login()) {
				$user = $this->get_user();
				if($this->check_active($user['actived'])){
					return $this->redirect(array('controller' => 'transactions', 'action' => 'index'));
				} else{
					$this->Session->setFlash('Bạn chưa kích hoạt tài khoản. Vui lòng kiểm tra email để kích hoạt tài khoản!','default', array('class'=>'alert alert-danger'),'auth');
					return $this->redirect($this->Auth->logout());
				}
			} else{
				$this->Session->setFlash('Tài khoản hoặc mật khẩu không đúng. Vui lòng nhập lại','default', array('class'=>'alert alert-danger'),'auth');
				unset($this->request->data['User']['password']);
			}

		}
	}

	public function logout() {
		return $this->redirect($this->Auth->logout());
	}

	public function change_info(){
		$save = true;
		$user_info = $this->get_user();
		$avatar = $user_info['avatar'];
		if($this->request->is(array('post', 'put'))){
			if($this->User->validates()){
				if(!empty($this->request->data['User']['avatar']['name'])) {
					if($this->uploadFile() ){
						$avatar = '/img/'.$this->request->data['User']['avatar']['name'];
						$this->request->data['User']['avatar'] = $avatar;
					} else{
						$this->Session->setFlash('Ảnh chưa được lưu. Vui lòng thử lại.', 'default', null,'error');
						$save = false;
					}
				} else{
					$user = $this->User->findById($user_info['id']);
					$this->request->data['User']['avatar'] = $user['User']['avatar'];
				}
				//pr($this->request->data); exit;
				$this->User->id = $user_info['id'];
				if($save){
					if($this->User->save($this->request->data)){
						$this->Session->setFlash('Cập nhật thành công', 'default', null,'success');
						$this->redirect($this->referer());
					} else{
						$this->Session->setFlash('Có lỗi xảy ra. Vui lòng thử lại', 'default', null,'error');
						}
				}
			} else{
				$this->Session->setFlash('Có lỗi xảy ra. Vui lòng thử lại 2', 'default', null, 'error');
			}
		}else{
			$this->request->data = $this->User->findById($user_info['id']);
		}
	}


	public function change_password(){
		if($this->request->is('post')) {
			$this->User->set($this->request->data);
			if($this->User->validates()){
				$user_info = $this->get_user();
				// $this->User->id = $user_info['id'];
				if($this->update_password($user_info['id'])) {
					$this->Session->setFlash('Cập nhật mật khẩu thành công', 'default', null, 'success');
					return $this->redirect(array('controller' =>'transactions', 'action' => 'index'));
				} else {
					$this->Session->setFlash('Có lỗi xảy ra. Vui lòng thử lại', 'default', null, 'error');
				}
			} else{
				$this->Session->setFlash('Xác nhận mật khẩu không đúng', 'default', null, 'error');
				unset($this->request->data['User']['password']);
				unset($this->request->data['User']['confirm_password']);
			}
		}
	}

	public function forgot(){
		if($this->request->is('post')){
			$user = $this->User->findByEmail($this->request->data['User']['email']);
			if(!empty($user)){
				$code = $this->Tool->generate_code();
				$link_confirm = 'http://localhost:3000/moneylover/xac-nhan/'.$code;
				$this->User->id = $user['User']['id'];
				$this->User->saveField('code',$code);
				//Gửi link xác nhận đến email
				$email = new CakeEmail();
				$email->config('smtp')
					->to(array($user['User']['email'] => $user['User']['fullname']))
					->subject('Xác nhận quên mật khẩu')
					->send('Bạn vừa yêu cầu lấy lại mật khẩu của tài khoản: '.$user['User']['username'].' trên hệ thống MoneyLover . Vui lòng truy cập link sau để xác nhận lấy lại mật khẩu '.$link_confirm);
				$this->Session->setFlash('Vui lòng kiểm tra hộp thư để lấy lại mật khẩu', 'default', null,'success');

			} else{
				$this->Session->setFlash('Email này chưa được đăng kí', 'default', null, 'error');
			}
		}
	}

	public function confirm($code = null){
		$confirm = false;
		if(!empty($code)){
			$user = $this->User->findByCode($code);
			$this->set('user_info', $user);
			if(!empty($user)){
				$confirm = true;
				if($this->request->is('post')){
					$this->User->set($this->request->data);
					if($this->User->validates()){
						if(strcmp($this->request->data['User']['password'],$this->request->data['User']['confirm_password']) == 0){
							if($this->update_password($user['User']['id'])){
								$this->User->updateAll(array('User.code' => null), array('User.id'=>$user['User']['id']));
								$this->Session->setFlash('Lấy lại mật khẩu thành công. Vui lòng đăng nhập bằng mật khẩu mới', 'default', array('class' => 'alert alert-info'),'auth');
								return $this->redirect(array( 'controller' => 'users', 'action' => 'login'));
							} else{
								$this->set('errors', $this->validationErrors);
							}
						} else {
							$this->Session->setFlash('Xác nhận mật khẩu không đúng. Vui lòng thử lại', 'default', null, 'error');
							unset($this->request->data['User']['password']);
							unset($this->request->data['User']['confirm_password']);
						}
				}
			}
		}
		$this->set('confirm', $confirm);
	}
}

	public function update_password($id){
		$this->User->id = $id;
		if($this->User->saveField('password',$this->request->data['User']['password'])) {
			return true;
		} else {
			return false;
		}
	}

	public function about_us(){

	}

	public function contact(){
		$user_info = $this->get_user();
		$contact_detail = 'Phản hồi của khách hàng '.$user_info['fullname'].' từ tài khoản '.$user_info['username'].':
		 ';
		if(!empty($this->request->data)){

			$email = new CakeEmail();
				$email->config('smtp')
					->to(array('cuongnm4215@gmail.com'))
					->subject('Phản hồi của khách hàng')
					->send($contact_detail.$this->request->data['User']['email']);
			$this->Session->setFlash('Cảm ơn bạn đã gửi phản hồi', 'default', null, 'success');
			$this->redirect('/lien-he');
		}
	}


}
