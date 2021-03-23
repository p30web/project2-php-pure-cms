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
        "url" => JK_DOMAIN_LANG . 'cp/personnel/profileEditPage/skills/formEdit',
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
    if (isset($_POST['id']) && $_POST['id']!="") {
        $database->update('personnel_skills', [
            "type" => $_POST['type'],
            "title" => $_POST['title'],
            "description" => $_POST['description'],
            "status" => "unconfirmed",
        ], [
            "id" => $_POST['id']
        ]);
    } else {
        $database->insert('personnel_skills', [
            "userID" => $_POST['userID'],
            "type" => $_POST['type'],
            "title" => $_POST['title'],
            "description" => $_POST['description'],
        ]);
    }
    echo alertSuccess(__("done"));
}
\Joonika\Forms\form_create([
    "id" => 'form_edit'
]);
if (isset($_POST['id']) && $_POST['id']!="") {
    echo \Joonika\Forms\field_hidden([
        "name" => "id",
        "value" => $_POST['id']
    ]);
    global $data;
    $data = $database->get('personnel_skills', '*', [
        "id" => $_POST['id']
    ]);
}
echo \Joonika\Forms\field_hidden([
    "name" => "formSave",
    "value" => 1
]);
echo \Joonika\Forms\field_hidden([
    "name" => "userID",
    "value" => $_POST['userID']
]);
?>
    <div class="row <?php echo JK_DIRECTION; ?>">
        <div class="col-6 offset-3">
            <div class="row">
                <?php
                $person = \Joonika\Modules\Personnel\personnelDetails($userid);
                echo div_start('col-12');
                echo \Joonika\Forms\field_select(
                    [
                        "name" => "type",
                        "title" => __("type"),
                        "required" => true,
                        "first" => true,
                        "ColType" => "12,12",
                        "array" => [
                            "arts" => __("Artistic"),
                            "sports" => __("Sports"),
                            "skillful" => __("Skillful"),
                            "org" => __("Organizational"),
                        ],
                    ]
                );
                echo div_close();
                echo div_start('col-12');
                echo \Joonika\Forms\field_text(
                    [
                        "name" => "title",
                        "title" => __("title"),
                        "required" => true,
                        "ColType" => "12,12",
                    ]
                );
                echo div_close();

                echo div_start('col-12');
                echo \Joonika\Forms\field_textarea(
                    [
                        "name" => "description",
                        "title" => __("description"),
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
            </div>
        </div>

        <div id="action_body"></div>
    </div>
<?php
echo $View->getFooterJsFiles();
echo $View->footer_js;