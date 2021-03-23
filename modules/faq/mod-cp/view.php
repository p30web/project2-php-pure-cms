<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('faq_list')) {
    error403();
    die;
}
global $View;
global $Cp;
global $Route;
global $data;
if(isset($Route->path[2])){
    $data['varPageID']=$Route->path[2];
    $varPageID=$Route->path[2];
}else{
    $varPageID=0;
}
$Cp->setSidebarActive('faq/list');
$View->header_styles_files("/modules/cp/assets/nestable/jquery.nestable.css");
$View->footer_js_files("/modules/cp/assets/nestable/jquery.nestable-".JK_DIRECTION.".js");
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');

$View->footer_js('<script>
function shownest(){
 ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/faq/view/list_ajax/'.$varPageID,
        "success_response" => "#nestable_ajax_faq_list",
        "loading" => [
        ]
    ]) . '
    }
    shownest();

function nestableEdit_faq_list(id=\'\') {
  $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/faq/view/faq/'.$varPageID,
        "data" => "{id:id}",
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}
function nestableRemove_faq_list(id) {
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
        "url" => JK_DOMAIN_LANG . 'cp/faq/view/remove',
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
$("#varPageID").on("change",function() {
  var thisPage=$(this).val();
  if(thisPage!==""){
window.location = \''.JK_DOMAIN_LANG.'cp/faq/view/\'+thisPage;
}
});
</script>');

                    $faqs=$database->select('faq_categories',["id","title"],[
                        "status"=>"active"
                    ]);
                    $cts=[];
                    if(sizeof($faqs)>=1){
                        foreach ($faqs as $faqc){
                            $cts[$faqc['id']]=$faqc['title'];
                        }
                    }
                    echo \Joonika\Forms\field_select([
                        "name" => "varPageID",
                        "ColType" => "12,12",
                        "title" => __("faq category"),
                        "first" => true,
                        "array" => $cts,
                        "required" => true
                    ]);
                    ?>
                </div>
            </div>
            <?php
            if($varPageID!=0){
                ?>
                <hr/>
                <a href="javascript:;" onclick="nestableEdit_faq_list()" class="btn btn-xs btn-info"><?php __e("add question") ?>
                    <i class="fa fa-plus-circle"></i></a>
                <hr/>

                <?php
                NestableTableInitHtml("faq_list");
                ?>
                <div id="action_body"></div>
                <?php
            }
            ?>
        </div>
    </div>
<?php
$View->foot();