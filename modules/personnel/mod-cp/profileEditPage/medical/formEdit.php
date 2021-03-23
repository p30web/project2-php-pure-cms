<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_info_edit')) {
    error403();
    die;
}
global $View;
global $database;
$View->footer_js('<script>
' . ajax_validate([
        "on" => "submit",
        "formID" => "form_edit",
        "url" => JK_DOMAIN_LANG . 'cp/personnel/profileEditPage/medical/formEdit',
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>')
?>
<?php

$userid = $_POST['userID'];
new \Joonika\Modules\Personnel\Personnel();
$person = \Joonika\Modules\Personnel\personnelDetails($userid);
if (isset($_POST['formSave'])) {
    $database->update('personnel_details', [
        "weight" => $_POST['weight'],
        "height" => $_POST['height'],
        "bloodType" => $_POST['bloodType'],
    ], [
        "id" => $person['id']
    ]);
    echo alertSuccess(__("done"));
}
\Joonika\Forms\form_create([
    "id" => 'form_edit'
]);
echo \Joonika\Forms\field_hidden([
    "name" => "formSave",
    "value" => 1
]);
echo \Joonika\Forms\field_hidden([
    "name" => "userID",
    "value" => $_POST['userID']
]);
?>
    <div class="row">
        <?php
        $person = \Joonika\Modules\Personnel\personnelDetails($userid);
        global $data;
        $data = $person;

        echo div_start('col-6');
        echo \Joonika\Forms\field_text(
            [
                "name" => "weight",
                "title" => __("body weight"),
                "required" => true,
                "direction" => "ltr",
                "ColType" => "12,12",
            ]
        );
        echo div_close();

        echo div_start('col-6');
        echo \Joonika\Forms\field_text(
            [
                "name" => "height",
                "direction" => "ltr",
                "required" => true,
                "title" => __("body height"),
                "ColType" => "12,12",
            ]
        );
        echo div_close();

        echo div_start('col-6');
        echo \Joonika\Forms\field_text(
            [
                "name" => "bloodType",
                "direction" => "ltr",
                "required" => true,
                "title" => __("blood type"),
                "ColType" => "12,12",
            ]
        );
        echo div_close();


        echo \Joonika\Forms\field_submit([
            "text" => __("save"),
            "ColType" => "12,12",
            "btn-class" => "btn btn-primary btn-lg btn-block",
            "icon" => "fa fa-save"
        ]);
        \Joonika\Forms\form_end();
        ?>
        <div id="action_body"></div>
    </div>
<?php
echo $View->getFooterJsFiles();
echo $View->footer_js;