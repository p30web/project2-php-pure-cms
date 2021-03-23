<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('blog_list')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
$Cp->setSidebarActive('blog/list');

$View->footer_js( '
<script>
$(document).ready(function() {
    
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
        "ajax_url" => JK_DOMAIN_LANG . "cp/blog/list/list",
        "columns" => [
            "id",
            "title",
            "creator",
            "datetime",
            "views",
            "status",
            "operation",
        ],
    ]) . '

    
} );
</script>
');
$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            <?php


            ?>
                <table class="table responsive table-xs small text-xs padding2table table-hover table-striped table-bordered tablebghead-info"
                       id="datatable_list">
                    <thead>
                    <tr>
                        <th><?php __e("id"); ?></th>
                        <th><?php __e("title"); ?></th>
                        <th><?php __e("creator"); ?></th>
                        <th><?php __e("datetime"); ?></th>
                        <th><?php __e("views"); ?></th>
                        <th><?php __e("status"); ?></th>
                        <th><?php __e("operation"); ?></th>
                    </tr>
                    </thead>

                </table>
            <?php

            ?>


        </div>
    </div>

<?php

$View->foot();