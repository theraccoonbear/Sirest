<?php

echo $this->Html->script('jquery-1.10.2.min', array('inline' => false));
echo $this->Html->script('class', array('inline' => false));
echo $this->Html->script('sirest', array('inline' => false));

?><div class="view">
<h2>Sandbox</h2>
<script>
  
</script>
<?php

echo $this->Form->create('auth');
echo $this->Form->input('username', array('id'=>'username'));
echo $this->Form->input('password', array('type'=>'password','id'=>'password'));
echo $this->Form->end('Authenticate');

echo $this->Form->create('store');
echo $this->Form->input('key', array('id'=>'storeKey'));
echo $this->Form->input('data', array('type'=>'textarea','id'=>'data'));
echo $this->Form->end('Store');

echo $this->Form->create('retrieve');
echo $this->Form->input('key', array('id'=>'retrieveKey'));
echo $this->Form->end('Rertrieve');

?>
	<div id="output">

	</div>
</div>