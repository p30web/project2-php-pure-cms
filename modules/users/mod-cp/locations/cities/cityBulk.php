<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_locations_cities')) {
    error403();
    die;
}
global $View;
global $Route;
global $data;
global $database;
if(isset($Route->path[4])){
    $data['province']=$Route->path[4];
    $provinceID=$Route->path[4];
}else{
    $provinceID=0;
}
if (isset($_POST['title'])) {

    $cities = explode("\n", $_POST['title']);
    if (sizeof($cities) >= 1) {
        foreach ($cities as $city) {
            if ($city != "") {
                $database->insert('jk_users_locations_cities', [
                    "module" => $_POST['province'],
                ]);
                $id = $database->id();
                langDefineSet(JK_LANG, 'jk_users_locations_cities', 'id', $id, $city);

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
$provincesdb = $database->select('jk_users_locations_provinces', "id", [
    "status" => "active",
    "ORDER" => ["sort" => "ASC"]
]);
$provinces = [];
if (sizeof($provincesdb) >= 1) {
    foreach ($provincesdb as $prdb) {
        $provinces[$prdb] = langDefineGet(JK_LANG, 'jk_users_locations_provinces', 'id', $prdb);
    }
}
echo \Joonika\Forms\field_select(
    [
        "name" => "province",
        "title" => __("province"),
        "required" => true,
        "array" => $provinces,
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
        "url" => JK_DOMAIN_LANG . 'cp/users/locations/cities/cityBulk/'.$provinceID,
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;