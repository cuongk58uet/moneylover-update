<?php
App::uses('AppController', 'Controller');
/**
 * Transactions Controller
 *
 * @property Transaction $Transaction
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class TransactionsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->loadModel('Wallet');
		$currentMonth = date('m');
		$currentYear = date('Y');
		$this->set('currentMonth',$currentMonth);
		$this->set('currentYear', $currentYear);
		$user_info = $this->get_user();

		$this->Transaction->recursive = 0;
		$this->paginate = array(
			'order' => array('Transaction.create_date' => 'desc', 'Transaction.id' => 'desc'),
			'limit' => 10,
			'conditions' => array('Transaction.user_id' => $user_info['id']),
			'paramType' => 'querystring'
			);
		$this->Paginator->settings = $this->paginate;
		$this->set('transactions', $this->paginate());

		$inflow = $this->Transaction->find('all', array(
				'fields' => array('SUM(amount) AS Total'),
				'conditions' => array(
					'month(create_date)' => $currentMonth,
					'year(create_date)'=> $currentYear,
					'Category.category_type' => array('Thu Nhập','Nợ'),
					'Transaction.user_id' => $user_info['id']
					),
			));
		if(empty($inflow)){
			$inflow = 0;
		}
		$this->set('inflow', $inflow);
		//pr($inflow); exit;
		$outflow = $this->Transaction->find('all', array(
				'fields' => array('SUM(amount) AS Total'),
				'conditions' => array(
					'month(create_date)' => $currentMonth,
					'year(create_date)'=> $currentYear,
					'Category.category_type' => array('Chi Tiêu', 'Cho Vay'),
					'Transaction.user_id' => $user_info['id']
					)
			));
		if(empty($outflow)){
			$outflow = 0;
		}
		$this->set('outflow', $outflow);
		//pr($outflow); exit;

		$netIncome = $inflow['0']['0']['Total'] - $outflow['0']['0']['Total']; //Thu nhập ròng
		$this->set('netIncome', $netIncome);
		//pr($netIncome); exit;
		//pr($this->paginate()); exit;
		$allowDisplayList = true;
	/*
		begin search function
	*/
		$wallets = $this->Wallet->find('list', array(
			'conditions' => array('user_id' => $user_info['id'])
			));
		$this->set(compact('wallets'));
		//debug($this->request->query); exit;
		if(!empty($this->request->query['create_date'])){
			if(empty($this->request->query['wallet_id'])){
				$this->Paginator->settings = array(
					'order' => array('Transaction.create_date' => 'desc', 'Transaction.id' => 'desc'),
					'conditions' => array(
						'Transaction.user_id' => $user_info['id'],
						'day(create_date)' => $this->request->query['create_date']['day'],
						'month(create_date)' => $this->request->query['create_date']['month'],
						'year(create_date)'=> $this->request->query['create_date']['year'] ,
						),
					'paramType' => 'querystring'
					);
				$allowDisplayList = false;
			} else{
				$this->Paginator->settings = array(
					'order' => array('Transaction.create_date' => 'desc', 'Transaction.id' => 'desc'),
					'conditions' => array(
						'Transaction.user_id' => $user_info['id'],
						'day(create_date)' => $this->request->query['create_date']['day'],
						'month(create_date)' => $this->request->query['create_date']['month'],
						'year(create_date)'=> $this->request->query['create_date']['year'],
						'wallet_id' => $this->request->query['wallet_id']
						),
					'paramType' => 'querystring'
					);
				$allowDisplayList = false;
			}

			//pr($search_result); exit;

			$this->set('search_result', $this->Paginator->paginate());
		}
		$this->set('allowDisplayList', $allowDisplayList);
	/*
	end search function
	*/

	}

/**
* report method
*
*
*/
	public function report($month,$year){
		$user_info = $this->get_user();
		$inflow = $this->Transaction->find('all', array(
				'fields' => array('SUM(amount) AS Total'),
				'conditions' => array(
					'month(create_date)' => $month,
					'year(create_date)' => $year,
					'Category.category_type' => array('Thu Nhập','Nợ'),
					'Transaction.user_id' => $user_info['id']
					)
			));
		$this->set('inflow', $inflow);
		//pr($inflow); exit;
		$outflow = $this->Transaction->find('all', array(
				'fields' => array('SUM(amount) AS Total'),
				'conditions' => array(
					'month(create_date)' => $month,
					'year(create_date)' => $year,
					'Category.category_type' => array('Chi Tiêu', 'Cho Vay'),
					'Transaction.user_id' => $user_info['id']
					)
			));
		$this->set('outflow', $outflow);
		//pr($outflow); exit;
		$netIncome = $inflow['0']['0']['Total'] - $outflow['0']['0']['Total']; //Thu nhập ròng
		$this->set('netIncome', $netIncome);

		$most_outflow = $this->Transaction->find('first', array(
			'conditions' => array(
				'month(create_date)' => $month,
				'year(create_date)' => $year,
				'Category.category_type' => array('Chi Tiêu', 'Cho Vay'),
				'Transaction.user_id' => $user_info['id']
				),
			'order' => array('amount' => 'desc')
			));
		$this->set('most_outflow', $most_outflow);

		$details_outflow = $this->Transaction->find('all', array(
				'fields' => array('SUM(amount) AS Total', 'Category.category_name', 'Wallet.currency'),
				'conditions' => array(
					'month(create_date)' => $month,
					'year(create_date)' => $year,
					'Category.category_type' => array('Chi Tiêu', 'Cho Vay'),
					'Transaction.user_id' => $user_info['id']
					),
				'group' => array('Category.category_name')
			));
		//pr($details_outflow); exit;
		$this->set('details_outflow', $details_outflow);
		//pr($details); exit;
		$details_inflow = $this->Transaction->find('all', array(
				'fields' => array('SUM(amount) AS Total', 'Category.category_name', 'Wallet.currency'),
				'conditions' => array(
					'month(create_date)' => $month,
					'year(create_date)' => $year,
					'Category.category_type' => array('Thu Nhập','Nợ'),
					'Transaction.user_id' => $user_info['id']
					),
				'group' => array('Category.category_name')
			));
		//pr($detail_inflow); exit;
		$this->set('details_inflow', $details_inflow);
		if(!empty($this->request->data)){
			//pr($this->request->data); exit;
			$this->redirect('/bao-cao-hang-thang/'.$this->request->data['Transaction']['date']['month'].'/'.$this->request->data['Transaction']['date']['year']);
		}
		$this->set('month', $month);
		//pr($year); exit;
		$this->set('year', $year);
	}




/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($slug = null) {
		$transactions = $this->Transaction->find('first', array('conditions' => array('Transaction.slug' => $slug)));
		if (!$transactions) {
			throw new NotFoundException(__(' Không tìm thấy trang bạn yêu cầu.'));
		} else{
			$this->set('transaction', $transactions);
		}
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {

			$this->Transaction->create();
			//pr($this->request->data); exit;
			if ($this->Transaction->save($this->request->data)) {
				$amount = $this->get_amount($this->request->data['Transaction']['category_id'], $this->request->data['Transaction']['amount']);
				$this->loadModel('Wallet');
				if($this->update_wallet($this->request->data['Transaction']['wallet_id'], $amount)) {
					$this->Session->setFlash('Lưu giao dịch thành công.', 'default', null, 'success');
					return $this->redirect(array('action' => 'index'));
				} else{
					$this->Session->setFlash('Cập nhật thông tin ví thất bại.', 'default', null, 'error');
				}

			} else {
				$this->Session->setFlash('Giao dịch chưa được lưu. Vui lòng thử lại.', 'default', null, 'error');
			}
		}
		$user_info = $this->get_user();
		$wallets = $this->Transaction->Wallet->find('list',array(
			'conditions' => array('user_id' => $user_info['id'])
			));
		$categories = $this->Transaction->Category->find('list',array(
			'conditions' => array(
				'category_type' => array('Nợ', 'Cho Vay', 'Chi Tiêu', 'Thu Nhập')
				)
			));
		$expences = $this->Transaction->Category->find('list',array(
			'conditions' => array(
				'category_type' => array('Chi Tiêu')
				)
			));

		$incomes = $this->Transaction->Category->find('list',array(
			'conditions' => array(
				'category_type' => array('Thu Nhập')
				)
			));

		$users = $this->Transaction->User->find('list',array(
			'conditions' => array('id' => $user_info['id'])));
		$this->set(compact('wallets','users', 'categories', 'expences', 'incomes'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($slug = null) {
		if (!$this->Transaction->find('first', array('conditions' => array('Transaction.slug' => $slug)))) {
			throw new NotFoundException(__('Không tìm thấy trang bạn yêu cầu'));
		} else{
			$old_data = $this->Transaction->find('first', array('conditions' => array('Transaction.slug' => $slug)));
		}
		if ($this->request->is(array('post', 'put'))) {
			//pr($this->request->data); exit;
			//pr($old_data); exit;

			if ($this->Transaction->save($this->request->data)) {
				$amount = $this->restore($old_data['Transaction']['category_id'], $old_data['Transaction']['amount']);
				if($this->update_wallet($old_data['Transaction']['wallet_id'], $amount)){
					$amount = $this->get_amount($this->request->data['Transaction']['category_id'], $this->request->data['Transaction']['amount']);
					if($this->update_wallet($this->request->data['Transaction']['wallet_id'], $amount)){
						$this->Session->setFlash('Lưu giao dịch thành công.', 'default', null, 'success');
						return $this->redirect(array('action' => 'index'));
					} else{
						$this->Session->setFlash('Lỗi khi cập nhập thông tin mới. Vui lòng thử lại.', 'default', null, 'error');
					}
				} else{
						$this->Session->setFlash('Lỗi khi khôi phục dữ liệu. Vui lòng thử lại.', 'default', null, 'error');
					}
			} else {
				$this->Session->setFlash('Giao dịch chưa được lưu. Vui lòng thử lại.', 'default', null, 'error');
			}
		} else {
			$this->request->data = $this->Transaction->find('first', array('conditions' => array('Transaction.slug' => $slug)));
		}

		$user_info = $this->get_user();
		$wallets = $this->Transaction->Wallet->find('list',array(
			'conditions' => array('user_id' => $user_info['id'])
			));
		$categories = $this->Transaction->Category->find('list');
		$this->set(compact('wallets', 'categories'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Transaction->id = $id;
		$data = $this->Transaction->findById($id);
		$amount = $this->restore($data['Transaction']['category_id'], $data['Transaction']['amount']);
		if (!$this->Transaction->exists()) {
			throw new NotFoundException(__('Giao dịch không hợp lệ'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Transaction->delete()) {
			if($this->update_wallet($data['Transaction']['wallet_id'], $amount)){
				$this->Session->setFlash('Giao dịch đã được xóa', 'default', null, 'success');
			}
		} else {
			$this->Session->setFlash('Giao dịch chưa được xóa. Vui lòng thử lại.', 'default', null, 'error');
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
* get_amount method
* @param string $id
* @return amount
*/
	public function get_amount($id, $amount){
		$this->loadModel('Category');
		$data = $this->Category->findById($id);
		if(empty($data)){
			throw new NotFoundException(__('Không tìm thấy'));
		} else{
			if($amount < 0){
				$amount = $amount*(-1);
			}
			if(strcmp($data['Category']['category_type'], 'Cho vay') == 0 || strcmp($data['Category']['category_type'], 'Chi Tiêu') == 0){
				$amount = $amount*(-1);
				return $amount;
			} else{
				return $amount;
			}
		}
	}

/*
*
*
*
*/
	public function restore($id, $amount){
		$this->loadModel('Category');
		$data = $this->Category->findById($id);
		if(empty($data)){
			throw new NotFoundException(__('Không tìm thấy'));
		} else{
			if($amount < 0){
				$amount = $amount*(-1);
			}
			if(strcmp($data['Category']['category_type'], 'Cho vay') == 0 || strcmp($data['Category']['category_type'], 'Chi Tiêu') == 0){
				return $amount;
			} else{
				$amount = $amount*(-1);
				return $amount;
			}
		}
	}

/*
* update_wallet method
*
*
*/
	public function update_wallet($id, $amount){
		$this->loadModel('Wallet');
		$wallets = $this->Wallet->findById($id);
		if(empty($wallets)){
			throw new NotFoundException(__('Không tìm thấy'));
			return false;
		} else{
			$new_banlances = $wallets['Wallet']['banlances'] + $amount;
			$this->Wallet->id = $id;
			$this->Wallet->saveField('banlances', $new_banlances);
			return true;
		}
	}
}
