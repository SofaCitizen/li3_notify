# Notification Message Plugin for Lithium

The Notification (`li3_notify`) plugin provides a simple interface for displaying feedback messages to a user.

It differs from li3_flash_message by having status types built-in and also by being designed for 1.1


## Goals

- Use existing session storage (by default)
- Simple typed-notification from within Controller


## Integration

```php
<?php

// config/bootstrap/libraries.php:

Libraries::add('li3_notify');

?>
``