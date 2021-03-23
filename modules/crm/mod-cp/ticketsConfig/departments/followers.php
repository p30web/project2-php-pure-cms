<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets_config')) {
    error403();
    die;
}
global $Route;
global $View;
global $database;
if (!isset($_POST['id'])) {
    error403();
}
if (isset($_POST['followerType'])) {
    $Type = $_POST['followerType'];
    $followerId = "";
    if ($Type == "user") {
        $followerId = $_POST['followerIdUser'];
    } elseif ($Type == "group") {
        $followerId = $_POST['followerIdGroup'];
    }

    if ($followerId == "") {
        echo alertWarning(__("invalid value"));
    } else {
        $database->insert("crm_tickets_departments_followers", [
            "groupID"=>$_POST['id'],
            "followerType"=>$Type,
            "followerId"=>$followerId,
            "hidden"=>$_POST['hidden'],
        ]);
    }

}
\Joonika\Forms\form_create([
    "id" => "EditForm"
]);

echo \Joonika\Forms\field_hidden([
    "name" => "id",
    "value" => $_POST['id'],
]);

echo '<div class="row">';
echo '<div class="col-12" >';
$TypeArray = [
    "user" => __("user"),
    "group" => __("group"),
];
echo \Joonika\Forms\field_select(
    [
        "name" => "followerType",
        "title" => __("type"),
        "required" => true,
        "first" => true,
        "array" => $TypeArray,
        "ColType" => "12,12",
    ]
);
echo '</div>';


echo '<div class="col-12 d-none" id="followerTypeUser">';
$users = \Joonika\Modules\Users\usersArray();
echo \Joonika\Forms\field_select(
    [
        "name" => "followerIdUser",
        "title" => __("user"),
        "first" => true,
        "array" => $users,
        "ColType" => "12,12",
    ]
);
echo '</div>';

echo '<div class="col-12 d-none" id="followerTypeGroup">';
$groups = \Joonika\Modules\Users\groupsSubGroupsArray([]);
echo \Joonika\Forms\field_select(
    [
        "name" => "followerIdGroup",
        "title" => __("group"),
        "first" => true,
        "array" => $groups,
        "ColType" => "12,12",
    ]
);
echo '</div>';

echo '<div class="col-12" >';
$groups = \Joonika\Modules\Users\groupsSubGroupsArray([]);
$hiddensArray=[
    0=>__("no"),
    1=>__("yes"),
];
echo \Joonika\Forms\field_select(
    [
        "name" => "hidden",
        "title" => __("hidden"),
        "first" => false,
        "array" => $hiddensArray,
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

?>
<div>
    <hr/>
    <table class="table table-sm responsive table-bordered">
<tbody>
<?php
$gets=$database->select('crm_tickets_departments_followers','*',[
    "AND"=>[
            "status"=>"active",
            "groupID"=>$_POST['id'],
        ]
]);
if(sizeof($gets)>=1){
    foreach ($gets as $get){

        $title="";
        if($get['followerType']=="user"){
            $title='<i class="fa fa-user"></i> '.nickName($get['followerId']);
        }elseif($get['followerType']=="group"){
            $title='<i class="fa fa-users"></i> '.\Joonika\Modules\Users\groupTitle($get['followerId']);
        }
        if($get['hidden']==1){
            $title.=" <span class='text-info small'>(".__("hidden").")</span>";
        }
        ?>
        <tr id="followerTr_<?php echo $get['id']; ?>">
            <td><?php echo $title; ?></td>
            <td><button class="btn btn-xs small btn-danger" onclick="removeFollower(<?php echo $get['id']; ?>)"><i class="fa fa-times-circle"></i></button></td>
        </tr>
        <?php
    }
}
?>
</tbody>

    </table>
</div>
<?php

$View->footer_js('<script>
' . ajax_validate([
        "on" => "submit",
        "formID" => "EditForm",
        "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/departments/followers',
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
    
    $("#followerType").on("change",function() {
      var thisval=$(this).val();
      if(thisval===""){
          $("#followerTypeUser").addClass("d-none");
          $("#followerTypeGroup").addClass("d-none");
      }else if(thisval==="user"){
                    $("#followerTypeUser").removeClass("d-none");
                              $("#followerTypeGroup").addClass("d-none");
      }else if(thisval==="group"){
                    $("#followerTypeUser").addClass("d-none");
                    $("#followerTypeGroup").removeClass("d-none");
      }
    });
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;