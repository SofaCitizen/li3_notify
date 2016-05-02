<?php
/**
 * Li3_Notify : Notification Message Library 
 *
 * @copyright   Copyright 2016, Graeme Wheeler
 * @license     http://www.opensource.org/licenses/MIT The MIT License
 */

namespace li3_notify\template\helper;

/**
 * A class for outputting notification messages
 */
class Notification extends \lithium\template\Helper {

	/**
	 * Class dependencies.
	 *
	 * @var array
	 */
	protected $_classes = array(
		'storage' => 'li3_notify\storage\Notify'
	);

	/*
	 * Outputs a message to the user.
	 *
	 * @param string [$key] Optional message key.
	 * @return string Returns the rendered template.
	 */
	public function show($key = 'message') {
		$storage = $this->_classes['storage'];

		// Continue if we have a message
		if ($data = $storage::read($key)) {
			// Grabbed message so delete it
			$storage::delete($key);

			$view = $this->_context->view();
			$options = $storage::type($key);
			$element = $options['element'];

			// Render content if we have a matching string
			return $view->render(array('element' => $element), $data, $options);
		}
	}

	/**
	 * Allow short-hand functionality to read a message
	 *
	 * @param string $method The name of the called method.
	 * @param array $arguments Any arguments passed to the method
	 * @return mixed the result of a called method or null.
	 */
	public function __call($method, $arguments = array()) {
		// No arguments means a read
		$type = $method;
		return static::show($type);
	}
}

?>