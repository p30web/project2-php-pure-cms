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
if (isset($_POST['saveform']) && !isset($_POST['id'])) {

    $database->insert('jk_emailTemplate', [
        "name" => $_POST['name'],
        "text" => $_POST['text'],
        "lang" => JK_LANG,
    ]);
    echo redirect_to_js();
}

\Joonika\Forms\form_create([
    "id" => "EditFrom",
]);
if (isset($_POST['id']) && $_POST['id'] != '') {
    $tpl = $database->get('jk_emailTemplate', '*', [
        "id" => $_POST['id'],
    ]);
    if (isset($tpl['id'])) {
        global $data;
        $data = $tpl;
        echo \Joonika\Forms\field_hidden([
            "name" => "id",
            "value" => $_POST['id'],
        ]);
        if (isset($_POST['saveform'])) {
            $database->update('jk_emailTemplate', [
                "name" => $_POST['name'],
                "text" => $_POST['text'],
            ], [
                "id" => $_POST['id']
            ]);
            echo redirect_to_js();
        }
    }
}
?>
    <div class="row">
        <?php
        global $data;
        echo \Joonika\Forms\field_hidden([
            "name" => "saveform",
            "value" => 1,
        ]);
        echo div_start('col-12');
        echo \Joonika\Forms\field_text(
            [
                "name" => "name",
                "direction" => "ltr",
                "title" => __("name"),
                "required" => true,
                "ColType" => "12,12",
            ]
        );
        echo div_close();
        echo div_start('col-12');
        echo \Joonika\Forms\field_editor(
            [
                "name" => "text",
                "title" => __("text"),
                "required" => true,
                "ColType" => "12,12",
            ]
        );
        echo div_close();

        ?>
    </div>
<?php
echo \Joonika\Forms\field_submit([
    "text" => __("save"),
    "ColType" => "12,12",
    "btn-class" => "btn btn-primary btn-lg btn-block",
    "icon" => "fa fa-save"
]);

\Joonika\Forms\form_end();

$View->footer_js('<script>
' . ajax_validate([
        "on" => "submit",
        "formID" => "EditFrom",
        "ckeditor" => true,
        "url" => JK_DOMAIN_LANG . 'cp/main/mailConfig/edit',
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;