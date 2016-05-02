<?php
/**
 * Li3_Notify : Notification Message Library 
 *
 * @copyright   Copyright 2016, Graeme Wheeler
 * @license     http://www.opensource.org/licenses/MIT The MIT License
 */

namespace li3_notify\storage;

class Notify extends \lithium\core\StaticObject {

	/**
	 * Default config for storage.
	 *
	 * @var array
	 */
	protected static $_config = array(
		'session' => 'lithium\storage\Session', // Valid Session model
		'name'    => 'default',                 // Session adapter config
		'prefix'  => 'Notify',           		// Prepended to all data keys
		'default' => 'message',					// Set the default class
		'output'  => array(
			'element' => 'notify/message',		// Set default element to use
		),
		'types'   => array(						// These don't need to be explicitly defined
			'message' => null,					//    However, we can use this to set additional
			'info'    => null,					//    options for rendering
			'success' => null,
			'warning' => null,
			'error'   => null,
		),
	);

	/**
	 * Used to get/set main configuration parameters.
	 *
	 * @param array $config array
	 * @return array Returns an associative array with the current configuration.
	 */
	public static function config(array $config = array()) {
		if ($config) {
			static::$_config = $config + static::$_config;
		}

		return static::$_config;
	}

	/**
	 * Get type config
	 *
	 * @param string $type the name of the type for which config is requested
	 * @return array The config for the specified type if configured
	 */
	public static function type($type = null) {
		$type = ($type)?:static::$_config['default'];
		if (array_key_exists($type, static::$_config['types'])) {
			return (array) static::$_config['types'][$type] + static::$_config['output'];
		}

		return array();
	}

	/**
	 * Writes a flash message
	 *
	 * @param mixed $message Message the message to be stored.
	 * @param mixed $options Optional attributes.
	 * @return boolean True on successful write, false otherwise.
	 */
	public static function write($message, $options = array()) {
		if (!is_array($options)) {
			$options = array('type' => $options);
		}

		$options += array('type' => static::$_config['default']);

		$session = static::$_config['session'];
		$key     = static::$_config['prefix'] . '.' . $options['type'];
		$name    = static::$_config['name'];

		return $session::write($key, compact('message', 'options'), compact('name'));
	}

	/**
	 * Reads a flash message.
	 *
	 * @param string [$key] Optional key.
	 * @return array The stored flash message.
	 */
	public static function read($type = null) {
		$type = ($type)?:static::$_config['default'];
		$session = static::$_config['session'];
		$key     = static::$_config['prefix'] . '.' . $type;
		$name    = static::$_config['name'];

		return $session::read($key, compact('name'));
	}

	/**
	 * Removes a flash message.
	 *
	 * @param string [$key] Optional key.
	 * @return boolean The value returned from session::delete()
	 */
	public static function delete($type = null) {
		$type = ($type)?:static::$_config['default'];
		$session = static::$_config['session'];
		$key     = static::$_config['prefix'] . '.' . $type;
		$name    = static::$_config['name'];

		return $session::delete($key, compact('name'));
	}

	/**
	 * Allow short-hand functionality to read/write a message
	 *
	 * @param string $method The name of the called method.
	 * @param array $arguments Any arguments passed to the method
	 * @return mixed the result of a called method or null.
	 */
	public static function __callStatic($method, $arguments = array()) {
		if (empty($arguments)) {
			// No arguments means a read
			$type = $method;
			return static::read($type);
		} else {
			$message = $arguments[0];
			$options = array('type' => $method);
			if (isset($arguments[1]) && is_array($arguments[1])) {
				$options = $arguments[1] + $options;
			}

			return static::write($message, $options);
		}
	}
}

?>