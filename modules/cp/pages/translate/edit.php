<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('cp_translate')) {
    error403();
    die;
}
global $database;

    if (isset($_POST['getID']) && isset($_POST['getval'])) {
        $database->update('jk_translate', [
            "text" => $_POST['getval']
        ], [
            "id" => $_POST['getID']
        ]);
        ?><span class="text-success fa fa-check"></span><?php
    }
