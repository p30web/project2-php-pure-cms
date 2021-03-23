<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
global $View;
$Users->loggedCheck();
if (!$ACL->hasPermission('users_confirms')) {
    error403();
    die;
}
$continue = true;

if ($continue) {
    if (isset($_POST['title'])) {
        global $database;
        if(isset($_POST['id'])){
            langDefineSet(JK_LANG,'jk_users_confirms','id',$_POST['id'],$_POST['title']);
            echo alertSuccess(__("edited"));
        }else{
            $database->insert("jk_users_confirms",[
                "status"=>"active",
            ]);
            $ucID=$database->id();
            if($ucID>=1){
                langDefineSet(JK_LANG,'jk_users_confirms','id',$ucID,$_POST['title']);
                echo alertSuccess(__("added"));
            }else{
                echo alertDanger(__("failed"));
            }
        }
    }
    ?>
    <?php
    echo \Joonika\Forms\form_create([
        'id' => "editForm"
    ]);
    if(isset($_POST['id'])){
        global $database;
        echo \Joonika\Forms\field_hidden([
        "name" => "id",
        "value" => $_POST['id'],
    ]);
    global $data;
        $data['title']=langDefineGet(JK_LANG,'jk_users_confirms','id',$_POST['id']);
        $data['module']=$database->get("jk_users_confirms","module",[
            "id"=>$_POST['id'],
        ]);
    }
    echo '<div class="col-12">';
    echo \Joonika\Forms\field_text(
        [
            "name" => "title",
            "title" => __("title"),
            "required" => true,
            "ColType" => "12,12",
        ]
    );
    echo '</div>';
    echo '<div class="col-12">';

    $array=arrayToKey(\Joonika\listModules());
    echo \Joonika\Forms\field_select(
        [
            "name" => "module",
            "title" => __("module"),
            "first" => true,
            "array" =>  $array,
            "ColType" => "12,12",
        ]
    );
    echo '</div>';
    echo \Joonika\Forms\field_submit(
        [
            "text" => __("assign"),
            "ColType" => "12,12",
            "btn-class" => "btn btn-primary btn-lg btn-block",
            "icon" => "fa fa-save"
        ]
    );
    echo \Joonika\Forms\form_end();

    $View->footer_js('<script>
' . ajax_validate([
            "on" => "submit",
            "formID" => "editForm",
            "url" => JK_DOMAIN_LANG . "cp/users/confirms/addC",
            "success_response" => "#modal_global_body",
            "loading" => ['iclass-size' => 1, 'elem' => 'span']
        ]) . '
</script>');

    echo $View->footer_js;
}