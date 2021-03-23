<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_confirms')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
$Cp->setSidebarActive('users/confirms');
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
$View->footer_js_files('/modules/cp/assets/js/jquery-validation/jquery.validate.min.js');
$View->footer_js('
<script>
' . datatable_structure([
        "id" => "datatable_list",
        "type" => "ajax",
        "tabIndex" => 1,
        "ajax_url" => JK_DOMAIN_LANG . "cp/users/confirms/list",
        "columnDefs" => "[{
      \"targets\": [1,2,3,4,5,6],
      \"sortable\": false
    } ]",
        "columns" => [
            "id",
            "module",
            "level1",
            "level2",
            "level3",
            "level4",
            "level5",
            "operation",
        ],
    ]) . '
    function levelAdd(level,id) {
      $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . "cp/users/confirms/addLevel",
        "data" => "{level:level,id:id}",
        "success_response" => "#modal_global_body",
    ]) . '
    }
    function reloadDataTable(){
     $("#datatable_list").DataTable().ajax.url( \'' . JK_DOMAIN_LANG . 'cp/users/confirms/list\').load();
         }
     $("#modal_global").on(\'hide.bs.modal\', function () {
reloadDataTable();
    });
     function removeCL(cID) {
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
        "data" => "{cID:cID}",
        "url" => JK_DOMAIN_LANG . "cp/users/confirms/removeCL",
        "success_response" => "#action_body",
        "loading" => [
        ]
    ]) . '
    }
});
     }
     function addC() {
       $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . "cp/users/confirms/addC",
        "success_response" => "#modal_global_body",
    ]) . '
     }  
        function editC(id) {
       $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . "cp/users/confirms/addC",
        "success_response" => "#modal_global_body",
        "data" => "{id:id}",
    ]) . '
     }
</script>
');
$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            <button class="btn btn-sm btn-info" onclick="addC()"><i class="fa fa-plus"></i></button>
            <hr/>
            <table class="table responsive table-sm small" id="datatable_list">
                <thead>
                <tr>
                    <th><?php echo __("title"); ?></th>
                    <th><?php echo __("module"); ?></th>
                    <th><?php echo __("level 1"); ?></th>
                    <th><?php echo __("level 2"); ?></th>
                    <th><?php echo __("level 3"); ?></th>
                    <th><?php echo __("level 4"); ?></th>
                    <th><?php echo __("level 5"); ?></th>
                    <th><?php echo __("operation"); ?></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div id="action_body"></div>

            <?php
            modal_create([
                "bg" => "success",
            ]);
            ?>
        </div>
    </div>

<?php

$View->foot();