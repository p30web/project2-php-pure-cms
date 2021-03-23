<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('blog_categories')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
$Cp->setSidebarActive('blog/categories');
$View->header_styles_files("/modules/cp/assets/nestable/jquery.nestable.css");
$View->footer_js_files("/modules/cp/assets/nestable/jquery.nestable-".JK_DIRECTION.".js");
$View->footer_js( '
<script>
function shownest(){
 ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/blog/categories/list_ajax',
        "success_response" => "#nestable_ajax_jk_data",
        "loading" => [
        ]
    ]) . '
    }
    shownest();

function nestableEdit_jk_data(id=\'\') {
  $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/blog/categories/category',
        "data" => "{id:id}",
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}

</script>
');
$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            <a href="javascript:;" onclick="nestableEdit_jk_data()" class="btn btn-xs btn-info"><?php __e("add category") ?>
                <i class="fa fa-plus-circle"></i></a>
            <hr/>

                    <?php
                    NestableTableInitHtml("jk_data");
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