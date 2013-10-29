<?php

//echo $this->Html->script('jquery-1.10.2.min', array('inline' => false));
//echo $this->Html->script('class', array('inline' => false));
////echo $this->Html->script('http://sire.st/js/sirest.js', array('inline' => false, 'id' => 'Sirest'));
//echo $this->Html->script('/sirest.js', array('inline' => false, 'id' => 'Sirest'));

echo $this->Html->script('sirest-test', array('inline' => false));

?><div class="view">
<h2>Automated Testing</h2>


<?php

echo $this->Form->create('test');
echo $this->Form->input('username');
echo $this->Form->input('password', array('type' => 'password'));
echo $this->Form->end('Test Storage');

?>

<div id="output">
</div>
	<div id="output">

	</div>
</div>