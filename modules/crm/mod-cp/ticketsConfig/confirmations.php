<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets_config')) {
    error403();
    die;
}
global $View;
global $Cp;
global $Route;
global $data;
if(isset($Route->path[3])){
    $data['parentPageID']=$Route->path[3];
    $countryID=$Route->path[3];




    $View->footer_js('<script>
' . datatable_structure([
            "id" => "datatable_list",
            "type" => "ajax",
            "tabIndex" => 1,
            "ajax_url" => JK_DOMAIN_LANG . "cp/crm/ticketsConfig/confirmations/list?subjectID=".$countryID,
            "columnDefs" => "[{
      \"targets\": [1,2],
      \"sortable\": false
    } ]",
            "columns" => [
                "id",
                "description",
                "operation",
            ],
        ]) . '
        
        function reloadDataTable(){
     $("#datatable_list").DataTable().ajax.url( \'' . JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/confirmations/list?subjectID='.$countryID.'\').load();
         }
     $("#modal_global").on(\'hide.bs.modal\', function () {
reloadDataTable();
    });

function confirmAdd(userID,subjectID) {
  $("#modal_global").modal("show");
      ' . ajax_load([
            "url" => JK_DOMAIN_LANG . "cp/crm/ticketsConfig/confirmations/addLevel",
            "data" => "{userID:userID,subjectID:subjectID}",
            "success_response" => "#modal_global_body",
        ]) . '
}
</script>');





}else{
    $countryID=0;
}
$Cp->setSidebarActive('crm/ticketsConfig');
$View->header_styles_files("/modules/cp/assets/nestable/jquery.nestable.css");
$View->footer_js_files("/modules/cp/assets/nestable/jquery.nestable-".JK_DIRECTION.".js");
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
$View->footer_js_files('/modules/cp/assets/js/jquery-validation/jquery.validate.min.js');


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
        <div class="row <?php echo JK_DIRECTION ?>">
        <div class="col-4 offset-4 text-center">
            <?php
            global $database;
            $View->footer_js('<script>
$("#parentPageID").on("change",function() {
  var thisPage=$(this).val();
  if(thisPage!==""){
window.location = \''.JK_DOMAIN_LANG.'cp/crm/ticketsConfig/confirmations/\'+thisPage;
}
});
</script>');

                $countries=$database->select('crm_tickets_subjects',"id",[
                        "status"=>"active"
                ]);
                $cts=[];
                if(sizeof($countries)>=1){
                    foreach ($countries as $country){
                        $cts[$country]=langDefineGet(JK_LANG,'crm_tickets_subjects','id',$country);
                    }
                }
                echo \Joonika\Forms\field_select([
                    "name" => "parentPageID",
                    "ColType" => "12,12",
                    "title" => __("subject"),
                    "first" => true,
                    "array" => $cts,
                    "required" => true
                ]);
            ?>
        </div>
        </div>
        <?php
        if($countryID!=0){
        ?>
        <hr/>

            <table class="table responsive table-sm small" id="datatable_list">
                <thead>
                <tr>
                    <th><?php echo __("id"); ?></th>
                    <th><?php echo __("description"); ?></th>
                    <th><?php echo __("operation"); ?></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>

        <div id="action_body"></div>
            <?php
        }
            ?>

        <?php
        modal_create([
            "bg" => "success",
        ]);
        ?>
    </div>
</div>
<?php
$View->foot();