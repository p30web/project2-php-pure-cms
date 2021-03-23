<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_information')) {
    error403();
    die;
}
global $View;
global $Users;
global $Route;
global $database;
global $Cp;
$Cp->setSidebarActive('personnel/information');
$View->footer_js('
<script>
' . ajax_load([
        "on" => "submit",
        "formID" => "search_personnel",
        "url" => JK_DOMAIN_LANG . 'cp/personnel/information/search',
        "success_response" => "#searchBody",
        "loading" => [
            "elem" => "span",
            "iclass-size" => "1",
        ]
    ]) . '
    $("#search_personnel").submit();
</script>
');

$View->head();

\Joonika\Forms\form_create([
    "id"=>"search_personnel"
]);
?>
    <div class="card card-body">
        <div class="row">
        <?php

        echo '<div class="col-md-4">';
        echo \Joonika\Forms\field_text([
            "name"=>"search",
            "title"=>__("search"),
            "ColType"=>"12,12",
        ]);
        echo '</div>';

        echo '<div class="col-md-4">';
        echo \Joonika\Forms\field_submit([
            "text"=>'<i class="fa fa-search"></i> '.__("search"),
            "ColType"=>"12,12",
        ]);
        echo '</div>';

        ?>
    </div>
    </div>
<?php
\Joonika\Forms\form_end();
?>
    <div class="row" id="searchBody">
    </div>
<?php
$View->foot();