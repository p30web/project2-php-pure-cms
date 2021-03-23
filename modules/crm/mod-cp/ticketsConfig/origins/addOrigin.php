<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
global $View;
$Users->loggedCheck();
if (!$ACL->hasPermission('crm_tickets_config')) {
    error403();
    die;
}
$continue = true;

if ($continue) {
    new \Joonika\Modules\Crm\Crm();
    if (isset($_POST['origin'])) {
        global $database;
        $has=$database->get('crm_tickets_origins_title','*',[
            "name"=>$_POST['origin']
        ]);
        if(isset($has['id'])){
            if($has['status']!="active"){
                $database->update('crm_tickets_origins_title',[
                    "status"=>"active"
                ],[
                    "id"=>$has['id']
                ]);
            }else{
                $database->insert('crm_tickets_origins_title',[
                    "name"=>$_POST['origin']
                ]);
            }
        }else{
            $database->insert('crm_tickets_origins_title',[
                "name"=>$_POST['origin']
            ]);
        }
        echo redirect_to_js();
    }
    echo \Joonika\Forms\form_create([
        'id' => "addOriginForm"
    ]);
    echo '<div class="col-12">';
    echo \Joonika\Forms\field_text(
        [
            "name" => "origin",
            "title" => __("origin"),
            "required" => true,
            "ColType" => "12,12",
        ]
    );
    echo '</div>';
    echo \Joonika\Forms\field_submit(
        [
            "text" => __("add"),
            "ColType" => "12,12",
            "btn-class" => "btn btn-primary btn-lg btn-block",
            "icon" => "fa fa-save"
        ]
    );
    echo \Joonika\Forms\form_end();

    $View->footer_js('<script>
' . ajax_validate([
            "on" => "submit",
            "formID" => "addOriginForm",
            "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/origins/addOrigin',
            "success_response" => "#modal_global_body",
            "loading" => ['iclass-size' => 1, 'elem' => 'span']
        ]) . '
</script>');

    echo $View->footer_js;
}