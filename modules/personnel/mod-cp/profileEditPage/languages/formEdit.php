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
        "url" => JK_DOMAIN_LANG . 'cp/personnel/profileEditPage/languages/formEdit',
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
        $database->update('personnel_languages', [
            "language" => $_POST['language'],
            "certHas" => $_POST['certHas'],
            "reading" => $_POST['reading'],
            "writing" => $_POST['writing'],
            "conversation" => $_POST['conversation'],
            "description" => $_POST['description'],
            "status" => "unconfirmed",
        ], [
            "id" => $_POST['id']
        ]);
    } else {
        $database->insert('personnel_languages', [
            "userID" => $_POST['userID'],
            "language" => $_POST['language'],
            "certHas" => $_POST['certHas'],
            "reading" => $_POST['reading'],
            "writing" => $_POST['writing'],
            "conversation" => $_POST['conversation'],
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
    $data = $database->get('personnel_languages', '*', [
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
                echo \Joonika\Forms\field_text(
                    [
                        "name" => "language",
                        "title" => __("language"),
                        "required" => true,
                        "ColType" => "12,12",
                    ]
                );
                echo div_close();


                echo div_start('col-12');
                echo \Joonika\Forms\field_select(
                    [
                        "name" => "reading",
                        "title" => __("reading"),
                        "required" => true,
                        "first" => true,
                        "ColType" => "12,12",
                        "array" => [
                            "1" => __("basics"),
                            "3" => __("intermediate"),
                            "5" => __("professional"),
                        ],
                    ]
                );
                echo div_close();
                echo div_start('col-12');
                echo \Joonika\Forms\field_select(
                    [
                        "name" => "writing",
                        "title" => __("writing"),
                        "required" => true,
                        "first" => true,
                        "ColType" => "12,12",
                        "array" => [
                            "1" => __("basics"),
                            "3" => __("intermediate"),
                            "5" => __("professional"),
                        ],
                    ]
                );
                echo div_close();
                echo div_start('col-12');
                echo \Joonika\Forms\field_select(
                    [
                        "name" => "conversation",
                        "title" => __("conversation"),
                        "required" => true,
                        "first" => true,
                        "ColType" => "12,12",
                        "array" => [
                            "1" => __("basics"),
                            "3" => __("intermediate"),
                            "5" => __("professional"),
                        ],
                    ]
                );
                echo div_close();
                echo div_start('col-12');
                echo \Joonika\Forms\field_select(
                    [
                        "name" => "certHas",
                        "title" => __("has certification ?"),
                        "required" => true,
                        "first" => true,
                        "ColType" => "12,12",
                        "array" => [
                            "0" => __("no"),
                            "1" => __("yes"),
                        ],
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