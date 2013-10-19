<?php

echo $this->Html->script('jquery-1.10.2.min', array('inline' => false));
echo $this->Html->script('class', array('inline' => false));
echo $this->Html->script('http://theraccoonshare.snm.com/sirest/js/sirest.js', array('inline' => false));

echo $this->Html->script('sirest-test', array('inline' => false, 'id' => 'Sirest'));

?><div class="view">
<h2>Automated Testing</h2>


<?php

echo $this->Form->create('test');
echo $this->Form->end('Test Storage');

?>

<div id="output">
</div>
	<div id="output">

	</div>
</div>