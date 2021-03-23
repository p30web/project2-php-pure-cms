<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ticket;
if(isset($_POST['noteModuleInput_ipinNumber'])){
new \Joonika\Modules\Ipinbar\Ipinbar();
            \Joonika\Modules\Ipinbar\ticketInfoUserBoxSmall("username=".$_POST['noteModuleInput_ipinNumber']);
}