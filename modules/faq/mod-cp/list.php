<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('faq_list')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
$Cp->setSidebarActive('faq/list');

$View->footer_js( '
<script>
$(document).ready(function() {
    
    ' . datatable_structure([
        "id" => "datatable_list",
        "type" => "ajax",
        "tabIndex"=> 1,
        "ajax_url" => JK_DOMAIN_LANG . "cp/faq/list/list",
        "columns" => [
            "id",
            "title",
            "textCode",
            "questionCount",
            "status",
            "operation",
        ],
    ]) . '

    
} );
function addFaqCat(id=\'\') {
      $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/faq/list/formEdit',
        "success_response" => "#modal_global_body",
        "data" => "{id:id}",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}
</script>
');
$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            <a href="javascript:;" onclick="addFaqCat()" class="btn btn-xs btn-info"><?php __e("add") ?>
                <i class="fa fa-plus-circle"></i></a>
            <hr/>
            <table class="table responsive table-xs small text-xs padding2table table-hover table-striped table-bordered tablebghead-info"
                   id="datatable_list">
                <thead>
                <tr>
                    <th><?php __e("id"); ?></th>
                    <th><?php __e("title"); ?></th>
                    <th><?php __e("text code"); ?></th>
                    <th><?php __e("question count"); ?></th>
                    <th><?php __e("status"); ?></th>
                    <th><?php __e("operation"); ?></th>
                </tr>
                </thead>

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