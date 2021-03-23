<?php
if (!defined('jk')) die('Access Not Allowed !');
global $Users;
$Users->loggedCheck();
global $ACL;
if (!$ACL->hasPermission('crm_tickets_all')) {
    error403();
    die;
}
global $View;
global $Route;
global $database;
global $Cp;
$Cp->setSidebarActive('crm/allTickets');


$View->footer_js('
<script>
    ' . datatable_structure([
        "id" => "datatable_list",
        "type" => "ajax",
        "tabIndex" => 1,
        "columnDefs" => " [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
        { responsivePriority: 3, targets: -1 } ,
        { responsivePriority: 4, targets: -2 } 
        ]",
        "ajax_url" => JK_DOMAIN_LANG . "cp/crm/allTickets/ajax/listTickets?\"+$(\"#ticketsfilter\").serialize()+\"",
        "columns" => [
            "id",
            "title",
            "department",
            "owner",
            "createdBy",
            "createdOn",
            "closedBy",
            "closedOn",
            "priority",
            "status",
            "operation",
        ],
    ]) . '
    
    $("#ticketsfilter").on("change",function() {
  $("#datatable_list").DataTable().ajax.url( \'' . JK_DOMAIN_LANG . 'cp/crm/allTickets/ajax/listTickets?\'+$("#ticketsfilter").serialize() ).load();
});
  function getTicketsCount() {
     ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/crm/allTickets/ajax/getTicketsCount',
        "success_response" => "#actions_body_getTicketsCount",
        "error_swal" => false,
        "loading" => false
    ]) . '
  }
getTicketsCount();
setInterval(function(){ 
getTicketsCount();
$("#datatable_list").DataTable().ajax.reload(null, false);
 }, 10000);
 </script>
');

$View->head();
?>
    <div class="card">
        <div class="card-body">
            <div class="small">
                <?php
                echo \Joonika\Forms\form_create([
                    "id" => "ticketsfilter"
                ]);
                ?>
                <div class="custom-control custom-radio custom-control-inline border-left pl-4">
                    <input type="radio" id="types_allTickets" name="types" class="custom-control-input" value="all">
                    <label class="custom-control-label" for="types_allTickets"><?php echo __("all tickets") ?> <span
                                id="types_allTickets_flag" class="pl-1"><i
                                    class="fa fa-spinner fa-spin"></i></span></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline border-left pl-4">
                    <input type="radio" id="types_openTickets" name="types" class="custom-control-input" value="open"
                           checked="checked">

                    <label class="custom-control-label" for="types_openTickets"><?php echo __("open tickets") ?> <span
                                id="types_openTickets_flag" class="pl-1"><i
                                    class="fa fa-spinner fa-spin"></i></span></label>
                </div>
                <?php
                if($ACL->hasPermission('crm_tickets_list_view_all_general')){
                ?><div class="custom-control custom-radio custom-control-inline border-left pl-4">
                    <input type="radio" id="types_openGeneralTickets" name="types" class="custom-control-input"
                           value="openGeneral">

                    <label class="custom-control-label"
                           for="types_openGeneralTickets"><?php echo __("open general tickets") ?> <span
                                id="types_openGeneralTickets_flag" class="pl-1"><i
                                    class="fa fa-spinner fa-spin"></i></span></label>
                </div>
                <?php
                }
                echo \Joonika\Forms\form_end();
                ?>
            </div>

            <hr/>
            <table class="table responsive table-sm table-bordered table-info small" id="datatable_list">
                <thead>
                <tr>
                    <th><?php __e("ticket id") ?></th>
                    <th><?php __e("title") ?></th>
                    <th><?php __e("department") ?></th>
                    <th><?php __e("owner") ?></th>
                    <th><?php __e("created by") ?></th>
                    <th><?php __e("created on") ?></th>
                    <th><?php __e("closed by") ?></th>
                    <th><?php __e("closed on") ?></th>
                    <th><?php __e("priority") ?></th>
                    <th><?php __e("status") ?></th>
                    <th><?php __e("operation") ?></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div id="actions_body_getTicketsCount"></div>
            <div id="actions_body"></div>
        </div>
    </div>
<?php

$View->foot();