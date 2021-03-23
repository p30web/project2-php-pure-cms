<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('cp_siteSetting')) {
    error403();
    die;
}
global $View;
if(isset($_POST['width']) && isset($_POST['height']) && !isset($_POST['id'])){
    global $Route;
    global $database;
    $database->insert('jk_thumbnails',[
        "websiteID"=>$Route->websiteID,
        "name"=>$_POST['name'],
        "width"=>$_POST['width'],
        "height"=>$_POST['height'],
    ]);
    $id=$database->id();
    $getth=$database->get('jk_thumbnails','*',[
        "id"=>$id
    ]);
    $View->footer_js('<script>
    $("#thumbnail_body").append(\'<div class="col-4" id="thumbnail_th_'.$id.'">\'+
                           \'<div class="card">\'+
                               \'<div class="card-header text-center">\'+
                                   \''.$getth['name'].' <button type="button" class="btn btn-light btn-xs" onclick="edit_thumbnail('.$getth['id'].')"><i class="fa fa-edit"></i></button>\'+
                               \'</div>\'+
                               \'<div class="card-body row">\'+
                                   \'<div class="col-6">\'+
                                       \'<i class="fa fa-arrows-alt-v"></i>\'+
                                       \''.__("height").'\'+
                                       \''.$getth['height'].'px\'+
                                   \'</div>\'+
                                   \'<div class="col-6">\'+
                                       \'<i class="fa fa-arrows-alt-h"></i>\'+
                                       \''.__("width").'\'+
                                       \''.$getth['width'].'px\'+
                                   \'</div>\'+
                               \'</div>\'+
                           \'</div>\'+
                           \'</div>\')
</script>');
}

\Joonika\Forms\form_create([
    "id"=>"thumbnailEditFrom"
]);
if(isset($_POST['id'])){
    global $database;
    $th=$database->get('jk_thumbnails','*',[
        "AND"=>[
            "id"=>$_POST['id'],
            "websiteID"=>JK_WEBSITE_ID
        ]
    ]);
    if(isset($th['id'])){
        global $data;
        global $database;
        $data=$th;
        echo \Joonika\Forms\field_hidden([
            "name"=>"id",
        ]);
        if(isset($_POST['width'])){
            $database->update('jk_thumbnails',[
                "name"=>$_POST['name'],
                "width"=>$_POST['width'],
                "height"=>$_POST['height'],
            ],[
                "id"=>$th['id']
            ]);

            $th=$database->get('jk_thumbnails','*',[
                "AND"=>[
                    "id"=>$th['id'],
                    "websiteID"=>JK_WEBSITE_ID
                ]
            ]);
            $data=$th;

            $View->footer_js( '<script>
    $("#thumbnail_th_'.$th['id'].'").html(\'<div class="card">\'+
                               \'<div class="card-header text-center">\'+
                                   \''.$th['name'].' <button type="button" class="btn btn-light btn-xs" onclick="edit_thumbnail('.$th['id'].')"><i class="fa fa-edit"></i></button>\'+
                               \'</div>\'+
                               \'<div class="card-body row">\'+
                                   \'<div class="col-6">\'+
                                       \'<i class="fa fa-arrows-alt-v"></i>\'+
                                       \''.__("height").'\'+
                                       \''.$th['height'].'px\'+
                                   \'</div>\'+
                                   \'<div class="col-6">\'+
                                       \'<i class="fa fa-arrows-alt-h"></i>\'+
                                       \''.__("width").'\'+
                                       \''.$th['width'].'px\'+
                                   \'</div>\'+
                               \'</div>\'+
                           \'</div>\')
</script>');
        }
    }
}

echo '<div class="row">';
echo '<div class="col-12">';
echo \Joonika\Forms\field_text(
    [
        "name"=>"name",
        "placeholder"=>"th1",
        "title"=>__("name"),
        "direction"=>"ltr",
        "required"=>true,
        "ColType"=>"12,12",
        "help"=>__("use th{number} for better performance").'-'.__("for example").' : th1'
    ]
);
echo '</div>';
echo '<div class="col-6">';
echo \Joonika\Forms\field_text(
    [
        "name"=>"width",
        "placeholder"=>"px",
        "title"=>__("width"),
        "direction"=>"ltr",
        "required"=>true,
        "ColType"=>"12,12",
        "help"=>"px"
    ]
);
echo '</div>';
echo '<div class="col-6">';

echo \Joonika\Forms\field_text(
    [
        "name"=>"height",
        "placeholder"=>"px",
        "title"=>__("height"),
        "direction"=>"ltr",
        "required"=>true,
        "ColType"=>"12,12",
        "help"=>"px"
    ]
);
echo '</div>';
echo '</div>';

echo \Joonika\Forms\field_submit([
    "text"=>__("save"),
    "ColType"=>"12,12",
    "btn-class"=>"btn btn-primary btn-lg btn-block",
    "icon"=>"fa fa-save"
]);

\Joonika\Forms\form_end();

$View->footer_js('<script>
' . ajax_validate([
        "on" => "submit",
        "formID" => "thumbnailEditFrom",
        "url" => JK_DOMAIN_LANG . 'cp/main/siteSetting/thumbnailEdit',
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;