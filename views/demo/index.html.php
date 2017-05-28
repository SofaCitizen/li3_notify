<h1>Test notification message types</h1>
<p>Click the links below to generate a notification.</p>
<ul>
	<li><?=$this->html->link('Message', ['controller' => 'li3_notify.demo', 'action' => 'message']);?></li>
	<li><?=$this->html->link('Info', 	['controller' => 'li3_notify.demo', 'action' => 'info']);?></li>
	<li><?=$this->html->link('Success', ['controller' => 'li3_notify.demo', 'action' => 'success']);?></li>
	<li><?=$this->html->link('Warning', ['controller' => 'li3_notify.demo', 'action' => 'warning']);?></li>
	<li><?=$this->html->link('Error', 	['controller' => 'li3_notify.demo', 'action' => 'error']);?></li>
	<li><?=$this->html->link('Danger', 	['controller' => 'li3_notify.demo', 'action' => 'danger']);?></li>
</ul>

<p><?=$this->html->link('Multiple messages', ['controller' => 'li3_notify.demo', 'action' => 'multiple']);?> are also supported.</p>
