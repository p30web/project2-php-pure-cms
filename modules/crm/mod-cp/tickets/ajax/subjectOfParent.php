<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets')) {
    error403();
    die;
}

            if (isset($_POST['parentSubject']) ) {
                global $View;
                new \Joonika\Modules\Crm\Crm();
                if($_POST['parentSubject']==""){
                    $getTitle=true;
                }else{
                    $getTitle=false;
                }
                $subjects = \Joonika\Modules\Crm\ticketSubjects($_POST['parentSubject'],$getTitle);
                echo \Joonika\Forms\field_select([
                    "name" => "subject",
                    "title" => __("subject"),
                    "ColType" => "12,12",
                    "first" => true,
                    "required" => true,
                    "array" => $subjects,
                ]);
                $View->footer_js('<script>
    $("#subject").on("change",function() {
       ' . ajax_load([
                        "url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/subjectSelectParent',
                        "success_response" => "#action_body",
                        "loading" => [
                        ]
                    ]) . '
    });
    </script>');
                echo $View->footer_js;
            }


