<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_config_educational_fields')) {
    error403();
    die;
}
global $View;
global $Cp;
global $Route;
global $data;
if(isset($Route->path[3])){
    $data['catPageID']=$Route->path[3];
    $catID=$Route->path[3];
}else{
    $catID=0;
}
$Cp->setSidebarActive('personnel/config');
$View->header_styles_files("/modules/cp/assets/nestable/jquery.nestable.css");
$View->footer_js_files("/modules/cp/assets/nestable/jquery.nestable-".JK_DIRECTION.".js");
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');

$View->footer_js('<script>
function shownest(){
 ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/personnel/config/educationalFields/list_ajax/'.$catID,
        "success_response" => "#nestable_ajax_personnel_fields",
        "loading" => [
        ]
    ]) . '
    }
    shownest();

function nestableEdit_personnel_fields(id=\'\') {
  $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/personnel/config/educationalFields/field/'.$catID,
        "data" => "{id:id}",
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}
function nestableEdit_personnel_fields_bulk() {
  $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/personnel/config/educationalFields/fieldBulk/' . $catID,
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}
function nestableRemove_personnel_fields(id) {
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
        "url" => JK_DOMAIN_LANG . 'cp/personnel/config/educationalFields/remove',
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
        global $personnelConfigTabs;
        tab_menus($personnelConfigTabs, JK_DOMAIN_LANG . 'cp/personnel/config/',2);
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
$("#catPageID").on("change",function() {
  var thisPage=$(this).val();
  if(thisPage!==""){
window.location = \''.JK_DOMAIN_LANG.'cp/personnel/config/educationalFields/\'+thisPage;
}
});
</script>');

                $cats=$database->select('personnel_fields_cats',"id",[
                        "status"=>"active"
                ]);
                $cts=[];
                if(sizeof($cats)>=1){
                    foreach ($cats as $cat){
                        $cts[$cat]=langDefineGet(JK_LANG,'personnel_fields_cats','id',$cat);
                    }
                }
                echo \Joonika\Forms\field_select([
                    "name" => "catPageID",
                    "ColType" => "12,12",
                    "title" => __("set"),
                    "first" => true,
                    "array" => $cts,
                    "required" => true
                ]);
            ?>
        </div>
        </div>
        <?php
        if($catID!=0){
        ?>
        <hr/>
        <a href="javascript:;" onclick="nestableEdit_personnel_fields()" class="btn btn-xs btn-info"><?php __e("add field") ?>
            <i class="fa fa-plus-circle"></i></a>
            <a href="javascript:;" onclick="nestableEdit_personnel_fields_bulk()" class="btn btn-xs btn-info"><?php __e("add bulk field") ?>
            <i class="fa fa-plus-circle"></i></a>
        <hr/>

        <?php
        NestableTableInitHtml("personnel_fields");
        ?>
        <div id="action_body"></div>
            <?php
        }
            ?>
    </div>
</div>
<?php
$View->foot();