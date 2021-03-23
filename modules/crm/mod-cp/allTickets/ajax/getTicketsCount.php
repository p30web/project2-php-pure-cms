<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets_all')) {
    error403();
    die;
}
global $View;
global $database;
        $CountsOpenGeneral=$database->count('crm_tickets',[
            "AND"=>[
                "status[!]"=>"closed",
                "global"=>"1",
            ]
        ]);
            $CountsOpen=$database->count('crm_tickets',[
                    "status"=>["open","new"],
            ]);
$CountsAll=$database->count('crm_tickets',[
            ]);

$View->footer_js('<script>
if($("#types_allTickets_flag").length){
    $("#types_allTickets_flag").html("<span class=\'badge badge-pill badge-secondary\'>'.$CountsAll.'</span>");
}
if($("#types_openTickets_flag").length){
    $("#types_openTickets_flag").html("<span class=\'badge badge-pill badge-secondary\' style=\'background-color:#191970\'>'.$CountsOpen.'</span>");
}
if($("#types_openGeneralTickets_flag").length){
    $("#types_openGeneralTickets_flag").html("<span class=\'badge badge-pill badge-info\'>'.$CountsOpenGeneral.'</span>");
}
</script>');
echo $View->footer_js;
