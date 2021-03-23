<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $View;
if (!$ACL->hasPermission('crm_contactCenter')) {
    error403();
    die;
}
$_POST['search'] = \Joonika\Idate\tr_num($_POST['search'], 'en');

if (isset($_POST['searchBy'])) {
    if ($_POST['searchBy'] == "phoneNumber") {
        if (substr($_POST['search'], 0, 1) != "0") {
            $_POST['search'] = '0' . $_POST['search'];
        }
        if (isset($_POST['search'])) {
            \Joonika\listModulesReadFiles('mod-crm/TicketContactCenterSearch.php');
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
                    "ajax_url" => JK_DOMAIN_LANG . "cp/crm/tickets/ajax/listOrigin?origin=ContactCenter&originValue=" . $_POST['search'],
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
</script>
');
            ?>
            <div class="card">
                <div class="card-body">
                    <?php
                    ?>
                    <button type="button" class="btn btn-success" onclick="addTicket('<?php echo $_POST['search'] ?>')">
                        <i class="fa fa-plus-circle"></i> <?php echo __("add ticket"); ?></button>
                    <?php
                    global $database;
                    $datas = $database->select('crm_tickets_subjects', 'id', [
                        "AND" => [
                            "status" => "active",
                            "important" => 1,
                        ]
                    ]);
                    $colors = [
                        "info",
                        "primary",
                        "danger",
                    ];
                    $i = 0;
                    if (sizeof($datas) >= 1) {
                        foreach ($datas as $data) {
                            ?>
                            <button type="button" class="btn btn-outline-<?php echo $colors[$i]; ?> btn-sm"
                                    onclick="addTicket('<?php echo $_POST['search'] ?>','<?php echo $data; ?>')"><?php echo langDefineGet(JK_LANG, 'crm_tickets_subjects', 'id', $data); ?></button>
                            <?php
                            $i++;
                            if ($i == sizeof($colors)) {
                                $i = 1;
                            }
                        }
                    }

                    ?>
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
                </div>
            </div>
            <?php

            echo $View->footer_js;
        }
    } elseif ($_POST['searchBy'] == "ticketNumber") {
        global $database;
        $searchTicket = $database->select('crm_tickets', '*', [
                "AND"=>[
                    "id" => $_POST['search'],
                    "global"=>1,
                    "phone[!]"=>"",
                ]
        ]);
        if (sizeof($searchTicket) >= 1) {
            ?>
            <table class="table table-sm table-info">

                <?php
                foreach ($searchTicket as $tic) {
                    ?>
                    <tr>
                        <td><?php echo $tic['id'] ?></td>
                        <td><?php echo $tic['title'] ?></td>
                        <td><a href="<?php echo JK_DOMAIN_LANG; ?>cp/crm/contactCenter/<?php echo $tic['phone'] ?>" class="btn btn-info btn-sm"><?php __e("view number") ?></a></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        }
    }
}
