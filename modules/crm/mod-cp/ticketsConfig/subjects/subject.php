<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets_config')) {
    error403();
    die;
}
global $View;
global $Route;
global $data;
if(isset($Route->path[4])){
    $data['country']=$Route->path[4];
    $countryID=$Route->path[4];
}else{
    $countryID=0;
}
if(isset($_POST['title']) && !isset($_POST['id'])){
    global $Route;
    global $database;
    $database->insert('crm_tickets_subjects',[
        "module"=>$countryID
    ]);
    $id=$database->id();
    langDefineSet(JK_LANG,'crm_tickets_subjects','id',$id,$_POST['title']);

    echo redirect_to_js();
}

\Joonika\Forms\form_create([
    "id"=>"EditFrom"
]);
if(isset($_POST['id'])){
    global $database;
    $group=$database->get('crm_tickets_subjects','*',[
            "id"=>$_POST['id'],
    ]);
    if(isset($group['id'])){
        $data['title']=langDefineGet(JK_LANG,'crm_tickets_subjects','id',$group['id']);
        echo \Joonika\Forms\field_hidden([
            "name"=>"id",
            "value"=>$_POST['id'],
        ]);
        if(isset($_POST['title'])){
            langDefineSet(JK_LANG,'crm_tickets_subjects','id',$group['id'],$_POST['title']);
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
        "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/subjects/subject/'.$countryID,
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;