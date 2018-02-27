<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class CategoriesController extends AppController {

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
		$this->Category->recursive = 0;
		$this->paginate = array(
						'order' => array('Category.id' => 'asc'),
						'limit' => 10,
						'paramType' => 'querystring'
						);
		$this->Paginator->settings = $this->paginate;
		$this->set('categories', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}
		$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
		$this->set('category', $this->Category->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Category->create();
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash('Danh mục đã được lưu.', 'default', null, 'success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Danh mục chưa được lưu. Vui lòng thử lại.', 'default', null, 'error');
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash('Đã lưu thay đổi.', 'default', null, 'success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->error('Thay đổi chưa được lưu. Vui lòng thử lại', 'default', null, 'error');
			}
		} else {
			$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
			$this->request->data = $this->Category->find('first', $options);
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
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Không tìm thấy trang bạn yêu cầu'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Category->delete()) {
			$this->Session->setFlash('Đã xóa danh mục.', 'default', null, 'success');
		} else {
			$this->Session->setFlash('Danh mục chưa được xóa. Vui lòng thử lại', 'default', null, 'error');
		}
		return $this->redirect(array('action' => 'index'));
	}
}
