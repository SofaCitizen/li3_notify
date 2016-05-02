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
		Notify::reset();
	}

	/*
	 *	Test the config setting
	 */

	public function testConfig() {
		$defaults = Notify::config();

		$result = Notify::config(array(
			'default' => 'message',
			'session' => 'app\storage\Session',
		));
		$this->assertNotEqual($defaults, Notify::config());
		$this->assertEqual('app\storage\Session', $result['session']);
		$this->assertEqual('message', $result['default']);

		// Reset config
		$this->assertEqual($defaults, Notify::config($defaults));
	}

	public function testConfigTypes() {
		$defaults = Notify::config();
		$result = Notify::types();
		$this->assertEqual(array_keys($defaults['types']), $result);

		$result = Notify::type('error');
		$this->assertEqual($defaults['output'], $result);

		Notify::types(array('error' => array('element' => 'notify/error')));
		$result = Notify::type('error');
		$this->assertEqual(array('element' => 'notify/error'), $result);
	}

	public function testAddType() {
		$defaults = Notify::config();
		$types  = Notify::types();

		$result = Notify::types(array('site'));
		$this->assertEqual(count($types) + 1, count($result));
		$this->assertTrue(in_array('site', $result));

		$result = Notify::type('site');
		$this->assertEqual($defaults['output'], $result);

		$result = Notify::types(array('site' => ['element' => 'notify/site']));
		$this->assertNotEqual($defaults['output'], $result);
	}

	public function testConfigOrder() {
		$defaults = Notify::config();
		$types = array_keys($defaults['types']);

		$result = Notify::types();
		$this->assertEqual($types, $result);
		$this->assertNotEqual('error', $result[0]);

		Notify::config(['order' => ['error']]);
		$result = Notify::types();
		$this->assertEqual(count($types), count($result));
		$this->assertEqual('error', $result[0]);
	}

	public function testConfigInvalidOrder() {
		$defaults = Notify::config();
		$types = array_keys($defaults['types']);

		Notify::config(['order' => 'not_an_array']);
		$result = Notify::types();
		$this->assertEqual((count($types)+1), count($result));
	}

	public function testConfigInvalidTypes() {
		$defaults = Notify::config();
		$types = array_keys($defaults['types']);

		Notify::config(['types' => 'not_an_array']);
		$result = Notify::types();
		$this->assertEqual(count($types)+1, count($result));
		Notify::reset();

		Notify::config(['types' => []]);
		$result = Notify::types();
		$this->assertEqual(count($types), count($result), print_r($result, true));
		Notify::reset();

		Notify::config(['types' => ['potato','apple']]);
		$result = Notify::types();
		$this->assertEqual(count($types)+2, count($result), print_r($result, true));
		Notify::reset();
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