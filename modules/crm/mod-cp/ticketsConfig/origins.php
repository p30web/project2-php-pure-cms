<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets_config')) {
    error403();
    die;
}
global $View;
global $Cp;
$View->footer_js_files('/modules/cp/assets/js/jquery-validation/jquery.validate.min.js');

$Cp->setSidebarActive('crm/ticketsConfig');
$View->footer_js('<script>
function addOrigin(id=\'\') {
  $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/origins/addOrigin',
        "data" => "{id:id}",
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}
function rmOriginTitle(id) {
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
        "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/origins/removeOrigin',
        "success_response" => "#action_body",
        "loading" => [
        ]
    ]) . '
    }
});
    }  
</script>');
$View->head();

?>
    <div class="card">
        <div class="card-body">
            <?php
            global $ticketsConfig;
            tab_menus($ticketsConfig, JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/',2);
            modal_create([
                "bg" => "success",
            ]);
            ?>
            <hr/>
            <a href="javascript:;" onclick="addOrigin()" class="btn btn-xs btn-info"><?php __e("add") ?>
                <i class="fa fa-plus-circle"></i></a>
<table class="table table-sm responsive">
    <thead>
    <tr>
        <th><?php __("origin") ?></th>
        <th><?php __("operation") ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    global $database;
    $originsTitle=$database->select('crm_tickets_origins_title','*',[
            "status"=>"active"
    ]);
    if(sizeof($originsTitle)>=1){
        foreach ($originsTitle as $originTitle){
            ?>
            <tr>
                <td><?php echo $originTitle['name'] ?></td>
                <td><button class="btn btn-danger btn-sm" onclick="rmOriginTitle(<?php echo $originTitle['id']; ?>)"><i class="fa fa-times"></i></button></td>
            </tr>
            <?php
        }
    }

    ?>

    </tbody>
</table>
            <div id="action_body"></div>

        </div>
    </div>
<?php
$View->foot();
