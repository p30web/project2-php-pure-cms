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
}else{
    $countryID=0;
}
$Cp->setSidebarActive('crm/ticketsConfig');
$View->header_styles_files("/modules/cp/assets/nestable/jquery.nestable.css");
$View->footer_js_files("/modules/cp/assets/nestable/jquery.nestable-".JK_DIRECTION.".js");
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');

$View->footer_js('<script>
function shownest(){
 ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/subjects/list_ajax/'.$countryID,
        "success_response" => "#nestable_ajax_crm_tickets_subjects",
        "loading" => [
        ]
    ]) . '
    }
    shownest();

function nestableEdit_crm_tickets_subjects(id=\'\') {
  $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/subjects/subject/'.$countryID,
        "data" => "{id:id}",
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}
function importantSubject(id=\'\') {
swal({
  title: \'' . __("are you sure") . '\',
  type: \'warning\',
  showCancelButton: true,
  confirmButtonColor: \'#3085d6\',
  confirmButtonText: \'' . __("Yes") . '!\',
  cancelButtonText: \'' . __("cancel") . '!\'
}).then((result) => {
if(result.value){
  ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/subjects/importantSubject',
        "data" => "{id:id}",
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
    }
});

}
function nestableRemove_crm_tickets_subjects(id) {
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
        "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/subjects/remove',
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
        <div class="row <?php echo JK_DIRECTION ?>">
        <div class="col-4 offset-4 text-center">
            <?php
            global $database;
            $View->footer_js('<script>
$("#parentPageID").on("change",function() {
  var thisPage=$(this).val();
  if(thisPage!==""){
window.location = \''.JK_DOMAIN_LANG.'cp/crm/ticketsConfig/subjects/\'+thisPage;
}
});
</script>');

                $countries=$database->select('crm_tickets_parent_subjects',"id",[
                        "status"=>"active"
                ]);
                $cts=[];
                if(sizeof($countries)>=1){
                    foreach ($countries as $country){
                        $cts[$country]=langDefineGet(JK_LANG,'crm_tickets_parent_subjects','id',$country);
                    }
                }
                echo \Joonika\Forms\field_select([
                    "name" => "parentPageID",
                    "ColType" => "12,12",
                    "title" => __("parent subjects"),
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
        <a href="javascript:;" onclick="nestableEdit_crm_tickets_subjects()" class="btn btn-xs btn-info"><?php __e("add subject") ?>
            <i class="fa fa-plus-circle"></i></a>
        <hr/>

        <?php
        NestableTableInitHtml("crm_tickets_subjects");
        ?>
        <div id="action_body"></div>
            <?php
        }
            ?>
    </div>
</div>
<?php
$View->foot();