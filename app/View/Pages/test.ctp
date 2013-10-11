<div class="view">
<h2>Test Bed</h2>
<script>
  $(function() {
	var sirest = new Sirest();
	
	$('#authDisplayForm').submit(function(e) {
	  sirest.authenticate($('#username').val(), $('#password').val());
	  e.preventDefault();
	  return false;
	});
  });
</script>
<?php

echo $this->Form->create('auth');

echo $this->Html->script('jquery-1.10.2.min', array('inline' => false));
echo $this->Html->script('class', array('inline' => false));
echo $this->Html->script('sirest', array('inline' => false));

echo $this->Form->input('username', array('id'=>'username'));
echo $this->Form->input('password', array('type'=>'password','id'=>'password'));
echo $this->Form->submit('Authenticate');

?>
</div>