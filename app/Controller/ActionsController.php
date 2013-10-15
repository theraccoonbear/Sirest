<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
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
App::uses('AppController', 'Controller');
App::uses('UsersController', 'Controller');
App::uses('StoresController', 'Controller');
App::uses('User', 'Model');
App::uses('Store', 'Model');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class ActionsController extends AppController {
  
	public $respObj;
	public $payload;
	public $rendered = false;
  
	public function beforeFilter() {
		parent::beforeFilter();
		$this->effectiveClass = 'Store';
		$this->Store = new Store();
		$this->User = new User();
	    $this->Auth->allow('authenticate'); // Letting users register themselves
		$this->respObj = new stdClass();
		$this->respObj->success = true;
		$this->respObj->message = 'Success';
		$this->payload = new stdClass();
		$this->layout = 'ajax';
	}

	public function notLogged() {
		$this->err("You are not logged in");
	}

	public function err($message = 'There was an error processing the request') {
	  $this->respObj->success = false;
	  $this->respObj->message = $message;
	}
	
	



	public function authenticate() {
		$this->effectiveClass = 'User';
	  
		if (!$this->paramExists('username')) {
			$this->err('No username supplied');
		} else {
			if (!$this->paramExists('password')) {
				$this->err('No password supplied');
			} else {
				$this->request->data = array(
					'User' => array(
						'username' => $this->getParam('username'),
						'password' => $this->getParam('password')
					)
				);
				if (!$this->Auth->login()) {
				  $this->err("Invalid credentials");
				}
			}
		}
	}

	public function store() {
		if (!$this->logged_in) {
			$this->notLogged();
		} else {
			if (!$this->paramExists('key') || !$this->paramExists('data')) {
				$this->err("POST your key and data");
			} else {
				$dataChunk = $this->getParam('data');
				$dataStr = $dataChunk;

				$s = $this->Store->find('first', array('conditions' => array('Store.key' => $this->getParam('key'))));

				$store_id = false;
				if (!array_key_exists('Store', $s)) {
					$this->Store->create();
				} else {
					$store_id = $s['Store']['id'];
					$dataStr = $s['Store']['data'];
				}


				if ($this->paramExists('chunkOffset')) {
					$offset = $this->getParam('chunkOffset');
					$totalLen = $offset + strlen($dataChunk);
					$dataStr = substr_replace($dataStr, $dataChunk, $offset, strlen($dataChunk));
				} else {
					$dataStr = $dataChunk;
				}

				$store_data = array(
					'Store' => array(
						'key' => $this->getParam('key'),
						'data' => $dataStr,
					)
				);

				if ($store_id !== false) {
					$store_data['Store']['id'] = $store_id;
				}
				
				if (count($s) > 1 && $s['Store']['user_id'] != $this->Auth->user('id')) {
					$this->err('Unauthorized');
				} else {
					$store_data['Store']['user_id'] = $this->Auth->user('id');
					if (!$this->Store->save($store_data)) {
						$this->err("Couldn't store");
					}
				}
			}
		}
	}

	public function retrieve() {
		if (!$this->logged_in) {
			$this->notLogged();
		} else {
			if (!$this->paramExists('key')) { //!array_key_exists('key', $this->data['Store'])) {
				$this->err("POST your key");
			} else {
				$s = $this->Store->find('first', array('conditions' => array('Store.key' => $this->getParam('key'), 'Store.user_id' => $this->Auth->user('id'))));
				if (count($s) < 1) {
					$this->err('Not found');
				} else {
					$this->payload = $s['Store']['data'];
				}
			}
		}
	}
	
	public function beforeRender() {
	  if (!$this->rendered) {
		$this->rendered = true;
		$this->respObj->payload = $this->payload;
		// $this->respObj->params = $this->request->params;
		// $this->respObj->query = $this->request->query;
		//$this->respObj->validationError = $this->Store->validationErrors;
		$this->response->type('text/plain');
		
		//$this->respObj->stuff = print_r($this->request->query, true);
		$before_wrap = '';
		$after_wrap = '';

		if (isset($this->request->query['callback'])) {
			$before_wrap = $this->request->query['callback'] . '(';
			$after_wrap = ');';
		}

		print $before_wrap . json_encode($this->respObj) . $after_wrap;
		exit(0);
	  }
	}
}