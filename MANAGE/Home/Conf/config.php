<?php

include 'db.php';
$commonconfig = array(
        //'配置项'=>'配置值'
);

return array_merge($commonconfig, $db);
