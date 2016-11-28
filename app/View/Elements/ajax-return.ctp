<?php

$respObj->validationErrors = $this->validationErrors;

print $beforeWrap;
print json_encode($respObj);
print $afterWrap;
exit(0);