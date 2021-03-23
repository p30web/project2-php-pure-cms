<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
$Users->loggedCheck();
if (!$ACL->hasPermission('cp_translate')) {
    error403();
    die;
}
global $View;
global $Cp;
$Cp->setSidebarActive('main/translate');

$View->footer_js( '
<script>
$(document).ready(function() {
    function updatetr(getID,getval) {
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/main/translate/edit',
        "data" => "{getID:getID,getval:getval }",
        "success_response" => "#tr_update_\"+getID+\"",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
    }
    ' . datatable_structure([
        "id" => "datatable_list",
        "type" => "ajax",
        "tabIndex"=> 1,
        "drawCallback" => "
        $(document).on('change','[id^=\"trval_\"]',function(){ 
var getID=$(this).attr('id');
      var getval=$(this).val();
      getID=getID.replace('trval_','');
      updatetr(getID,getval);
      });
        ",
        "ajax_url" => JK_DOMAIN_LANG . "cp/main/translate/list",
        "columns" => [
            "id",
            "lang",
            "var",
            "text",
        ],
    ]) . '

    
} );
function updatepanel() {
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/main/translate/update',
        "data" => "{}",
        "success_response" => "#update_panel",
        "loading" => true
    ]) . '
    }
</script>
');
$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            <?php


            ?>
            <a href="javascript:;" onclick="updatepanel()" class="btn btn-xs btn-info"><?php __e("update template") ?>
                <i class="fa fa-sync-alt"></i></a>
            <span id="update_panel"></span>

            <hr/>
            <form action="" method="post">
                <table class="table responsive table-xs small text-xs padding2table table-hover table-striped table-bordered tablebghead-info"
                       id="datatable_list">
                    <thead>
                    <tr>
                        <th><?php __e("ID"); ?></th>
                        <th><?php __e("lang"); ?></th>
                        <th><?php __e("var"); ?></th>
                        <th><?php __e("text"); ?></th>
                    </tr>
                    </thead>

                </table>
            </form>
            <?php

            ?>


        </div>
    </div>

<?php

$View->foot();