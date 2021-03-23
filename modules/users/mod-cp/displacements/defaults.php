<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_displacements')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
$Cp->setSidebarActive('users/displacements');
$View->footer_js('
<script>
' . ajax_validate([
        "on" => "submit",
        "formID" => "displacement_defaults",
        "validate" => true,
        "prevent" => true,
        "url" => JK_DOMAIN_LANG . 'cp/users/displacements/defaults/displacementsSave',
        "success_response" => "#action_body",
        "loading" => [
        ]
    ]) . '
</script>');
$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            <?php
            global $displacement_tabs;
            tab_menus($displacement_tabs, JK_DOMAIN_LANG . 'cp/users/displacements/',2);
            modal_create([
                "bg" => "success",
            ]);

            ?>
            <br/>
    <?php
            \Joonika\Forms\form_create([
    "id" => "displacement_defaults",
]);
?>
    <div class="row">
        <?php
        global $data;
$data['default_group']=jk_options_get("displacement_default_group");
$data['default_role']=jk_options_get("displacement_default_role");
$data['default_displacementType']=jk_options_get("displacement_default_displacementType");
        echo div_start('col-md-4 col-12');
        $groups=[];
        $groups=\Joonika\Modules\Users\groupsSubGroupsArray($groups,0);
        echo \Joonika\Forms\field_select(
            [
                "name" => "default_group",
                "title" => __("default group"),
                "required" => true,
                "array" => $groups,
                "ColType" => "12,12",
            ]
        );
        echo div_close();

        echo div_start('col-md-4 col-12');
        $roles=\Joonika\Modules\Users\rolesArray();
        echo \Joonika\Forms\field_select(
            [
                "name" => "default_role",
                "title" => __("default role"),
                "required" => true,
                "array" => $roles,
                "ColType" => "12,12",
            ]
        );
        echo div_close();

        echo div_start('col-md-4 col-12');
        $displacementTypes=\Joonika\Modules\Users\displacementTypesArray();
        echo \Joonika\Forms\field_select(
            [
                "name" => "default_displacementType",
                "title" => __("default displacement"),
                "required" => true,
                "array" => $displacementTypes,
                "ColType" => "12,12",
            ]
        );
        echo div_close();

        ?>
    </div>
<?php
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

    </div>

<?php

$View->foot();