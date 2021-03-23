<?php

if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_addTicket')) {
    error403();
    die;
}
global $View;
global $Users;
global $Route;
global $database;
global $Cp;
global $bulletin;
$Cp->setSidebarActive('bulletin/listAnnounce');
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
$View->footer_js_files("/modules/cp/assets/js/ckeditor/ckeditor.js");
$View->footer_js_files('/modules/cp/assets/js/jquery-validation/jquery.validate.min.js');
$View->footer_js( '
<script>
$(document).ready(function() {
    
    ' . datatable_structure([
        "id" => "announce_list",
        "type" => "ajax",
        "tabIndex"=> 1,
        "ajax_url" => JK_DOMAIN_LANG . "cp/bulletin/announcelist/list",
        "columns" => [
            "id",
            "title",
            "status",
            "operation",
        ],
    ]) . '

    
} );

function rmAnnounce(id) {
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
        "url" => JK_DOMAIN_LANG . 'cp/bulletin/announcelist/remove',
        "success_response" => "#action_body",
        "loading" => [
        ]
    ]) . '
    }
});

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
                   id="announce_list">
                <thead>
                <tr>
                    <th><?php __e("id"); ?></th>
                    <th><?php __e("title"); ?></th>
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