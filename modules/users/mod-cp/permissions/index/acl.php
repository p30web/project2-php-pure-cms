<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_permissions')) {
    error403();
    die;
}
global $View;
global $Users;
global $Route;
global $Cp;
global $database;
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
$View->header_styles_files("/modules/cp/assets/nestable/jquery.nestable.css");
$perm=$database->get('jk_users_permissions','*',[
    "permKey"=>$Route->path[4]
]);
$Cp->setSidebarActive('users/permissions');
$View->footer_js( '
<script>
    '.datatable_structure([
        "id" => "datatable_list",
        "type" => "ajax",
        "columnDefs" => "[{
      \"targets\": [2],
      \"sortable\": false
    } ]",
        "ajax_url" => JK_DOMAIN_LANG . "cp/users/permissions/index/acl_users?permKey=".$perm['permKey'],
        "columns" => [
            "name",
            "permission",
            "operation",
        ],
    ]).'
    
function add_perm_user() {
    $("#modal_global").modal("show");
                        ' . ajax_load([
        "data" => "{permID:".$perm['id']."}",
        "url" => JK_DOMAIN_LANG . 'cp/users/permissions/index/acl_add_user',
        "success_response" => "#modal_global_body",
        "loading" => [
        ]
    ]) . '
                        }
                        
                         function add_perm_group() {
    $("#modal_global_lg").modal("show");
                        ' . ajax_load([
        "data" => "{permID:".$perm['id']."}",
        "url" => JK_DOMAIN_LANG . 'cp/users/permissions/index/acl_add_group',
        "success_response" => "#modal_global_lg_body",
        "loading" => [
        ]
    ]) . '
                        }
                        
                        function removeuserperm(id) {
    swal({
  title: \'' . __("are you sure to remove") . '\',
  type: \'warning\',
  showCancelButton: true,
  confirmButtonColor: \'#3085d6\',
  confirmButtonText: \'' . __("Yes, delete it") . '!\',
  cancelButtonText: \'' . __("cancel") . '!\'
}).then((result) => {
if(result.value){
  ' . ajax_load([
        "data" => "{userpermID:id}",
        "url" => JK_DOMAIN_LANG . 'cp/users/permissions/index/acl_remove_user',
        "success_response" => "#userbtn_span_\"+id+\"",
        "loading" => [
        ]
    ]) . '
    }
});
}                        
                            function removegroupperm(id) {
    swal({
  title: \'' . __("are you sure to remove") . '\',
  type: \'warning\',
  showCancelButton: true,
  confirmButtonColor: \'#3085d6\',
  confirmButtonText: \'' . __("Yes, delete it") . '!\',
  cancelButtonText: \'' . __("cancel") . '!\'
}).then((result) => {
if(result.value){
  ' . ajax_load([
        "data" => "{grouppermID:id}",
        "url" => JK_DOMAIN_LANG . 'cp/users/permissions/index/acl_remove_group',
        "success_response" => "#groupbtn_span_\"+id+\"",
        "loading" => [
        ]
    ]) . '
    }
});
}             
             function removeroleperm(id) {
    swal({
  title: \'' . __("are you sure to remove") . '\',
  type: \'warning\',
  showCancelButton: true,
  confirmButtonColor: \'#3085d6\',
  confirmButtonText: \'' . __("Yes, delete it") . '!\',
  cancelButtonText: \'' . __("cancel") . '!\'
}).then((result) => {
if(result.value){
  ' . ajax_load([
        "data" => "{rolepermID:id,permID:" . $perm['id'] . "}",
        "url" => JK_DOMAIN_LANG . 'cp/users/permissions/index/acl_remove_group',
        "success_response" => "#rolebtn_span_\"+id+\"",
        "loading" => [
        ]
    ]) . '
    }
});
}
    
</script>
');
$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            <?php
            global $permission_tabs;
            tab_menus($permission_tabs, JK_DOMAIN_LANG . 'cp/users/permissions/',2);
            modal_create([
                "bg" => "success",
            ]);
            modal_create([
                "id" => "modal_global_lg",
                "size" => "lg",
                "bg" => "success",
            ]);
            ?>
            <br/>
    <div class="card">
        <div class="card-header text-center">
            <?php
            echo $perm['permKey'];
            ?>
        </div>
        <div class="card-body row">
            <div class="col-6 border-left">
                <a class="btn btn-info btn-xs" href="javascript:;"
                   onclick="add_perm_user()"><i
                            class="fa fa-plus"></i></a>
<hr/>
                <table class="table table-sm responsive" id="datatable_list">
                    <thead>
                    <tr>
                        <th><?php __e("name"); ?></th>
                        <th><?php __e("permission"); ?></th>
                        <th><?php __e("operations"); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    ?>

                    </tbody>
                </table>

            </div>
            <div class="col-6">

                <a class="btn btn-info btn-xs" href="javascript:;"
                   onclick="add_perm_group()"><i
                            class="fa fa-plus"></i></a>
                <hr/>
                <table class="table datatable-html-groups  table-striped table-bordered">
                    <thead>
                    <tr>
                        <th  class="w-25"><?php __e("role"); ?></th>
                        <th><?php __e("groups"); ?></th>
                    </tr>
                    </thead>
                    <tbody >
                    <?php
                    $roles = $database->select('jk_users_perms_groups', 'roleID', [
                        "permID" => $perm['id'],
                        "GROUP" => "roleID",
                    ]);
                    if (sizeof($roles) >= 1) {
                        foreach ($roles as $role) {
                            ?>
                            <tr>
                                <td><?php
                                    if ($role == 0) {
                                        __e("all roles");
                                    } else {
                                        echo \Joonika\Modules\Users\roleTitle($role);
                                    }
                                    ?>
                                    <span id="rolebtn_span_<?php echo $role ?>">
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                            onclick="removeroleperm(<?php echo $role; ?>)"><i
                                                                class="fa fa-times"></i></button>
                                                </span>
                                </td>
                                <td><?php
                                    $selectsets = $database->select('jk_users_perms_groups', ['ID', 'groupID'], [
                                        "AND" => [
                                            "permID" => $perm['id'],
                                            "roleID" => $role
                                        ]
                                    ]);
                                    if (sizeof($selectsets) >= 1) {
                                        foreach ($selectsets as $selectset) {
                                            if ($selectset['groupID'] != 0) {
                                                ?>
                                                <div id="groupbtn_span_<?php echo $selectset['ID'] ?>"
                                                     class="btn btn-default btn-sm"><?php echo \Joonika\Modules\Users\groupTitle($selectset['groupID']); ?>
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                            onclick="removegroupperm(<?php echo $selectset['ID']; ?>)">
                                                        <i class="fa fa-times"></i></button>
                                                </div>
                                                <?php
                                            } else {

                                                ?>
                                                <div id="groupbtn_span_<?php echo $selectset['ID'] ?>"
                                                     class="btn btn-default btn-sm"><?php echo __("all groups"); ?>
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                            onclick="removegroupperm(<?php echo $selectset['ID']; ?>)">
                                                        <i class="fa fa-times"></i></button>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    ?></td>
                            </tr>
                            <?php
                        }
                    }

                    ?>

                    </tbody>
                </table>

            </div>

        </div>
    </div>

        </div>
    </div>

<?php

$View->foot();