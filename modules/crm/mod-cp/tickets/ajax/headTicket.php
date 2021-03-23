<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
global $View;
$Users->loggedCheck();
if (!$ACL->hasPermission('crm_tickets')) {
    error403();
    die;
}
if(isset($_POST['ticketID'])){
    global $database;
    global $ticket;
    $ticket=$database->get('crm_tickets','*',[
            "id"=>$_POST['ticketID']
    ]);
    if(isset($ticket['id'])){
        new \Joonika\Modules\Crm\Crm();
    ?><div class="card m-0">
            <div class="card-body p-0">
    <table class="table responsive table-sm table-bordered small  mb-0 text-center" id="datatable_list">
        <thead class=" table-info">
        <tr>
            <th><?php __e("ticket id") ?></th>
            <th><?php __e("department") ?></th>
            <th><?php __e("owner") ?></th>
            <th><?php __e("created by") ?></th>
            <th><?php __e("created on") ?></th>
            <th><?php __e("closed by") ?></th>
            <th><?php __e("closed on") ?></th>
            <th><?php __e("priority") ?></th>
            <th><?php __e("status") ?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?php echo $ticket['id']; ?></td>
            <td><?php echo \Joonika\Modules\Crm\ticketDepartmentName($ticket['department']); ?></td>
            <td><?php echo nickName($ticket['owner']); ?></td>
            <td><?php echo nickName($ticket['createdBy']); ?></td>
            <td><?php echo \Joonika\Idate\date_int("Y/m/d H:i:s", $ticket['createdOn']); ?></td>
            <td><?php echo nickName($ticket['closedBy']); ?></td>
            <td><?php echo $ticket['closedOn']; ?></td>
            <td><?php echo \Joonika\Modules\Crm\ticketPriority($ticket['priority'], true); ?></td>
            <td><?php echo \Joonika\Modules\Crm\ticketStatus($ticket['status'], true); ?></td>
        </tr>
        </tbody>
    </table>
</div>
</div>
        <hr/>


<?php
        $View->footer_js('<script>
$("#datatable_list").dataTable({
  "searching": false,
  "paging": false,
  "bInfo" : false
});
</script>');
        echo $View->footer_js;
    }
}