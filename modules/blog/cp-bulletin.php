<?php
global $bulletin;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bulletin->set_data($_POST["title"], $_POST["text"], $_POST["status"]);
}
if (isset($_SESSION['msg'])) {
    ?>
    <div class="alert alert-dismissible">
        <span class="close" data-dismiss="alert">&times;</span>
        <p class="pr-4"><?php echo $_SESSION['msg']; ?> </p>
    </div>
    <?php
    unset($_SESSION['msg']);
}

?>
    <div class="card">
        <div class="card-body">
            <?php
            new \Joonika\Modules\cp\bulletin();
            \Joonika\Forms\form_create([
                "id" => "addannounce"
            ]);
            ?>
            <div class="row">
                <?php
                global $data;
                echo div_start('col-12 col-sm-6 col-md-4', 'div_subjects');
                if (isset($_POST['title']) && $_POST['title'] != "") {
                    $subjects = \Joonika\Modules\Crm\ticketSubjects($data['parentSubject']);
                    $data['subject'] = $_POST['subject'];
                } else {
                    $subjects = \Joonika\Modules\Crm\ticketSubjects(null, true);
                }
                echo \Joonika\Forms\field_select([
                    "name" => "usersGroup",
                    "title" => __("group"),
                    "ColType" => "12,12",
                    "required" => true,
                    "first" => true,
                    "array" => $subjects,
                ]);

                echo '</div>';

                if (isset($_POST['subject']) && $_POST['subject'] != "") {
                    $data['parentSubject'] = \Joonika\Modules\Crm\ticketsGetParentSubject($_POST['subject']);
                }
                echo div_start('col-12 col-sm-6 col-md-4');
                $parentSubjects = \Joonika\Modules\Crm\ticketParentSubjects();
                echo \Joonika\Forms\field_select([
                    "name" => "users",
                    "title" => __("user list"),
                    "ColType" => "12,12",
                    "required" => true,
                    "first" => true,
                    "array" => $parentSubjects,
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



