<?php

echo $this->Html->script('jquery-1.10.2.min', array('inline' => false));
echo $this->Html->script('class', array('inline' => false));
echo $this->Html->script('sirest', array('inline' => false));

?><div class="view">
<h2>Test Bed</h2>
<script>
  $(function() {
	var sirest = new Sirest({jsonp: true});
	
	$('#authDisplayForm').submit(function(e) {
		sirest.authenticate($('#username').val(), $('#password').val(), {
		  	callback: function(d) {
			  	$('#output').html('<pre>' + JSON.stringify(d) + '</pre>');
			}
		});
		e.preventDefault();
		return false;
	});

	$('#storeDisplayForm').submit(function(e) {
		sirest.store($('#storeKey').val(), $('#data').val(), {
		  	callback: function(d) {
			  	$('#output').html('<pre>' + JSON.stringify(d) + '</pre>');
			}
		});
		e.preventDefault();
		return false;
	});

	$('#retrieveDisplayForm').submit(function(e) {
		sirest.retrieve($('#retrieveKey').val(), {
		  	callback: function(d) {
			  	$('#output').html('<pre>' + JSON.stringify(d) + '</pre>');
			}
		});
		e.preventDefault();
		return false;
	});
  });
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