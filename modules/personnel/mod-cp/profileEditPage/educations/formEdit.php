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
        "url" => JK_DOMAIN_LANG . 'cp/personnel/profileEditPage/educations/formEdit',
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
    $datetime = date("Y/m/d", \Joonika\Idate\datetoint($_POST['datetime'], 3));

    if (isset($_POST['id']) && $_POST['id']!="") {
        $database->update('personnel_fields_rel',[
            "grade"=>$_POST['grade'],
            "fieldCatID"=>$_POST['fieldCatID'],
            "fieldID"=>$_POST['fieldID'],
            "type"=>$_POST['type'],
            "datetime"=>$datetime,
            "status"=>"unconfirmed",
        ],[
                "id"=>$_POST['id']
        ]);
    }else{
    $database->insert('personnel_fields_rel',[
        "userID"=>$_POST['userID'],
        "grade"=>$_POST['grade'],
        "fieldCatID"=>$_POST['fieldCatID'],
        "fieldID"=>$_POST['fieldID'],
        "type"=>$_POST['type'],
        "datetime"=>$datetime,
    ]);
    }
    echo alertSuccess(__("done"));
    $View->footer_js('<script>$("#modal_global_body").modal("hide");</script>');
}
\Joonika\Forms\form_create([
    "id" => 'form_edit'
]);
if (isset($_POST['id']) && $_POST['id']!="") {
    echo \Joonika\Forms\field_hidden([
        "name" => "id",
        "value" => $_POST['id']
    ]);
    global $data;
    $data=$database->get('personnel_fields_rel','*',[
        "id"=>$_POST['id']
    ]);
}
echo \Joonika\Forms\field_hidden([
    "name" => "formSave",
    "value" => 1
]);
echo \Joonika\Forms\field_hidden([
    "name" => "userID",
    "value" => $_POST['userID']
]);
?>
    <div class="row <?php echo JK_DIRECTION; ?>">
        <div class="col-6 offset-3">
            <div class="row">
                <?php
                $person = \Joonika\Modules\Personnel\personnelDetails($userid);

                echo div_start('col-12');
                echo \Joonika\Forms\field_select(
                    [
                        "name" => "grade",
                        "title" => __("grade"),
                        "required" => true,
                        "first" => true,
                        "ColType" => "12,12",
                        "array" => [
                            "d1" => \Joonika\Modules\Personnel\gradeTitle('d1'),
                            "d" => \Joonika\Modules\Personnel\gradeTitle('d'),
                            "m" => \Joonika\Modules\Personnel\gradeTitle('m'),
                            "b" => \Joonika\Modules\Personnel\gradeTitle('b'),
                            "a" => \Joonika\Modules\Personnel\gradeTitle('a'),
                        ],
                    ]
                );
                echo div_close();

                echo div_start('col-12');
                $sets = [];
                $cats = $database->select('personnel_fields_cats', 'id', [
                    "status" => "active",
                    "ORDER" => ["sort" => "ASC"],
                ]);
                if (sizeof($cats) >= 1) {
                    foreach ($cats as $cat) {
                        $sets[$cat] = langDefineGet(JK_LANG, 'personnel_fields_cats', 'id', $cat);
                    }
                }
                echo \Joonika\Forms\field_select(
                    [
                        "name" => "fieldCatID",
                        "title" => __("set"),
                        "required" => true,
                        "first" => true,
                        "ColType" => "12,12",
                        "array" => $sets,
                    ]
                );
                echo div_close();
                echo div_start("col-12", 'search_body');

                if (isset($_POST['id']) && $_POST['id']!="") {
                    $fields=[];
                    $fieldsDB=$database->select('personnel_fields','id',[
                        "AND"=>[
                            "status"=>"active",
                            "module"=>$data['fieldCatID'],
                        ],
                        "ORDER"=>["sort"=>"ASC"],
                    ]);
                    if(sizeof($fieldsDB)>=1){
                        foreach ($fieldsDB as $fieldDB){
                            $fields[$fieldDB]=langDefineGet(JK_LANG,'personnel_fields','id',$fieldDB);
                        }
                    }
                    echo \Joonika\Forms\field_select(
                        [
                            "name" => "fieldID",
                            "title" => __("field"),
                            "required" => true,
                            "first" => true,
                            "ColType" => "12,12",
                            "array" => $fields,
                        ]
                    );
                }

                echo div_close();
                echo div_start('col-12');
                echo \Joonika\Forms\field_select(
                    [
                        "name" => "type",
                        "title" => __("end status"),
                        "required" => true,
                        "first" => true,
                        "ColType" => "12,12",
                        "array" => [
                            "graduate" => \Joonika\Modules\Personnel\educationStatus('graduate'),
                            "collegian" => \Joonika\Modules\Personnel\educationStatus('collegian'),
                        ],
                    ]
                );
                echo div_close();
                echo div_start('col-12');
                echo \Joonika\Idate\field_date(
                    [
                        "title" => __("date"),
                        "name" => "datetime",
                        "position" => 'top',
                        "inLine" => false,
                        "required" => true,
                        "format" => "3",
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
            </div>
        </div>

        <div id="action_body"></div>
    </div>
<?php
$View->footer_js('<script>
  ' . ajax_load([
        "on" => "change",
        "formID" => "fieldCatID",
        "prevent" => false,
        "url" => JK_DOMAIN_LANG . 'cp/personnel/profileEditPage/educations/searchFieldsByCat',
        "data" => "{catID:$(\"#fieldCatID\").val()}",
        "success_response" => "#search_body",
        "loading" => [
            "elem" => "span",
            "iclass-size" => "1",
        ]
    ]) . '
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;