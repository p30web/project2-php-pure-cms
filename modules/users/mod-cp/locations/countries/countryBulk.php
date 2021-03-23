<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_locations_countries')) {
    error403();
    die;
}
global $View;
global $Route;
global $data;
global $database;
if (isset($_POST['title'])) {

    $countries = explode("\n", $_POST['title']);
    if (sizeof($countries) >= 1) {
        foreach ($countries as $country) {
            if ($country != "") {
	            $country=trim($country);
                $database->insert('jk_users_locations_countries', [
                ]);
                $id = $database->id();
                langDefineSet(JK_LANG, 'jk_users_locations_countries', 'id', $id, $country);
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
        "url" => JK_DOMAIN_LANG . 'cp/users/locations/countries/countryBulk',
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;