<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_permissions')) {
    error403();
    die;
}
global $View;
global $Users;
global $Route;
global $Cp;
global $database;

if (isset($_POST['roleID_sel'])) {
    if(sizeof($_POST['roleID_sel'])>=1){
        foreach ($_POST['roleID_sel'] as $prl=>$value){
            if(sizeof($_POST['groups'])>=1){
                foreach ($_POST['groups'] as $val){

                    $insert=$database->insert('jk_users_perms_groups',[
                        "permID"=>$_POST['permID'],
                        "roleID"=>$prl,
                        "groupID"=>$val,
                        "value"=>1,
                    ]);
                    if(isset($_POST['intermittent']) && $_POST['intermittent']==1){
                        $subgroups=\Joonika\Modules\Users\groupsSubGroups($val);
                        if(sizeof($subgroups)>=1){
                            foreach ($subgroups as $subgroup){
                                if(!in_array($subgroup,$_POST['groups'])){
                                    $insert=$database->insert('jk_users_perms_groups',[
                                        "permID"=>$_POST['permID'],
                                        "roleID"=>$prl,
                                        "groupID"=>$subgroup,
                                        "value"=>1,
                                    ]);
                                }
                            }
                        }
                    }

                }
            }
        }
    }

    echo alert(["type" => 'success', "title" => __("added")]);
    $View->footer_js( '
    <script>
    $(\'#modal_global_lg\').on(\'hidden.bs.modal\', function () {
    ' . redirect_to_js('',0,false) . '
})
    </script>
    ');

}
\Joonika\Forms\form_create([
    "id" => "permAddGroup"
]);
?>
    <h6 class="text-info text-center"><?php __e("add permission") ?>: <?php
        echo \Joonika\aclNameById($_POST['permID']);
        ?> </h6>
<?php
echo \Joonika\Forms\field_hidden([
    "name" => "permID",
    "value" => $_POST['permID'],
]);
?>
<div class="row">

    <div class="col-4">
        <table class="table datatable-html-groups">
            <thead>
            <tr>
                <th><?php __e("role"); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $roles=$database->select('jk_roles','*',[
                "status"=>'active',
                "ORDER"=>["sort"=>"ASC"]
            ]);
            if(sizeof($roles)>=1){
                ?>
                <tr>
                    <td>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="roleID_sel[0]" class="styled">
                                <?php echo __("all roles"); ?>
                            </label>
                        </div>
                </tr>
                <?php
                foreach ($roles as $role){
                    ?>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="roleID_sel[<?php echo $role['id'] ?>]" class="styled">
                                    <?php echo \Joonika\Modules\Users\roleTitle($role['id']) ?>
                                </label>
                            </div>
                    </tr>
                    <?php
                }
            }

            ?>

            </tbody>
        </table>

    </div>
    <div class="col-8">
        <label for="intermittent"><?php __e("intermittent"); ?></label>
        <input type="checkbox" name="intermittent" id="intermittent" value="1" checked="checked">
        <br/>
        <?php
        \Joonika\Modules\Users\groupsCheckboxParentHTML(0, 0);
        ?>
    </div>

</div>

<?php



echo \Joonika\Forms\field_submit();
\Joonika\Forms\form_end();
$View->footer_js( '
<script>
' . ajax_validate([
        "on" => "submit",
        "formID" => "permAddGroup",
        "validate" => true,
        "prevent" => true,
        "url" => JK_DOMAIN_LANG . 'cp/users/permissions/index/acl_add_group',
        "success_response" => "#modal_global_lg_body",
        "loading" => [
        ]
    ]) . '
</script>
');

echo $View->getFooterJsFiles();
echo $View->getFooterJs();