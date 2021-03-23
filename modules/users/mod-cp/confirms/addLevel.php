<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
global $View;
$Users->loggedCheck();
if (!$ACL->hasPermission('users_confirms')) {
    error403();
    die;
}
$continue = true;
if (!isset($_POST['id']) || !isset($_POST['level'])) {
    $continue = false;
}

if ($continue) {
    if (isset($_POST['corroborant'])) {
        if ($_POST['corroborant'] != JK_LOGINID) {
            global $database;
            $has=$database->has("jk_users_confirms_corroborant",[
                    "AND"=>[
                            "cID"=>$_POST['id'],
                            "corroborant"=>$_POST['corroborant'],
                            "status"=>"active",
                    ]
            ]);
            if(!$has){
                $database->insert("jk_users_confirms_corroborant",[
                    "cID"=>$_POST['id'],
                        "corroborant"=>$_POST['corroborant'],
                        "level"=>$_POST['level'],
                        "datetime"=>date("Y/m/d H:i:s"),
                        "status"=>"active",
                ]);
                alertSuccess(__("added"));
            }else{
                alertDanger(__("added before"));
            }
        }else{
            alertDanger(__("you can't add yourself"));
        }
    }
    ?>
    <table class="table table-sm responsive small">
        <thead>
        <tr>
            <th><?php echo __("title"); ?></th>
            <th><?php echo __("level"); ?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?php echo langDefineGet(JK_LANG,'jk_users_confirms','id',$_POST['id']); ?></td>
            <td><?php echo $_POST['level']; ?></td>
        </tr>
        </tbody>
    </table>
    <?php
    echo \Joonika\Forms\form_create([
        'id' => "addLevel"
    ]);
    echo \Joonika\Forms\field_hidden([
        "name" => "id",
        "value" => $_POST['id'],
    ]);
    echo \Joonika\Forms\field_hidden([
        "name" => "level",
        "value" => $_POST['level'],
    ]);
    echo '<div class="col-12">';
    $users = \Joonika\Modules\Users\usersArray();
    echo \Joonika\Forms\field_select(
        [
            "name" => "corroborant",
            "title" => __("corroborant"),
            "first" => true,
            "required" => true,
            "array" => $users,
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
            "formID" => "addLevel",
            "url" => JK_DOMAIN_LANG . "cp/users/confirms/addLevel",
            "success_response" => "#modal_global_body",
            "loading" => ['iclass-size' => 1, 'elem' => 'span']
        ]) . '
</script>');

    echo $View->footer_js;
}