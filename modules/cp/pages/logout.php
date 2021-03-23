<?php
if (!defined('jk')) die('Access Not Allowed !');
global $Users;
$Users->logOutUser();
redirect_to(JK_DOMAIN_LANG);