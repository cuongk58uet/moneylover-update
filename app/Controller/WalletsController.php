
<?php
App::uses('AppController', 'Controller');
/**
 * Wallets Controller
 *
 * @property Wallet $Wallet
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SecurityComponent $Security
 * @property SessionComponent $Session
 */
class WalletsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'Security', 'Session','Tool');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$user_info = $this->get_user();
		$this->Wallet->recursive = 0;
		$this->Paginator->settings = $this->paginate;
		$this->paginate = array(
			'order' => array('wallet_name' => 'asc'),
			'limit' => 10,
			'conditions' => array('user_id' => $user_info['id'] ),
			'paramType' => 'querystring'
			);
		
		$this->set('wallets', $this->paginate());
		
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($slug = null) {
		$wallets = $this->Wallet->find('first', array(
			'conditions' => array('Wallet.slug' => $slug),
			));
		//pr($wallets); exit;
		$user_info = $this->get_user();
		if (!$wallets) {
			throw new NotFoundException(__('Không tìm thấy trang bạn yêu cầu'));
		} else{
			$this->set('wallet', $wallets);
		}
		$this->loadModel('Transaction');
		$this->Transaction->recursive = 0;
		$this->Paginator->settings = array(
			'Transaction' => array(
				'order' => array('Transaction.create_date' => 'desc' ,'Transaction.id' => 'desc'),
				'limit' => 10,
				'conditions' => array(
					'Transaction.user_id' => $user_info['id'],
					'wallet_id' => $wallets['Wallet']['id']
					),
				'paramType' => 'querystring',
				'contain' => 'Category'
				),

			);
		$this->set('transactions', $this->paginate('Transaction'));
		//pr($this->paginate('Transaction')); exit;
		
		$currentMonth = date('m');
		$currentYear = date('Y');
		$this->set(compact('currentMonth', 'currentYear'));
		$inflow = $this->Transaction->find('all', array(
				'fields' => array('SUM(amount) AS Total'),
				'conditions' => array(
					'month(create_date)' => $currentMonth,
					'year(create_date)'=> $currentYear,
					'Category.category_type' => array('Thu Nhập','Nợ'),
					'Transaction.user_id' => $user_info['id'],
					'wallet_id' => $wallets['Wallet']['id']
					),
			));
		if(empty($inflow)){
			$inflow = 0;
		}
		$this->set('inflow', $inflow);
		$outflow = $this->Transaction->find('all', array(
				'fields' => array('SUM(amount) AS Total'),
				'conditions' => array(
					'month(create_date)' => $currentMonth,
					'year(create_date)'=> $currentYear,
					'Category.category_type' => array('Chi Tiêu', 'Cho Vay'),
					'Transaction.user_id' => $user_info['id'],
					'wallet_id' => $wallets['Wallet']['id']
					)
			));
		if(empty($outflow)){
			$outflow = 0;
		}
		$this->set('outflow', $outflow);
		$netIncome = $inflow['0']['0']['Total'] - $outflow['0']['0']['Total']; //Thu nhập ròng
		$this->set('netIncome', $netIncome);
	}

/**
*
*
*/
	public function report( $slug, $month, $year){
		$user_info = $this->get_user();
		$wallet = $this->Wallet->findBySlug($slug);
		$this->set('wallet', $wallet);

		$this->loadModel('Transaction');
		$inflow = $this->Transaction->find('all', array(
				'fields' => array('SUM(amount) AS Total'),
				'conditions' => array(
					'month(create_date)' => $month,
					'year(create_date)' => $year,
					'Category.category_type' => array('Thu Nhập','Nợ'),
					'Transaction.user_id' => $user_info['id'],
					'wallet_id' => $wallet['Wallet']['id']
					)
			));
		if(empty($inflow)){
			$inflow = 0;
		}
		$this->set('inflow', $inflow);

		$outflow = $this->Transaction->find('all', array(
				'fields' => array('SUM(amount) AS Total'),
				'conditions' => array(
					'month(create_date)' => $month,
					'year(create_date)' => $year,
					'Category.category_type' => array('Chi Tiêu', 'Cho Vay'),
					'Transaction.user_id' => $user_info['id'],
					'wallet_id' => $wallet['Wallet']['id']
					)
			));
		if(empty($outflow)){
			$outflow = 0;
		}
		$this->set('outflow', $outflow);
		
		$netIncome = $inflow['0']['0']['Total'] - $outflow['0']['0']['Total']; //Thu nhập ròng
		$this->set('netIncome', $netIncome);

		$most_outflow = $this->Transaction->find('first', array(
			'conditions' => array(
				'month(create_date)' => $month,
				'year(create_date)' => $year,
				'Category.category_type' => array('Chi Tiêu', 'Cho Vay'),
				'Transaction.user_id' => $user_info['id'],
				'wallet_id' => $wallet['Wallet']['id']
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
					'Transaction.user_id' => $user_info['id'],
					'wallet_id' => $wallet['Wallet']['id']
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
					'Transaction.user_id' => $user_info['id'],
					'wallet_id' => $wallet['Wallet']['id']
					),
				'group' => array('Category.category_name')
			));
		//pr($detail_inflow); exit;
		$this->set('details_inflow', $details_inflow);
		if(!empty($this->request->data)){
			//pr($this->request->data); exit;
			$this->redirect('/bao-cao-hang-thang/'.$wallet['Wallet']['slug'].'/'.$this->request->data['Wallet']['date']['month'].'/'.$this->request->data['Wallet']['date']['year']);
		}
		$this->set('month', $month);
		//pr($year); exit;
		$this->set('year', $year);
	}


/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Wallet->create();
			if ($this->Wallet->save($this->request->data)) {
				$this->Session->setFlash('Lưu thành công.', 'default', null,'success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(' Ví chưa được lưu. Vui lòng thử lại.', 'default', null,'error');
			}
		}
		$user_info = $this->get_user();
		$users = $this->Wallet->User->find('list',array(
			'conditions' => array('id' => $user_info['id'])
			));
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($slug = null) {
		if (!$this->Wallet->find('first', array('conditions' => array('Wallet.slug' => $slug)))) {
			throw new NotFoundException(__(' Không tìm thấy trang bạn yêu cầu'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Wallet->save($this->request->data)) {
				$this->Session->setFlash(' Lưu thành công.', 'default', null,'success');
				//debug($this->Session->flash('success')); exit;
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ví chưa được lưu. Vui lòng thử lại.', 'default', null, 'error');
			}
		} else {
			$this->request->data = $this->Wallet->find('first', array('conditions' => array('Wallet.slug' => $slug)));
		}
		$users = $this->Wallet->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Wallet->id = $id;
		if (!$this->Wallet->exists()) {
			throw new NotFoundException(__('Không tìm thấy trang bạn yêu cầu'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Wallet->delete()) {
			$this->Session->setFlash('Xóa thành công.', 'default', null,'success');
		} else {
			$this->Session->setFlash(' Ví chưa được Xóa. Vui lòng thử lại.', 'default', null,'error');
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
* update_banlances method
*
*/
	public function update_banlances($id1, $id2, $amount){
		if($id1 != $id2){
			$wallet1 = $this->Wallet->findById($id1);
			$wallet2 = $this->Wallet->findById($id2);
			if(empty($wallet1) && empty($wallet2)){
				throw new NotFoundException(__('Không tìm thấy'));
			} else{
				$new_banlances1 = $wallet1['Wallet']['banlances'] - $amount;
				$this->Wallet->id = $id1;
				$this->Wallet->saveField('banlances', $new_banlances1);

				$new_banlances2 = $wallet2['Wallet']['banlances'] + $amount;
				$this->Wallet->id = $id2;
				$this->Wallet->saveField('banlances', $new_banlances2);
				return true;
			}
		} else{
			
			return true;
		}
		
	}

/**
* transfer_money method
*
*/
	public function transfer_money(){
		$user_info = $this->get_user();
		$sources = $this->Wallet->find('list', array(
			'conditions' => array('Wallet.user_id' => $user_info['id'])
			));
		
		$destinations = $this->Wallet->find('list', array(
			'conditions' => array('Wallet.user_id' => $user_info['id'])
			));
		if(!empty($this->request->data)){
			if($this->request->data['Wallet']['amount'] > 0){
				if($this->update_banlances($this->request->data['Wallet']['source_id'], $this->request->data['Wallet']['destination_id'], $this->request->data['Wallet']['amount'])){
					$this->Session->setFlash('Chuyển tiền thành công.', 'default', null,'success');
					return $this->redirect(array('action' => 'index'));
				} else{
					$this->Session->setFlash('Có lỗi xảy ra. Vui lòng thử lại', 'default', null,'error');
				}
			} else{
				$this->Session->setFlash('Số tiền phải là số tự nhiên lớn hơn 0', 'default', null,'error');
				unset($this->request->data['Wallet']['amount']);
			}
			
		}
		$this->set(compact('sources', 'destinations'));
	}
}
