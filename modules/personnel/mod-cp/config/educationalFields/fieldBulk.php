<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_config_educational_fields')) {
    error403();
    die;
}
global $View;
global $Route;
global $data;
global $database;
if(isset($Route->path[4])){
    $data['cat']=$Route->path[4];
    $catID=$Route->path[4];
}else{
    $catID=0;
}
if (isset($_POST['title'])) {

    $fields = explode("\n", $_POST['title']);
    if (sizeof($fields) >= 1) {
        foreach ($fields as $field) {
            if ($field != "") {
                $database->insert('personnel_fields', [
                    "module" => $_POST['cat'],
                ]);
                $id = $database->id();
                langDefineSet(JK_LANG, 'personnel_fields', 'id', $id, $field);

            }

        }
    }
    echo redirect_to_js();

}

\Joonika\Forms\form_create([
    "id" => "EditFrom"
]);
echo '<div class="row">';
echo '<div class="col-12">';
$catsdb = $database->select('personnel_fields_cats', "id", [
    "status" => "active",
    "ORDER" => ["sort" => "ASC"]
]);
$cats = [];
if (sizeof($catsdb) >= 1) {
    foreach ($catsdb as $catdb) {
        $cats[$catdb] = langDefineGet(JK_LANG, 'personnel_fields_cats', 'id', $catdb);
    }
}
echo \Joonika\Forms\field_select(
    [
        "name" => "cat",
        "title" => __("set"),
        "required" => true,
        "array" => $cats,
        "ColType" => "12,12",
    ]
);
echo '</div>';

echo '<div class="col-12">';
echo \Joonika\Forms\field_textarea(
    [
        "name" => "title",
        "title" => __("title"),
        "required" => true,
        "ColType" => "12,12",
    ]
);
echo '</div>';

echo '</div>';

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
        "url" => JK_DOMAIN_LANG . 'cp/personnel/config/educationalFields/fieldBulk/'.$catID,
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;