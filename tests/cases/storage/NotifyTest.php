<?php
/**
 * Li3_Notify : Notification Message Library 
 *
 * @copyright   Copyright 2016, Graeme Wheeler
 * @license     http://www.opensource.org/licenses/MIT The MIT License
 */

namespace li3_notify\tests\cases\storage;

use lithium\storage\Session;
use li3_notify\storage\Notify;

class NotifyTest extends \lithium\test\Unit {

	public function setUp() {
		// Set default session to use memory adapter for testing
		Session::config(array(
			'default' => array('adapter' => 'Memory')
		));
	}

	public function tearDown() {
		Session::delete('default');
	}

	/*
	 *	Test the config setting
	 */

	public function testConfig() {
		$defaults = Notify::config();

		$result = Notify::config(array(
			'session' => 'app\storage\Session',
		));
		$this->assertNotEqual($defaults, Notify::config());
		$this->assertEqual('app\storage\Session', $result['session']);

		// Reset config
		$this->assertEqual($defaults, Notify::config($defaults));
	}

	/*
	 *	Simple tests for simple functionality
	 */

	public function testWrite() {
		$message = 'Foo';
		Notify::write($message);
		$result = Session::read('Notify.message');
		$this->assertEqual($message, $result['message']);

		$message = 'Oof!';
		Notify::write($message, 'error');
		$result = Session::read('Notify.error');
		$this->assertEqual($message, $result['message']);
	}

	public function testRead() {
		$message = 'Foo';
		Notify::write($message);
		$result = Notify::read();
		$this->assertEqual($message, $result['message']);

		$message = 'Oof!';
		Notify::write($message, 'error');
		$result = Notify::read('error');
		$this->assertEqual($message, $result['message']);
	}

	public function testDelete() {
		$message = 'Foo';
		Notify::write($message);
		Notify::write($message, 'info');
		$this->assertTrue(Notify::delete());
		$this->assertEqual(null, Notify::read());

		// Test no-clobber
		$result = Notify::read('info');
		$this->assertEqual($message, $result['message']);
	}

	/*
	 *	Test Short-hand functionality
	 */

	public function testShorthand() {
		$message = 'Foo';
		Notify::info($message);
		$result = Notify::info();
		$this->assertEqual($message, $result['message']);

		$message = 'Standard in, Shortcut out';
		Notify::write($message, 'warning');
		$result = Notify::warning();
		$this->assertEqual($message, $result['message']);

		$message = 'Shortcut in, Standard out';
		Notify::success($message);
		$result = Notify::read('success');
		$this->assertEqual($message, $result['message']);
	}

}

?>