<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('blog_categories')) {
    error403();
    die;
}
global $View;

if (isset($_POST['title']) && !isset($_POST['id'])) {
    global $Route;
    global $database;
    $database->insert('jk_data', [
        "title" => $_POST['title'],
        "slug" => $_POST['slug'],
        "description" => $_POST['description'],
        "datetime" => date("Y/m/d H:i:s"),
        "datetime_s" => date("Y/m/d H:i:s"),
        "creatorID" => JK_LOGINID,
        "websiteID" => JK_WEBSITE_ID,
        "lang" => JK_LANG,
        "module" => "blog_category",
    ]);
    echo redirect_to_js();
}

\Joonika\Forms\form_create([
    "id" => "categoryEditFrom"
]);
if (isset($_POST['id'])) {
    global $database;
    global $data;
    $data = $database->get('jk_data', '*', [
        "id" => $_POST['id'],
    ]);
    if (isset($data['id'])) {
        echo \Joonika\Forms\field_hidden([
            "name" => "id",
            "value" => $_POST['id'],
        ]);
        if (isset($_POST['title'])) {
            $database->update('jk_data', [
                "title" => $_POST['title'],
                "slug" => $_POST['slug'],
                "description" => $_POST['description'],
            ],[
                    "id"=>$_POST['id']
            ]);
            echo redirect_to_js();
        }
    }
}
?>
    <div class="row">
        <?php
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
        echo \Joonika\Forms\field_text(
            [
                "name" => "slug",
                "title" => __("slug"),
                "direction" => "ltr",
                "required" => true,
                "ColType" => "12,12",
            ]
        );
        echo div_close();
        \Joonika\Forms\slugControl('title','slug');

        echo div_start('col-12');
        echo \Joonika\Forms\field_text(
            [
                "name" => "description",
                "title" => __("description"),
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
        "formID" => "categoryEditFrom",
        "url" => JK_DOMAIN_LANG . 'cp/blog/categories/category',
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;