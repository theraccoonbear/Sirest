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
	    $this->Auth->allow('authenticate'); // Letting users register themselves
		$this->respObj = new stdClass();
		$this->respObj->success = true;
		$this->respObj->message = 'Success';
		$this->payload = new stdClass();
		$this->layout = 'ajax';
	}

	public function err($message = 'There was an error processing the request') {
	  $this->respObj->success = false;
	  $this->respObj->message = $message;
	}
	
	public function authenticate() {
	  if (!$this->request->is('post')) {
		$this->err('Post your auth credentials');
	  } else {
		if (!$this->request['username']) {
		  $this->err('No username supplied');
		} else {
		  
		}
	  }
	}
	
	public function beforeRender() {
	  if (!$this->rendered) {
		$this->rendered = true;
		$this->respObj->payload = $this->payload;
		//$this->header('Content-Type: text/plain');
		$this->response->type('text/plain');
		//print "Content-Type: text/plain\n\n";
		print json_encode($this->respObj);
		//$this->set('response', $this->respObj);
		//$this->render('/Layouts/ajax');
		exit(0);
	  }
	}
}