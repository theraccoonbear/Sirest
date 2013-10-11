<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		if ($editing) {
			echo $this->Form->input('id');
		}

		echo $this->Form->input('username');
		echo $this->Form->input('email');
		if ($adding) {
			echo $this->Form->input('password');
		}
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>