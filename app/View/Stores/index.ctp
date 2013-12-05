<div class="stores index">
	<h2><?php echo __('Stores'); ?></h2>
	<div class="actions">
		<?php echo $this->Html->link(__('Add Storage'), array('controller'=>'stores','action'=>'add')); ?>
	</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('key'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($stores as $store): ?>
	<tr>
		<td><?php echo $this->Html->link(__($store['Store']['id']), array('action' => 'view', $store['Store']['id'])); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($store['User']['username'], array('controller' => 'users', 'action' => 'view', $store['User']['id'])); ?>
		</td>
		<td><code><?php echo $this->Html->link(__($store['Store']['app'] . '::' . $store['Store']['key']), array('action' => 'view', $store['Store']['id'])); ?></code>&nbsp;</td>
		<td><?php echo h($store['Store']['created']); ?>&nbsp;</td>
		<td><?php echo h($store['Store']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $store['Store']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $store['Store']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $store['Store']['id']), null, __('Are you sure you want to delete # %s?', $store['Store']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
