<?php
if (!defined('jk')) die('Access Not Allowed !');
global $Users;
$Users->loggedCheck();
global $ACL;
if (!$ACL->hasPermission('crm_tickets')) {
    error403();
    die;
}
global $View;
global $Route;
global $database;
global $Cp;
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
$Cp->setSidebarActive('crm/tickets');


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
        "ajax_url" => JK_DOMAIN_LANG . "cp/crm/tickets/ajax/listTickets?\"+$(\"#ticketsfilter\").serialize()+\"",
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
  $("#datatable_list").DataTable().ajax.url( \'' . JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/listTickets?\'+$("#ticketsfilter").serialize() ).load();
});
  function getTicketsCount() {
     ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/getTicketsCount',
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
new \Joonika\Modules\Crm\Crm();
?>
    <div class="card">
        <div class="card-body">
            <div class="small">
                <?php
                echo \Joonika\Forms\form_create([
                    "id" => "ticketsfilter",
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
                ?>
                <div class="custom-control custom-radio custom-control-inline border-left pl-4">
                    <input type="radio" id="types_myTickets" name="types" class="custom-control-input" value="my">

                    <label class="custom-control-label"
                           for="types_myTickets"><?php echo __("my open tickets") ?> <span id="types_myTickets_flag"
                                                                                           class="pl-1"><i
                                    class="fa fa-spinner fa-spin"></i></span></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline border-left pl-4">
                    <input type="radio" id="types_unreadTickets" name="types" class="custom-control-input"
                           value="unread">

                    <label class="custom-control-label" for="types_unreadTickets"><?php echo __("unread") ?> <span
                                id="types_unreadTickets_flag" class="pl-1"><i class="fa fa-spinner fa-spin"></i></span></label>
                </div>
                <hr class="w-100"/>
                <div class="row">
                <?php
                echo div_start('col-md-3');
                $users=\Joonika\Modules\Users\usersArray();
                echo \Joonika\Forms\field_select([
                    "name" => "creatorID",
                    "title" => __("creator"),
                    "ColType" => "12,12",
                    "array" => $users,
                    "first" => true,
                    "firstTitle" => __("all"),
                ]);
                echo div_close();

                echo div_start('col-md-3');
                $users=\Joonika\Modules\Users\usersArray();
                echo \Joonika\Forms\field_select([
                    "name" => "owner",
                    "title" => __("owner"),
                    "ColType" => "12,12",
                    "array" => $users,
                    "first" => true,
                    "firstTitle" => __("all")
                ]);
                echo div_close();

                echo div_start('col-md-3');
                $deps=\Joonika\Modules\Crm\ticketsDepartments();
                echo \Joonika\Forms\field_select([
                    "name" => "department",
                    "title" => __("department"),
                    "ColType" => "12,12",
                    "array" => $deps,
                    "first" => true,
                    "firstTitle" => __("all")
                ]);
                echo div_close();

                echo div_start('col-md-3');
                echo \Joonika\Forms\field_select([
                    "name" => "status",
                    "title" => __("status"),
                    "ColType" => "12,12",
                    "array" => [
                            "open"=>__("open"),
                            "new"=>__("new"),
                            "closed"=>__("closed"),
                            "hold"=>__("hold"),
                            "confirm"=>__("confirm"),
                    ],
                    "first" => true,
                    "firstTitle" => __("all")
                ]);
                echo div_close();

                echo \Joonika\Forms\form_end();
                ?>
                </div>
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