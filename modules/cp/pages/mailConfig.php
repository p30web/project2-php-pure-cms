<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
$Users->loggedCheck();
if (!$ACL->hasPermission('cp_mailConfig')) {
    error403();
    die;
}
global $View;
global $Cp;
$Cp->setSidebarActive('main/mailConfig');

$View->footer_js( '
<script>
$(document).ready(function() {
    ' . datatable_structure([
        "id" => "datatable_list",
        "type" => "ajax",
        "tabIndex"=> 1,
        "ajax_url" => JK_DOMAIN_LANG . "cp/main/mailConfig/list",
        "columns" => [
            "id",
            "name",
            "lang",
            "op",
        ],
    ]) . '    
    ' . datatable_structure([
        "id" => "mail_list",
        "type" => "ajax",
        "tabIndex"=> 1,
        "ajax_url" => JK_DOMAIN_LANG . "cp/main/mailConfig/mailList",
        "columns" => [
            "id",
            "email",
            "username",
            "server",
            "port",
            "secureType",
            "fromName",
            "debug",
            "op",
        ],
    ]) . '
} );
function editText(id=""){
      $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/main/mailConfig/edit',
        "success_response" => "#modal_global_body",
        "data" => "{id:id}",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '    
}
function editMail(id=""){
      $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/main/mailConfig/editMail',
        "success_response" => "#modal_global_body",
        "data" => "{id:id}",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '    
}

</script>
');
$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            <a href="javascript:;" onclick="editMail()" class="btn btn-xs btn-info"><?php __e("add email") ?>
                <i class="fa fa-sync-alt"></i></a>
            <hr/>
            <table class="table responsive table-hover table-striped table-bordered"
                   id="mail_list">
                <thead>
                <tr>
                    <th><?php __e("id"); ?></th>
                    <th><?php __e("email"); ?></th>
                    <th><?php __e("username"); ?></th>
                    <th><?php __e("server"); ?></th>
                    <th><?php __e("port"); ?></th>
                    <th><?php __e("secure type"); ?></th>
                    <th><?php __e("from name"); ?></th>
                    <th><?php __e("debug"); ?></th>
                    <th></th>
                </tr>
                </thead>

            </table>
            <?php
            modal_create([
                "bg" => "success",
                "size" => "lg",
            ]);

            ?>
<div class="clearfix"></div>
            <hr/>
            <a href="javascript:;" onclick="editText()" class="btn btn-xs btn-info"><?php __e("new template") ?>
                <i class="fa fa-sync-alt"></i></a>
            <hr/>
                <table class="table responsive table-hover table-striped table-bordered"
                       id="datatable_list">
                    <thead>
                    <tr>
                        <th><?php __e("ID"); ?></th>
                        <th><?php __e("name"); ?></th>
                        <th><?php __e("lang"); ?></th>
                        <th></th>
                    </tr>
                    </thead>

                </table>
            <?php

            ?>


        </div>
    </div>

<?php

$View->foot();