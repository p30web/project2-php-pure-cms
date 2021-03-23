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
if (!isset($_POST['userID']) || !isset($_POST['subjectID'])) {
    $continue = false;
}

if ($continue) {
    new \Joonika\Modules\Crm\Crm();
    if (isset($_POST['confirmID'])) {
            global $database;
            $has=$database->has("crm_tickets_confirmations",[
                    "AND"=>[
                            "confirmID"=>$_POST['confirmID'],
                            "userID"=>$_POST['userID'],
                            "subjectID"=>$_POST['subjectID'],
                            "status"=>"active",
                    ]
            ]);
            if(!$has){
                $database->insert("crm_tickets_confirmations",[
                    "confirmID"=>$_POST['confirmID'],
                    "userID"=>$_POST['userID'],
                    "subjectID"=>$_POST['subjectID'],
                    "status"=>"active",
                ]);
                echo alertSuccess(__("added"));
            }else{
                echo alertDanger(__("added before"));
            }
    }
    ?>
    <table class="table table-sm responsive small">
        <thead>
        <tr>
            <th><?php echo __("user"); ?></th>
            <th><?php echo __("subject"); ?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?php echo nickName($_POST['userID']); ?></td>
            <td><?php echo \Joonika\Modules\Crm\ticketsSubjectTitle($_POST['subjectID']); ?></td>
        </tr>
        </tbody>
    </table>
    <?php
    echo \Joonika\Forms\form_create([
        'id' => "addConfirm"
    ]);
    echo \Joonika\Forms\field_hidden([
        "name" => "subjectID",
        "value" => $_POST['subjectID'],
    ]);
    echo \Joonika\Forms\field_hidden([
        "name" => "userID",
        "value" => $_POST['userID'],
    ]);
    echo '<div class="col-12">';
    $corroborants = \Joonika\Modules\Crm\ticketsConfirmationsList();
    echo \Joonika\Forms\field_select(
        [
            "name" => "confirmID",
            "title" => __("corroborant"),
            "first" => true,
            "required" => true,
            "array" => $corroborants,
            "ColType" => "12,12",
        ]
    );
    echo '</div>';
    echo \Joonika\Forms\field_submit(
        [
            "text" => __("assign"),
            "ColType" => "12,12",
            "btn-class" => "btn btn-primary btn-lg btn-block",
            "icon" => "fa fa-save"
        ]
    );
    echo \Joonika\Forms\form_end();

    $View->footer_js('<script>
' . ajax_validate([
            "on" => "submit",
            "formID" => "addConfirm",
            "url" => JK_DOMAIN_LANG . "cp/crm/ticketsConfig/confirmations/addLevel",
            "success_response" => "#modal_global_body",
            "loading" => ['iclass-size' => 1, 'elem' => 'span']
        ]) . '
</script>');

    echo $View->footer_js;
}