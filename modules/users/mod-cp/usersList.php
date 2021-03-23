<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_list')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
\Joonika\Idate\idateReady(JK_LANG);
\Joonika\Upload\dropzone_load();

$Cp->setSidebarActive('users/usersList');

$View->footer_js( '
<script>

function add_user(id=\'\') {
        $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/users/usersList/addUser',
        "data" => "{id:id}",
        "success_response" => "#modal_global_body",
        "loading" => []
    ]) . '
    }
    function editgroup(id=\'\') {
        $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/users/usersList/turnover',
        "data" => "{userID:id}",
        "success_response" => "#modal_global_body",
        "loading" => []
    ]) . '
    }  
      function changePassword(id=\'\') {
        $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/users/usersList/changePassword',
        "data" => "{userID:id}",
        "success_response" => "#modal_global_body",
        "loading" => []
    ]) . '
    }   
          function changeImage(id=\'\') {
        $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/users/usersList/changeImage',
        "data" => "{userID:id}",
        "success_response" => "#modal_global_body",
        "loading" => []
    ]) . '
    }     
     function rmgroprle(id=\'\') {
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
        "data" => "{remid:id}",
        "url" => JK_DOMAIN_LANG . 'cp/users/usersList/rmgroprle',
        "success_response" => "#action_body_modal",
        "loading" => [
        ]
    ]) . '
    }
});
    }
    
$(document).ready(function() {
    
    ' . datatable_structure([
        "id" => "datatable_list",
        "type" => "ajax",
        "columnDefs" => "[{
      \"targets\": [8],
      \"sortable\": false
    } ]",
        "ajax_url" => JK_DOMAIN_LANG . "cp/users/usersList/list",
        "columns" => [
            "id",
            "image",
            "username",
            "email",
            "mobile",
            "sex",
            "name",
            "family",
            "roleGroup",
            "regDate",
            "operation",
        ],
    ]) . '

    
} );
</script>
');
$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            <a href="javascript:;" onclick="add_user()" class="btn btn-xs btn-info"><?php __e("add user") ?>
                <i class="fa fa-plus-circle"></i></a>
            <span id="update_panel"></span>

            <hr/>
            <form action="" method="post">
                <table class="table responsive table-xs small text-xs padding2table table-hover table-striped table-bordered tablebghead-info"
                       id="datatable_list">
                    <thead>
                    <tr>
                        <th><?php __e("ID"); ?></th>
                        <th><?php __e("image"); ?></th>
                        <th><?php __e("username"); ?></th>
                        <th><?php __e("email"); ?></th>
                        <th><?php __e("mobile"); ?></th>
                        <th><?php __e("sex"); ?></th>
                        <th><?php __e("name"); ?></th>
                        <th><?php __e("family"); ?></th>
                        <th><?php __e("role & group"); ?></th>
                        <th><?php __e("register date"); ?></th>
                        <th><?php __e("operations"); ?></th>
                    </tr>
                    </thead>
                </table>
            </form>
            <?php
modal_create([
        "bg"=>"success"
]);
            ?>


        </div>
    </div>

<?php

$View->foot();