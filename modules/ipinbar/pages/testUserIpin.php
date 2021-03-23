<?php
global $database;
new \Joonika\Modules\Ipinbar\Ipinbar();
$user=\Joonika\Modules\Ipinbar\getUserInfoByNumberViewWS("09124771140");
echo json_encode($user,JSON_UNESCAPED_UNICODE);