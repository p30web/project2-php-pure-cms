<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ticket;
global $origins;

new \Joonika\Modules\Ipinbar\Ipinbar();
if(sizeof($origins)>=1){
    foreach ($origins as $origin){
        if($origin['name']=='ContactCenter'){
            \Joonika\Modules\Ipinbar\ticketInfoUserBoxFull("username=".$origin['value']);
        }
    }
}