<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_info_edit')) {
    error403();
    die;
}
global $View;
global $database;
$View->footer_js('<script>
' . ajax_validate([
        "on" => "submit",
        "formID" => "form_edit",
        "url" => JK_DOMAIN_LANG . 'cp/personnel/profileEditPage/basics/formEdit',
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>')
?>
<?php

$userid = $_POST['userID'];
new \Joonika\Modules\Personnel\Personnel();
$person = \Joonika\Modules\Personnel\personnelDetails($userid);
if (isset($_POST['formSave'])) {
    $birthdate = date("Y/m/d", \Joonika\Idate\datetoint($_POST['birthday'], 3));
    $database->update('personnel_details', [
        "personnelID" => $_POST['personnelID'],
        "birthday" => $birthdate,
        "maritalStatus" => $_POST['maritalStatus'],
        "spouseName" => $_POST['spouseName'],
        "children" => $_POST['children'],
        "nationalCode" => $_POST['nationalCode'],
        "militaryStatus" => $_POST['militaryStatus'],
        "address" => $_POST['address'],
        "phone" => $_POST['phone'],
    ], [
        "id" => $person['id']
    ]);
    echo alertSuccess(__("done"));
}
\Joonika\Forms\form_create([
    "id" => 'form_edit'
]);
echo \Joonika\Forms\field_hidden([
    "name" => "formSave",
    "value" => 1
]);
echo \Joonika\Forms\field_hidden([
    "name" => "userID",
    "value" => $_POST['userID']
]);
?>
    <div class="row">
        <?php
        $person = \Joonika\Modules\Personnel\personnelDetails($userid);
        global $data;
        $data = $person;


        echo div_start('col-6');
        echo \Joonika\Forms\field_text(
            [
                "name" => "nationalCode",
                "title" => __("national code"),
                "required" => true,
                "direction" => "ltr",
                "ColType" => "12,12",
            ]
        );
        echo div_close();

        echo div_start('col-6');
        echo \Joonika\Forms\field_text(
            [
                "name" => "personnelID",
                "direction" => "ltr",
                "title" => __("personnel id"),
                "ColType" => "12,12",
            ]
        );
        echo div_close();


        echo div_start('col-6');
        echo \Joonika\Idate\field_date([
                "title" => __("birthday"),
                "name" => "birthday",
                "format" => "3",
                "ColType" => "12,12",
                "required" => true,
            ]
        );
        echo div_close();
        echo div_start('col-6');
        echo \Joonika\Forms\field_select(
            [
                "name" => "militaryStatus",
                "title" => __("military status"),
                "required" => true,
                "first" => true,
                "ColType" => "12,12",
                "array" => [
                    "ineligible" => __("ineligible"),
                    "undone" => __("undone"),
                    "done" => __("done"),
                    "exempt" => __("exempt"),
                ],
            ]
        );
        echo div_close();
        echo div_start('col-6');
        echo \Joonika\Forms\field_select(
            [
                "name" => "maritalStatus",
                "title" => __("marital status"),
                "required" => true,
                "ColType" => "12,12",
                "array" => [
                    0 => __("single"),
                    1 => __("married")
                ],
            ]
        );
        echo div_close();

        echo div_start('col-6');
        $checkHide = "";
        if ($data['maritalStatus'] == "0") {
            $checkHide = "d-none";
        }
        echo \Joonika\Forms\field_text(
            [
                "name" => "spouseName",
                "form-group-class" => $checkHide,
                "title" => __("spouse name"),
                "ColType" => "12,12",
            ]
        );
        echo div_close();
        echo div_start('col-6');
        echo \Joonika\Forms\field_text(
            [
                "name" => "children",
                "title" => __("children count"),
                "ColType" => "12,12",
            ]
        );
        echo div_close();
        echo div_start('w-100', '', true);

        echo div_start('col-12');
        echo \Joonika\Forms\field_text(
            [
                "name" => "address",
                "title" => __("address"),
                "ColType" => "12,12",
            ]
        );
        echo div_close();
        echo div_start('col-6');
        echo \Joonika\Forms\field_text(
            [
                "name" => "phone",
                "title" => __("phone"),
                "required" => true,
                "direction" => "ltr",
                "ColType" => "12,12",
            ]
        );
        echo div_close();
        echo \Joonika\Forms\field_submit([
            "text" => __("save"),
            "ColType" => "12,12",
            "btn-class" => "btn btn-primary btn-lg btn-block",
            "icon" => "fa fa-save"
        ]);
        \Joonika\Forms\form_end();
        ?>
        <div id="action_body"></div>
    </div>
<?php
$View->footer_js('<script>
$("#maritalStatus").on("change",function() {
  var thisVal=$(this).val();
  if(thisVal=="1"){
      $("#spouseName").parent().parent().removeClass("d-none");
  }else{
      $("#spouseName").parent().parent().addClass("d-none");
  }
});
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;