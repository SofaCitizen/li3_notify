<?php
/**
 * Li3_Notify : Notification Message Library
 *
 * @copyright   Copyright 2016, Graeme Wheeler
 * @license     http://www.opensource.org/licenses/MIT The MIT License
 */

use lithium\aop\Filters;
use li3_notify\storage\Notify;

Filters::apply('lithium\action\Dispatcher', '_callable', function($params, $next) {
	return Notify::bindTo($next($params), ['random' => 'potato']);
});

?>