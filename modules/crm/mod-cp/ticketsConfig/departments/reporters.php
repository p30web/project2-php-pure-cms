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
if (isset($_POST['reporterType'])) {
    $Type = $_POST['reporterType'];
    $reporterId = "";
    if ($Type == "user") {
        $reporterId = $_POST['reporterIdUser'];
    } elseif ($Type == "group") {
        $reporterId = $_POST['reporterIdGroup'];
    }

    if ($reporterId == "") {
        echo alertWarning(__("invalid value"));
    } else {
        $database->insert("crm_tickets_departments_reporters", [
            "groupID"=>$_POST['id'],
            "reporterType"=>$Type,
            "reporterId"=>$reporterId,
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
        "name" => "reporterType",
        "title" => __("type"),
        "required" => true,
        "first" => true,
        "array" => $TypeArray,
        "ColType" => "12,12",
    ]
);
echo '</div>';


echo '<div class="col-12 d-none" id="reporterTypeUser">';
$users = \Joonika\Modules\Users\usersArray();
echo \Joonika\Forms\field_select(
    [
        "name" => "reporterIdUser",
        "title" => __("user"),
        "first" => true,
        "array" => $users,
        "ColType" => "12,12",
    ]
);
echo '</div>';

echo '<div class="col-12 d-none" id="reporterTypeGroup">';
$groups = \Joonika\Modules\Users\groupsSubGroupsArray([]);
echo \Joonika\Forms\field_select(
    [
        "name" => "reporterIdGroup",
        "title" => __("group"),
        "first" => true,
        "array" => $groups,
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
$gets=$database->select('crm_tickets_departments_reporters','*',[
    "AND"=>[
            "status"=>"active",
            "groupID"=>$_POST['id'],
        ]
]);
if(sizeof($gets)>=1){
    foreach ($gets as $get){

        $title="";
        if($get['reporterType']=="user"){
            $title='<i class="fa fa-user"></i> '.nickName($get['reporterId']);
        }elseif($get['reporterType']=="group"){
            $title='<i class="fa fa-users"></i> '.\Joonika\Modules\Users\groupTitle($get['reporterId']);
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
        "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/departments/reporters',
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
    
    $("#reporterType").on("change",function() {
      var thisval=$(this).val();
      if(thisval===""){
          $("#reporterTypeUser").addClass("d-none");
          $("#reporterTypeGroup").addClass("d-none");
      }else if(thisval==="user"){
                    $("#reporterTypeUser").removeClass("d-none");
                              $("#reporterTypeGroup").addClass("d-none");
      }else if(thisval==="group"){
                    $("#reporterTypeUser").addClass("d-none");
                    $("#reporterTypeGroup").removeClass("d-none");
      }
    });
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;