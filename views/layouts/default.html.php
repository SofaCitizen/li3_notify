<?php
/**
 * Li3_Notify : Notification Message Library
 *
 * This layout demonstrates how this plugin can be called within view files
 */
?>
<!doctype html>
<html>
<head>
	<?php echo $this->html->charset();?>
	<title>Application &gt; <?php echo $this->title(); ?></title>
	<?php echo $this->html->style(['bootstrap.min', 'lithified']); ?>
	<?php echo $this->scripts(); ?>
	<?php echo $this->styles(); ?>
	<?php echo $this->html->link('Icon', null, ['type' => 'icon']); ?>
</head>
<body class="lithified">
	<div class="container-narrow">

		<div class="masthead">
			<ul class="nav nav-pills pull-right">
				<li>
					<a href="/">Home</a>
				</li>
			</ul>
			<a href="http://li3.me/"><h3>&#10177;</h3></a>
		</div>

		<hr>

		<div class="content">
			<?= $this->notification->all() ?>
			<?php echo $this->content(); ?>
		</div>

		<hr>

		<div class="footer">
			<p>&copy; Union Of RAD <?php echo date('Y') ?></p>
		</div>

	</div>
</body>
</html>