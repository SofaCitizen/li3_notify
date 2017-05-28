<?php
/**
 * Li3_Notify : Notification Message Library
 *
 * @copyright   Copyright 2017, Graeme Wheeler
 * @license     http://www.opensource.org/licenses/MIT The MIT License
 */

namespace li3_notify\controllers;

use li3_notify\storage\Notify;

/**
 * This controller is used for demonstrating the default Notification Messages.
 */
class DemoController extends \lithium\action\Controller {

	public function index() {}

	public function message() {
		Notify::message('This is a standard message');
		return $this->redirect(array('action' => 'index'));
	}

	public function success() {
		Notify::success('This is a success message');
		return $this->redirect(array('action' => 'index'));
	}

	public function error() {
		Notify::error('This is an error message');
		return $this->redirect(array('action' => 'index'));
	}

	public function danger() {
		Notify::danger('This is a danger message');
		return $this->redirect(array('action' => 'index'));
	}

	public function info() {
		Notify::info('This is an info message');
		return $this->redirect(array('action' => 'index'));
	}

	public function warning() {
		Notify::warning('This is a warning message');
		return $this->redirect(array('action' => 'index'));
	}

	public function multiple() {
		Notify::info('Some information ....');
		Notify::warning('... followed by a warning .....');
		Notify::error('... and then a failure.');
		return $this->redirect(array('action' => 'index'));
	}
}

?>