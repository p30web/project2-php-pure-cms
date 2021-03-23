<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_displacements')) {
    error403();
    die;
}
global $View;
global $Route;
global $database;
if (isset($_POST['displacementType'])) {
$datetime=date("Y/m/d",\Joonika\Idate\datetoint($_POST['datetime'],3,'fa'));
    \Joonika\Modules\Users\displacementSubmitRoleGroup($_POST['displacementType'],$_POST['userID'],$_POST['role'],$_POST['group'],$datetime);
    echo redirect_to_js();
}

\Joonika\Forms\form_create([
    "id" => "saveform",
]);
?>
    <div class="row">
        <div id="action_body_modal"></div>
        <table class="table responsive">
            <tbody>
            <?php
            $usersGroups=\Joonika\Modules\Users\usersRoleGroups($_POST['userID']);
            if(sizeof($usersGroups)>=1){
                foreach ($usersGroups as $usersGroup){
                    ?>
                    <tr id="rlg_<?php echo $usersGroup['id']; ?>">
                        <td>
                        <button class="btn btn-sm btn-warning" onclick="rmgroprle(<?php echo $usersGroup['id']; ?>)"><i class="fa fa-times"></i></button>
                        <?php
                        echo \Joonika\Modules\Users\roleTitle($usersGroup['role']).' '.\Joonika\Modules\Users\groupTitle($usersGroup['group']);
                        ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>

            </tbody>
        </table>
        <?php
        global $data;
echo \Joonika\Forms\field_hidden([
        "name"=>"userID",
        "value"=>$_POST['userID'],
]);
        echo div_start('col-12');
        $displacementTypes = \Joonika\Modules\Users\displacementTypesArray();
        echo \Joonika\Forms\field_select(
            [
                "name" => "displacementType",
                "title" => __("displacement type"),
                "required" => true,
                "first" => true,
                "array" => $displacementTypes,
                "ColType" => "12,12",
            ]
        );
        echo div_close();

        echo div_start('col-12');
        echo \Joonika\Idate\field_date(
                [
                    "title"=>__("date"),
                    "name"=>"datetime",
                    "required" => true,
                    "format"=>"3",
                ]
        );
        echo div_close();

        echo div_start('col-12');
        $roles = \Joonika\Modules\Users\rolesArray();
        echo \Joonika\Forms\field_select(
            [
                "name" => "role",
                "title" => __("role"),
                "required" => true,
                "first" => true,
                "array" => $roles,
                "ColType" => "12,12",
            ]
        );
        echo div_close();

        echo div_start('col-12');
        $groups = [];
        $groups = \Joonika\Modules\Users\groupsSubGroupsArray($groups, 0);
        echo \Joonika\Forms\field_select(
            [
                "name" => "group",
                "title" => __("group"),
                "required" => true,
                "first" => true,
                "array" => $groups,
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

$View->footer_js('<script>
' . ajax_validate([
        "on" => "submit",
        "formID" => "saveform",
        "url" => JK_DOMAIN_LANG . 'cp/users/usersList/turnover',
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;