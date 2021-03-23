<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('smsir_list')) {
    error403();
    die;
}
global $View;
if(isset($_POST['title']) && (!isset($_POST['id']) || $_POST['id']=="")){
    global $Route;
    global $database;
    $database->insert('smsir_temps',[
        "templateID"=>$_POST['templateID'],
        "vars"=>$_POST['vars']
    ]);
    $id=$database->id();
    langDefineSet(JK_LANG,'smsir_temps','id',$id,$_POST['title']);
    echo redirect_to_js();
}

\Joonika\Forms\form_create([
    "id"=>"EditFrom"
]);
if(isset($_POST['id']) && $_POST['id']!=""){
    global $database;
    $get=$database->get('smsir_temps','*',[
        "id"=>$_POST['id'],
    ]);

    if(isset($get['id'])){
        global $data;
        $data['title']=langDefineGet(JK_LANG,'smsir_temps','id',$get['id']);
        $data['templateID']=$get['templateID'];
        $data['vars']=$get['vars'];
        if(isset($_POST['title'])){
            $database->update('smsir_temps',[
                "templateID"=>$_POST['templateID'],
                "vars"=>$_POST['vars']
            ],[
                "id"=>$get['id'],
            ]);
            langDefineSet(JK_LANG,'smsir_temps','id',$get['id'],$_POST['title']);
            $data['title']=$_POST['title'];
            $data['templateID']=$_POST['templateID'];
            $data['vars']=$_POST['vars'];
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
echo '<div class="col-12">';
echo \Joonika\Forms\field_text(
    [
        "name"=>"templateID",
        "title"=>__("template id"),
        "required"=>true,
        "direction"=>"ltr",
        "ColType"=>"12,12",
    ]
);
echo '</div>';
echo '<div class="col-12">';
echo \Joonika\Forms\field_text(
    [
        "name"=>"vars",
        "title"=>__("variables"),
        "required"=>false,
        "help"=>"downloadURL=dl.com&code&...",
        "direction"=>"ltr",
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
        "url" => JK_DOMAIN_LANG . 'cp/smsir/list/formEdit',
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;