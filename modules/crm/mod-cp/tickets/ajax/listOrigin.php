<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
global $database;
$getopt = datatable_get_opt();
if ($getopt) {
    new \Joonika\Modules\Crm\Crm();


    $ticketsIDs=[];
    if ($getopt['search'] != '') {
        $ticketsID2 = $database->select('crm_tickets_origins', 'ticketID', [
            "originValue[~]" => $getopt['search'],
        ]);
        $ticketsID1 = $database->select('crm_tickets', '*', [
            "title[~]" => $getopt['search'],
        ]);
        $ticketsIDs=array_merge($ticketsID1,$ticketsID2);

        $lists = $database->select('crm_tickets', '*', [
            "ID"=>$ticketsIDs,
            "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
            "LIMIT" => [$getopt['start'], $getopt['length']]
        ]);

    } else {
        if (isset($_GET['origin'])) {
            $origins = $_GET['origin'];
        } else {
            $origins = $database->select('crm_tickets_origins', 'origin', [
                "GROUP" => "origin"
            ]);
        }
        if (isset($_GET['originValue'])) {
            $originsVal = $_GET['originValue'];
        } else {
            $originsVal = $database->select('crm_tickets_origins', 'originValue', [
                "GROUP" => "originValue"
            ]);
        }

        $ticketsIDs = $database->select('crm_tickets_origins', 'ticketID', [
            "AND" => [
                "origin" => $origins,
                "originValue" => $originsVal,
            ]
        ]);
        $lists = $database->select('crm_tickets', '*', [
            "AND"=>[
            "id" => $ticketsIDs,
            "global" => 1,
            ],
            "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
            "LIMIT" => [$getopt['start'], $getopt['length']]
        ]);
    }
    $countall = $database->count('crm_tickets', [
        "ID"=>$ticketsIDs,
    ]);
    $data = [];

    if (sizeof($lists) >= 1) {
        foreach ($lists as $tr) {
            $op1 = '<a class="btn btn-sm btn-info" target="_blank" href="' . JK_DOMAIN_LANG . 'cp/crm/tickets/view/' . $tr['id'] . '"><i class="fa fa-eye"></i></a>';
            if ($tr['owner'] != null) {
                $tr['owner'] = nickName($tr['owner']);
            }
            if ($tr['department'] != null) {
                $tr['department'] = \Joonika\Modules\Crm\ticketDepartmentName($tr['department']);
            }
            if ($tr['createdBy'] != null) {
                $tr['createdBy'] = nickName($tr['createdBy']);
            }
            if ($tr['createdOn'] != null) {
                $tr['createdOn'] = \Joonika\Idate\date_int("Y/m/d-H:i:s", $tr['createdOn']);
            }
            if ($tr['closedBy'] != null) {
                $tr['closedBy'] = nickName($tr['closedBy']);
            }
            if ($tr['closedOn'] != null) {
                $tr['closedOn'] = \Joonika\Idate\date_int("Y/m/d-H:i:s", $tr['closedOn']);
            }
            array_push($data, [
                "id" => $tr['id'],
                "title" => $tr['title'],
                "department" => $tr['department'],
                "owner" => $tr['owner'],
                "createdBy" => $tr['createdBy'],
                "createdOn" => $tr['createdOn'],
                "closedBy" => $tr['closedBy'],
                "closedOn" => $tr['closedOn'],
                "priority" => \Joonika\Modules\Crm\ticketPriority($tr['priority'], true),
                "status" => \Joonika\Modules\Crm\ticketStatus($tr['status'], true),
                "operation" => '<span class="btn-group">' . $op1 . '</span>',
            ]);
        }
    }

    echo datatable_view([
        "CountAll" => $countall,
        "list" => $lists,
        "data" => $data,
    ]);

}
