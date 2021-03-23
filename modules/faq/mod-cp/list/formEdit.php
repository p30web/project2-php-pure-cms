<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('faq_list')) {
    error403();
    die;
}
global $View;
if(isset($_POST['title']) && (!isset($_POST['id']) || $_POST['id']=="")){
    global $Route;
    global $database;
    $database->insert('faq_categories',[
        "title"=>$_POST['title'],
    ]);
    echo redirect_to_js();
}

\Joonika\Forms\form_create([
    "id"=>"EditFrom"
]);
if(isset($_POST['id']) && $_POST['id']!=""){
    global $database;
    $get=$database->get('faq_categories','*',[
        "id"=>$_POST['id'],
    ]);

    if(isset($get['id'])){
        global $data;
        $data['title']=$get['title'];
        if(isset($_POST['title'])){
            $database->update('faq_categories',[
                "title"=>$_POST['title'],
            ],[
                "id"=>$get['id'],
            ]);
            $data['title']=$_POST['title'];
            echo redirect_to_js();
        }
    }
}
echo \Joonika\Forms\field_hidden([
    "name"=>"id",
    "value"=>$_POST['id'],
]);
echo '<div class="row">';
echo '<div class="col-12">';
echo \Joonika\Forms\field_text(
    [
        "name"=>"title",
        "title"=>__("title"),
        "required"=>true,
        "ColType"=>"12,12",
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
        "formID" => "EditFrom",
        "url" => JK_DOMAIN_LANG . 'cp/faq/list/formEdit',
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;