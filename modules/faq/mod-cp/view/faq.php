<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('faq_list')) {
    error403();
    die;
}
global $View;
global $Route;
global $data;
if(isset($Route->path[3])){
    $data['country']=$Route->path[3];
    $varPageID=$Route->path[3];
}else{
    $varPageID=0;
}

if(isset($_POST['title']) && !isset($_POST['id'])){
    global $Route;
    global $database;
    $database->insert('faq_list',[
        "module"=>$varPageID,
        "title"=>$_POST['title'],
        "answer"=>$_POST['answer'],
    ]);
    echo redirect_to_js();
}

\Joonika\Forms\form_create([
    "id"=>"EditFrom"
]);

if(isset($_POST['id'])){
    global $database;
    $group=$database->get('faq_list','*',[
            "id"=>$_POST['id'],
    ]);
    if(isset($group['id'])){
        echo \Joonika\Forms\field_hidden([
            "name"=>"id",
            "value"=>$_POST['id'],
        ]);
        $data=$group;
        if(isset($_POST['title'])){
        $database->update('faq_list',[
            "title"=>$_POST['title'],
            "answer"=>$_POST['answer'],
        ],[
            "id"=>$_POST['id']
        ]);
            echo redirect_to_js();
        }
    }
}

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
echo '<div class="col-12">';
echo \Joonika\Forms\field_text(
    [
        "name"=>"answer",
        "title"=>__("answer"),
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
        "url" => JK_DOMAIN_LANG . 'cp/faq/view/faq/'.$varPageID,
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;