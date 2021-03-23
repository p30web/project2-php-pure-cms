<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('cp_mailConfig')) {
    error403();
    die;
}
global $View;
global $Route;
global $database;

\Joonika\Forms\form_create([
    "id" => "smtpSetting",
    "class" => "row",
]);

if (isset($_POST['server'])) {
    if (isset($_POST['id']) && $_POST['id'] != '') {
        $data = $database->get('jk_emails', '*', [
            "id" => $_POST['id']
        ]);
        if (isset($data['id'])) {
            $database->update('jk_emails', [
                "server"=>$_POST['server'],
                "email"=>$_POST['email'],
                "username"=>$_POST['username'],
                "password"=>$_POST['password'],
                "port"=>$_POST['port'],
                "secureType"=>$_POST['secureType'],
                "fromName"=>$_POST['fromName'],
                "debug"=>$_POST['debug'],
            ], [
                "id" => $data['id']
            ]);
        }
    }else{
        $database->insert('jk_emails', [
            "server"=>$_POST['server'],
            "email"=>$_POST['email'],
            "username"=>$_POST['username'],
            "password"=>$_POST['password'],
            "port"=>$_POST['port'],
            "secureType"=>$_POST['secureType'],
            "fromName"=>$_POST['fromName'],
            "debug"=>$_POST['debug'],
        ]);
    }
    echo redirect_to_js();
}
global $data;
if (isset($_POST['id']) && $_POST['id'] != '') {
    $data = $database->get('jk_emails', '*', [
        "id" => $_POST['id']
    ]);
}
echo \Joonika\Forms\field_hidden([
    "name" => "id",
    "value" => $_POST['id'],
]);
?>
    <div class="col-md-12 row">
        <?php
        echo '<div class="col-md-3">';
        echo \Joonika\Forms\field_text([
            "name" => "server",
            "required" => true,
            "title" => __("SMTP mail server"),
            "ColType" => "12,12",
            "direction" => "ltr",
        ]);
        echo '</div>';
        echo '<div class="col-md-3">';
        echo \Joonika\Forms\field_text([
            "name" => "port",
            "required" => true,
            "title" => __("SMTP mail port"),
            "ColType" => "12,12",
            "direction" => "ltr",
        ]);
        echo '</div>';
        echo '<div class="col-md-3">';
        echo \Joonika\Forms\field_text([
            "name" => "username",
            "required" => true,
            "title" => __("SMTP username"),
            "ColType" => "12,12",
            "direction" => "ltr",
        ]);
        echo '</div>';
        echo '<div class="col-md-3">';
        echo \Joonika\Forms\field_text([
            "name" => "password",
            "type" => "password",
            "required" => true,
            "title" => __("SMTP password"),
            "ColType" => "12,12",
            "direction" => "ltr",
        ]);
        echo '</div>';
        echo '<div class="col-md-3">';
        echo \Joonika\Forms\field_text([
            "name" => "email",
            "title" => __("email"),
            "direction" => "ltr",
            "required" => true,
            "ColType" => "12,12",
        ]);
        echo '</div>';
        echo '<div class="col-md-3">';
        $SMTPSecures = [
            "" => "none",
            "ssl" => "ssl",
            "tls" => "tls",
        ];
        echo \Joonika\Forms\field_select([
            "name" => "secureType",
            "title" => __("SMTP Secure"),
            "ColType" => "12,12",
            "array" => $SMTPSecures,
        ]);
        echo '</div>';
        echo '<div class="col-md-3">';
        echo \Joonika\Forms\field_text([
            "name" => "fromName",
            "title" => __("SMTP from name"),
            "ColType" => "12,12",
            "direction" => "ltr",
            "required" => true,
        ]);
        echo '</div>';
        echo '<div class="col-md-3">';
        echo \Joonika\Forms\field_select([
            "name" => "debug",
            "title" => __("SMTP debug"),
            "ColType" => "12,12",
            "array" => [0, 1, 2, 3],
        ]);
        echo '</div>';
        echo \Joonika\Forms\field_submit([
            "text" => __("save"),
            "btn-class" => "btn btn-primary btn-lg",
            "icon" => "fa fa-save"
        ]);
        ?>
    </div>
<?php
\Joonika\Forms\form_end();

$View->footer_js('<script>
      ' . ajax_validate([
        "on" => "submit",
        "formID" => "smtpSetting",
        "url" => JK_DOMAIN_LANG . 'cp/main/mailConfig/editMail',
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;