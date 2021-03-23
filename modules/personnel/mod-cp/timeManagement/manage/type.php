<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_timeManagement_manage')) {
    error403();
    die;
}
global $View;
if(isset($_POST['title']) && !isset($_POST['id'])){
    global $Route;
    global $database;
    $database->insert('personnel_time_management_types',[
    	"color"=>$_POST['color'],
    	"type"=>$_POST['type'],
    ]);
    $id=$database->id();
    langDefineSet(JK_LANG,'personnel_time_management_types','id',$id,$_POST['title']);

    echo redirect_to_js();
}

\Joonika\Forms\form_create([
    "id"=>"EditFrom"
]);
if(isset($_POST['id'])){
    global $database;
    $group=$database->get('personnel_time_management_types','*',[
            "id"=>$_POST['id'],
    ]);
    if(isset($group['id'])){
        global $data;
        $data['title']=langDefineGet(JK_LANG,'personnel_time_management_types','id',$group['id']);
        $data['color']=$group['color'];
        $data['type']=$group['type'];
        echo \Joonika\Forms\field_hidden([
            "name"=>"id",
            "value"=>$_POST['id'],
        ]);
        if(isset($_POST['title'])){
        	$database->update('personnel_time_management_types',[
		        "color"=>$_POST['color'],
		        "type"=>$_POST['type'],
	        ],[
	        	"id"=>$_POST['id']
	        ]);
            langDefineSet(JK_LANG,'personnel_time_management_types','id',$group['id'],$_POST['title']);
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
			"name"=>"color",
			"title"=>__("color"),
			"required"=>true,
			"direction"=>"ltr",
			"ColType"=>"12,12",
		]
	);
	echo '</div>';
	echo '<div class="col-12">';
	echo \Joonika\Forms\field_select(
		[
			"name"=>"type",
			"ColType"=>"12,12",
			"title"=>__("type"),
			"required"=>true,
			"array"=>[
				0=>__("exit"),
				1=>__("enter"),
			],
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
        "url" => JK_DOMAIN_LANG . 'cp/personnel/timeManagement/manage/type',
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;