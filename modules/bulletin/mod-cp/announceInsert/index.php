<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('bulletin_insert_announce')) {
    error403();
    die;
}
global $View;
global $Users;
global $Route;
global $database;
global $Cp;
global $bulletin;
$Cp->setSidebarActive('bulletin/announceInsert');
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
$View->footer_js_files("/modules/cp/assets/js/ckeditor/ckeditor.js");
$View->footer_js_files('/modules/cp/assets/js/jquery-validation/jquery.validate.min.js');
\Joonika\Upload\dropzone_load();

$View->head();
?>
    <div class="card">
        <div class="card-body">
            <?php
            \Joonika\Forms\form_create([
                "id" => "announceInsert"
            ]);
            ?>
            <div class="row">
                <?php
                global $data;
                if (isset($Route->path[3]) && $Route->path[3] != "") {
                    $check = $database->get('bulletin', '*', [
                        "id" => $Route->path[3]
                    ]);
                    if (isset($check['id'])) {
                        echo \Joonika\Forms\field_hidden([
                            "name" => "editID",
                            "value" => $check['id'],
                        ]);
                        $data = $check;
                    }
                }
                echo div_start('col-12 col-sm-6 col-md-4');
                $groups = [];
                $groups = \Joonika\Modules\Users\groupsSubGroupsArray($groups, 0);
                echo \Joonika\Forms\field_select([
                    "name" => "usersGroup",
                    "title" => __("group"),
                    "ColType" => "12,12",
                    "required" => true,
                    "first" => true,
                    "multiple" => true,
                    "array" => $groups,
                ]);
                echo '</div>';

                echo div_start('col-12 col-sm-6 col-md-4');
                echo \Joonika\Forms\field_select([
                    "name" => "users",
                    "title" => __("user list"),
                    "ColType" => "12,12",
                    "required" => true,
                    "first" => true,
//                    "array" => $users,
                ]);

                echo '</div>';

                echo div_start('col-12');
                echo \Joonika\Forms\field_text([
                    "name" => "title",
                    "title" => __("title"),
                    "ColType" => "12,12",
                    "required" => true,
                ]);
                echo '</div>';


                echo div_start('w-100', '', true);
                echo div_start('col-12 col-sm-12 col-md-12');
                echo \Joonika\Forms\field_editor([
                    "name" => "text",
                    "title" => __("note"),
                    "type" => "simple",
                    "ColType" => "12,12",
                ]);
                echo '</div>';
                echo \Joonika\Upload\field_upload([
                    "title" => __("image"),
                    "name" => "img",
                    "ColType" => '12,12',
                    "maxfiles" => 1,
                    "module" => "bulletin_announce",
                    "text" => __('Drop files to upload'),
                ]);

                echo div_start('w-100', '', true);
                echo '<div class="col btn-group ">';
                echo \Joonika\Forms\field_submit([
                    "text" => '<i class="fa fa-save"></i> ' . __("save"),
                    "ColType" => "12,12",
                    "name" => "submit",
                    "value" => "save",
                    "btn-class" => "btn btn-outline-success btn-labeled",
                ]);

                echo \Joonika\Forms\field_submit([
                    "text" => '<i class="fa fa-times-circle"></i> ' . __("save & view announce"),
                    "ColType" => "12,12",
                    "name" => "submit",
                    "value" => "saveView",
                    "btn-class" => "btn btn-outline-danger btn-labeled",
                ]);
                echo '</div>';

                ?>
            </div>
            <?php
            \Joonika\Forms\form_end();

            ?>
            <div class="clearfix mt-3 w-100"></div>
            <hr/>
            <div id="action_addOrigin"></div>
            <div id="action_body"></div>
            <?php
            $View->footer_js('<script>

' . ajax_validate([
                    "on" => "submit",
                    "formID" => "announceInsert",
                    "ckeditor" => true,
                    "url" => JK_DOMAIN_LANG . 'cp/bulletin/announceInsert/insert',
                    "success_response" => "#action_addOrigin",
                    "loading" => ['iclass-size' => 1, 'elem' => 'span']
                ]) . '
    
    $("#usersGroup").on("change",function() {
       ' . ajax_load([
                    "url" => JK_DOMAIN_LANG . 'cp/bulletin/announceInsert/userAjax',
                    "success_response" => "#div_subjects",
                    "loading" => [
                    ]
                ]) . '
    });


</script>');
            ?>
        </div>
    </div>
<?php
$View->foot();