<?php
/**
 * Li3_Notify : Notification Message Library
 *
 * @copyright   Copyright 2017, Graeme Wheeler
 * @license     http://www.opensource.org/licenses/MIT The MIT License
 */

namespace li3_notify\config;

use lithium\net\http\Router;
use lithium\core\Environment;

if (!Environment::is('production')) {
    Router::connect('/li3_notify/demo/{:action}', ['controller' => 'li3_notify.demo']);
}


?>