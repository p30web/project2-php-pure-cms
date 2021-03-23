<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('blog_categories')) {
    error403();
    die;
}
NestableTableJS("jk_data",JK_DOMAIN_LANG . 'cp/blog/categories/list_sort');
NestableTableGetData('jk_data','jk_data', "",0,"","blog_category");
global $View;
echo $View->footer_js;