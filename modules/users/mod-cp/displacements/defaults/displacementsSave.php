<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_displacements')) {
    error403();
    die;
}
if(isset($_POST['default_group'])){
    jk_options_set('displacement_default_group',$_POST['default_group']);
    jk_options_set('displacement_default_role',$_POST['default_role']);
    jk_options_set('displacement_default_displacementType',$_POST['default_displacementType']);
echo alert([
    "text"=>__("successfully done"),
    "type"=>"success",
]);
}
