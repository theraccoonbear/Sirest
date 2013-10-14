<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<?php

		if ($logged_in) {
			?>
			<li><?php echo $this->Html->link(__('Manage Storage'), array('controller' => 'stores', 'action' => 'index')); ?></li>
			<li><?php echo $this->Html->link(__('Logout'), array('controller' => 'users', 'action' => 'logout')); ?> </li>
			<?php
		} else {
			?>
			<li><?php echo $this->Html->link(__('Sign Up'), array('controller' => 'users', 'action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('Login'), array('controller' => 'users', 'action' => 'login')); ?> </li>
			<?php
		}


		?><li><?php echo $this->Html->link(__('Test Bed'), array('controller' => 'pages', 'action' => 'test')); ?></li>
		<li><?php echo $this->Html->link(__('Sandbox'), array('controller' => 'pages', 'action' => 'sandbox')); ?></li>
	</ul>
</div>
