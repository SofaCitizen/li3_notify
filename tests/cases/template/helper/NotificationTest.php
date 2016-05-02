<?php
/**
 * Li3_Notify : Notification Message Library 
 *
 * @copyright   Copyright 2016, Graeme Wheeler
 * @license     http://www.opensource.org/licenses/MIT The MIT License
 */

namespace li3_notify\tests\cases\template\helper;

use lithium\core\Libraries;
use lithium\storage\Session;
use lithium\tests\mocks\template\MockRenderer;
use lithium\template\View;
use li3_notify\storage\Notify;
use li3_notify\template\helper\Notification;

class NotificationTest extends \lithium\test\Unit {

	public function setUp() {
		$library = Libraries::get('li3_notify');

		// Pass the context to the helper else options won't get handled.
		// Include the view so that the render command will work
		$this->context = new MockRenderer(array(
			'view' => new View(array(
				'loader' => 'File', 'renderer' => 'File',
				'paths' => array(
					'element' => $library['path'].'/views/elements/{:template}.{:type}.php'
				)
			))
		));
		$this->notification = new Notification(array('context' => &$this->context));
	}

	public function tearDown() {
		unset($this->notification);
	}

	public function testRead() {
		Notify::write('Test');
		$expected = '<div class="alert alert-message" role="alert">Test</div>';
		$result = trim($this->notification->show());
		$this->assertEqual($expected, $result);

		Notify::success('Test Two');
		$expected = '<div class="alert alert-success" role="alert">Test Two</div>';
		$result = trim($this->notification->show('success'));
		$this->assertEqual($expected, $result);
	}

	public function testReadShorthand() {
		Notify::info('Test');
		$expected = '<div class="alert alert-info" role="alert">Test</div>';
		$result = trim($this->notification->info());
		$this->assertEqual($expected, $result);

		Notify::error('Test Two');
		$expected = '<div class="alert alert-error" role="alert">Test Two</div>';
		$result = trim($this->notification->error());
		$this->assertEqual($expected, $result);
	}

	public function testClear() {
		Notify::write('Test 1');
		Notify::info('Test 2');
		Notify::error('Test 3');

		$this->notification->message('message');
		$this->assertEmpty($this->notification->message('message'));

		$this->notification->message('info');
		$this->assertEmpty($this->notification->message('info'));

		$this->notification->message('error');
		$this->assertEmpty($this->notification->message('error'));
	}

	public function testReadMultiple() {
		Notify::info('Test Info');
		Notify::success('Test Success');

		$result = $this->notification->show(['info', 'success']);

		$this->assertTags($result, array(
			array(
				'div' => array(
					'class' => 'alert alert-info',
					'role'  => 'alert'
				)
			),
			'Test Info',
			'/div',
			array(
				'div' => array(
					'class' => 'alert alert-success',
					'role'  => 'alert'
				)
			),
			'Test Success',
			'/div',
		));
	}

	public function testReadAll() {
		Notify::info('Test Info');
		Notify::success('Test Success');

		$result = $this->notification->all();

		$this->assertTags($result, array(
			array(
				'div' => array(
					'class' => 'alert alert-info',
					'role'  => 'alert'
				)
			),
			'Test Info',
			'/div',
			array(
				'div' => array(
					'class' => 'alert alert-success',
					'role'  => 'alert'
				)
			),
			'Test Success',
			'/div',
		));
	}
}

?>