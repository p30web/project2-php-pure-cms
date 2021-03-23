<?php

if (!defined('jk')) die('Access Not Allowed !');

global $ACL;

if (!$ACL->hasPermission('crm_contactCenter')) {
    error403();
    die;
}

