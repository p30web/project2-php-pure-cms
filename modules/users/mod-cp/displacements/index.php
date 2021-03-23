<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_displacements')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
$Cp->setSidebarActive('users/displacements');
$View->footer_js( '
<script>
    ' . datatable_structure([
        "id" => "datatable_list",
        "type" => "ajax",
        "tabIndex"=> 1,
        "ajax_url" => JK_DOMAIN_LANG . "cp/users/displacements/index/list",
        "columns" => [
            "id",
            "userID",
            "displacementTypeID",
            "roleID",
            "groupID",
            "datetime",
            "datetime_s",
            "creatorID",
            "status",
        ],
    ]) . '
    function updateDisplacementStatus() {
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . "cp/users/displacements/index/updateDisplacementStatus",
        "success_response" => "#action_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
    }
</script>
');
$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            <?php
            global $displacement_tabs;
            tab_menus($displacement_tabs, JK_DOMAIN_LANG . 'cp/users/displacements/',2);
            modal_create([
                "bg" => "success",
            ]);

            ?>
            <br/>
            <a href="javascript:;" onclick="updateDisplacementStatus()" class="btn btn-xs btn-info"><?php __e("update status") ?>
                <i class="fa fa-plus-circle"></i></a><span id="action_body"></span>
            <hr/>
            <table class="table responsive table-xs small text-xs padding2table table-hover table-striped table-bordered tablebghead-info"
                   id="datatable_list">
                <thead>
                <tr>
                    <th><?php __e("ID"); ?></th>
                    <th><?php __e("user"); ?></th>
                    <th><?php __e("displacement type"); ?></th>
                    <th><?php __e("role"); ?></th>
                    <th><?php __e("group"); ?></th>
                    <th><?php __e("datetime"); ?></th>
                    <th><?php __e("submit datetime"); ?></th>
                    <th><?php __e("creator"); ?></th>
                    <th><?php __e("status"); ?></th>
                </tr>
                </thead>

            </table>
        </div>
    </div>

<?php

$View->foot();