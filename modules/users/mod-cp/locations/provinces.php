<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_locations_provinces')) {
    error403();
    die;
}
global $View;
global $Cp;
global $Route;
global $data;
if(isset($Route->path[3])){
    $data['countryPageID']=$Route->path[3];
    $countryID=$Route->path[3];
}else{
    $countryID=0;
}
$Cp->setSidebarActive('users/locations');
$View->header_styles_files("/modules/cp/assets/nestable/jquery.nestable.css");
$View->footer_js_files("/modules/cp/assets/nestable/jquery.nestable-".JK_DIRECTION.".js");
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');

$View->footer_js('<script>
function shownest(){
 ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/users/locations/provinces/list_ajax/'.$countryID,
        "success_response" => "#nestable_ajax_jk_users_locations_provinces",
        "loading" => [
        ]
    ]) . '
    }
    shownest();

function nestableEdit_jk_users_locations_provinces(id=\'\') {
  $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/users/locations/provinces/province/'.$countryID,
        "data" => "{id:id}",
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}
function nestableRemove_jk_users_locations_provinces(id) {
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
        "url" => JK_DOMAIN_LANG . 'cp/users/locations/provinces/remove',
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
        global $locations_tabs;
        tab_menus($locations_tabs, JK_DOMAIN_LANG . 'cp/users/locations/',2);
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
$("#countryPageID").on("change",function() {
  var thisPage=$(this).val();
  if(thisPage!==""){
window.location = \''.JK_DOMAIN_LANG.'cp/users/locations/provinces/\'+thisPage;
}
});
</script>');

                $countries=$database->select('jk_users_locations_countries',"id",[
                        "status"=>"active"
                ]);
                $cts=[];
                if(sizeof($countries)>=1){
                    foreach ($countries as $country){
                        $cts[$country]=langDefineGet(JK_LANG,'jk_users_locations_countries','id',$country);
                    }
                }
                echo \Joonika\Forms\field_select([
                    "name" => "countryPageID",
                    "ColType" => "12,12",
                    "title" => __("country"),
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
        <a href="javascript:;" onclick="nestableEdit_jk_users_locations_provinces()" class="btn btn-xs btn-info"><?php __e("add province") ?>
            <i class="fa fa-plus-circle"></i></a>
        <hr/>

        <?php
        NestableTableInitHtml("jk_users_locations_provinces");
        ?>
        <div id="action_body"></div>
            <?php
        }
            ?>
    </div>
</div>
<?php
$View->foot();