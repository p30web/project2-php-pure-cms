<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets_all')) {
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
    $ticketIDs=[];
$types=[];
    if(isset($_GET['types'])){
        $typeTxt=$_GET['types'];
        if($typeTxt=="openGeneral"){
            $ticketIDs=$database->select('crm_tickets',"id",[
                "AND"=>[
                    "status[!]"=>"closed",
                    "global"=>"1",
                ]
            ]);
        }else{

            if($typeTxt=="open"){
                $ticketIDs=$database->select('crm_tickets',"id",[
                        "status"=>["open","new"],
                ]);
            }elseif($typeTxt=="all"){
                $ticketIDs=$database->select('crm_tickets',"id",[
                ]);
            }
        }
    }
        if ($getopt['search'] != '') {
            $ticketIDs = $database->select('crm_tickets', 'id', [
                "AND" => [
                    "OR"=>[
                        "title[~]" => $getopt['search'],
                        "id" => $getopt['search'],
                    ],
                    "id"=>$ticketIDs
                ],
            ]);
        }
        if(sizeof($ticketIDs)==0){
            $ticketIDs=0;
        }

    $countall = $database->count('crm_tickets', [
        "id"=>$ticketIDs
    ]);
    $lists = $database->select('crm_tickets', '*', [
        "id"=>$ticketIDs,
        "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
        "LIMIT" => [$getopt['start'], $getopt['length']]
    ]);
    $data = [];

    if (sizeof($lists) >= 1) {
        foreach ($lists as $tr) {
            $op1='<a class="btn btn-sm btn-info" target="_blank" href="'.JK_DOMAIN_LANG.'cp/crm/tickets/view/'.$tr['id'].'"><i class="fa fa-eye"></i></a>';
            if($tr['owner']!=null){
                $tr['owner']=nickName($tr['owner']);
            }
            if($tr['department']!=null){
                $tr['department']=\Joonika\Modules\Crm\ticketDepartmentName($tr['department']);
            }
            if($tr['createdBy']!=null){
                $tr['createdBy']=nickName($tr['createdBy']);
            }
            if($tr['createdOn']!=null){
                $tr['createdOn']=\Joonika\Idate\date_int("Y/m/d-H:i:s",$tr['createdOn']);
            }
            if($tr['closedBy']!=null){
                $tr['closedBy']=nickName($tr['closedBy']);
            }
            if($tr['closedOn']!=null){
                $tr['closedOn']=\Joonika\Idate\date_int("Y/m/d-H:i:s",$tr['closedOn']);
            }
            array_push($data, [
                "id"=>$tr['id'],
//                "id"=>print_r($_GET,true),
                "title"=>\Joonika\Modules\Crm\ticketsParentSubjectTitle($tr['parentSubject']).' + '.\Joonika\Modules\Crm\ticketsSubjectTitle($tr['subject']).' + '.$tr['title'],
                "department"=>$tr['department'],
                "owner"=>$tr['owner'],
                "createdBy"=>$tr['createdBy'],
                "createdOn"=>$tr['createdOn'],
                "closedBy"=>$tr['closedBy'],
                "closedOn"=>$tr['closedOn'],
                "priority"=>\Joonika\Modules\Crm\ticketPriority($tr['priority'],true),
                "status"=>\Joonika\Modules\Crm\ticketStatus($tr['status'],true),
                "operation" => '<span class="btn-group">'.$op1.'</span>',
            ]);
        }
    }

    echo datatable_view([
        "CountAll" => $countall,
        "list" => $lists,
        "data" => $data,
    ]);

}
