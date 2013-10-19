<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
	public $components = array(
		//'DebugKit.Toolbar',
		'Auth' => array(
            'loginRedirect' => array('controller' => 'stores', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'login')
        ),
		'Session',
		'RequestHandler'
	);

	public $effectiveClass = 'Action';
	
	public $logged_in = false;

	public function setViewVars() {
		$this->logged_in = is_array($this->Auth->user());

		$this->set('action', $this->request->action);
		$this->set('editing', $this->request->action === 'edit');
		$this->set('adding', $this->request->action === 'add');
		$this->set('auth', $this->Auth->user());
		$this->set('logged_in', $this->logged_in);
	}

	public function beforeFilter() {
		$this->setViewVars();
	}

	public function getParamExists($name) {
		return array_key_exists($this->effectiveClass, $this->request->query) && array_key_exists($name, $this->request->query[$this->effectiveClass]);
	}

	public function postParamExists($name) {
		return array_key_exists($this->effectiveClass, $this->data) && array_key_exists($name, $this->data[$this->effectiveClass]);
	}

	public function paramExists($name) {
		return $this->postParamExists($name) || $this->getParamExists($name);
	}

	public function getPostParam($name) {
		return $this->postParamExists($name) ? $this->data[$this->effectiveClass][$name] : false;
	}

	public function getGetParam($name) {
		return $this->getParamExists($name) ? $this->request->query[$this->effectiveClass][$name] : false;
	}

	public function getParam($name, $type = 'either') {
		if (strtolower($type) == 'post') {
			return $this->getPostParam($name);
		} elseif (strtolower($type) == 'get') {
			return $this->getGetParam($name);
		} else {
			if ($this->postParamExists($name)) {
				return $this->getPostParam($name);
			} else {
				return $this->getGetParam($name);
			}
		}
	}

}
