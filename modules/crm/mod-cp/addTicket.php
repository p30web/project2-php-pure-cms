<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_addTicket')) {
    error403();
    die;
}
global $View;
global $Users;
global $Route;
global $database;
global $Cp;
$Cp->setSidebarActive('crm/addTicket');
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
            new \Joonika\Modules\Crm\Crm();
            \Joonika\Forms\form_create([
                "id" => "addTicket"
            ]);
            ?>
            <div class="row">
                <?php
                global $data;
                if (isset($_POST['subject']) && $_POST['subject'] != "") {
                    $data['parentSubject'] = \Joonika\Modules\Crm\ticketsGetParentSubject($_POST['subject']);
                }
                echo div_start('col-12 col-sm-6 col-md-4');
                $parentSubjects = \Joonika\Modules\Crm\ticketParentSubjects();
                echo \Joonika\Forms\field_select([
                    "name" => "parentSubject",
                    "title" => __("parent subject"),
                    "ColType" => "12,12",
                    "required" => true,
                    "first" => true,
                    "array" => $parentSubjects,
                ]);
                echo '</div>';

                echo div_start('col-12 col-sm-6 col-md-4', 'div_subjects');
                if (isset($_POST['subject']) && $_POST['subject'] != "") {
                    $subjects = \Joonika\Modules\Crm\ticketSubjects($data['parentSubject']);
                    $data['subject'] = $_POST['subject'];
                } else {
                    $subjects = \Joonika\Modules\Crm\ticketSubjects(null, true);
                }
                echo \Joonika\Forms\field_select([
                    "name" => "subject",
                    "title" => __("subject"),
                    "ColType" => "12,12",
                    "required" => true,
                    "first" => true,
                    "array" => $subjects,
                ]);

                echo '</div>';

                echo div_start('col-12 col-sm-6 col-md-4');
                $data['priority'] = "medium";
                echo \Joonika\Forms\field_select([
                    "name" => "priority",
                    "title" => __("priority"),
                    "ColType" => "12,12",
                    "required" => true,
                    "array" => [
                        "urgent" => __("urgent"),
                        "high" => __("high"),
                        "medium" => __("medium"),
                        "low" => __("low"),
                    ],
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
                    "name" => "newNoteTxt",
                    "title" => __("note"),
                    "type" => "simple",
                    "ColType" => "12,12",
                ]);
                echo '</div>';
                echo div_start('col-12');
                echo \Joonika\Upload\field_upload([
                    "title" => __("attachments"),
                    "name" => "attachments",
                    "ColType" => '12,12',
                    "maxfiles" => 20,
                    "module" => "crm_tickets",
                ]);

                echo '</div>';
                echo div_start('col-12 col-sm-6 col-md-4');
                $departments = \Joonika\Modules\Crm\ticketsDepartments();
                echo \Joonika\Forms\field_select([
                    "name" => "department",
                    "title" => __("assign to department"),
                    "ColType" => "12,12",
                    "first" => true,
                    "array" => $departments,
                ]);
                echo '</div>';
                echo div_start('col-12 col-sm-6 col-md-4', "div_assigner");
                $users = \Joonika\Modules\Users\usersArray();
                $data['assign']=JK_LOGINID;
                echo \Joonika\Forms\field_select([
                    "name" => "owner",
                    "title" => __("assign to person"),
                    "ColType" => "12,12",
                    "first" => true,
                    "array" => $users,
                ]);
                echo '</div>';
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
                    "text" => '<i class="fa fa-times-circle"></i> ' . __("save & view ticket"),
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
                    "formID" => "addTicket",
                    "ckeditor" => true,
                    "url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/addTicket',
                    "success_response" => "#action_addOrigin",
                    "loading" => ['iclass-size' => 1, 'elem' => 'span']
                ]) . '
    
    $("#parentSubject").on("change",function() {
       ' . ajax_load([
                    "url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/subjectOfParent',
                    "success_response" => "#div_subjects",
                    "loading" => [
                    ]
                ]) . '
    });    
    $("#department").on("change",function() {
       ' . ajax_load([
                    "url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/departmentUsers',
                    "success_response" => "#div_assigner",
                    "loading" => [
                    ]
                ]) . '
    });
    $("#subject").on("change",function() {
       ' . ajax_load([
                    "url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/subjectSelectParent',
                    "success_response" => "#action_body",
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