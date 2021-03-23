<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_permissions')) {
    error403();
    die;
}
if (isset($_POST['userID']) && $_POST['userID'] != '') {
    global $View;
    global $database;
    $modules = $database->select('jk_users_permissions', 'module', [
        "GROUP" => "module",
        "ORDER"=>["permName"=>"ASC"]
    ]);
    $ACL2 = new \Joonika\ACL();
    $ACL2->userID = $_POST['userID'];
    if (sizeof($modules) >= 1) {
        \Joonika\Forms\form_create(["id" => "permu_" . $_POST['userID']]);
        echo \Joonika\Forms\field_hidden([
            "name" => "userID",
            "value" => $_POST['userID']
        ]);
        ?>
        <button class="btn btn-success"><?php __e("save"); ?></button>
        <button type="button" class="btn btn-default"
                onclick="defaultperms(<?php echo $_POST['userID']; ?>)"><?php __e("assign default permissions") ?></button>
        <span id="save_result_<?php echo $_POST['userID']; ?>"></span>
        <hr/>
        <div class="row ltr text-left">
        <?php
        foreach ($modules as $module) {
            ?>
        <div class="col-4">
        <div class="card card-info">
        <div class="card-header text-center">
            <?php echo $module; ?>
        </div>
        <div class="card-body">
            <?php
            $selects = $database->select('jk_users_permissions', '*', [
                "module" => $module,
                "ORDER"=>["permName"=>"ASC"]
            ]);
            if (sizeof($selects) >= 1) {
                ?>
            <table class="table responsive table-sm table-bordered">
                <tbody>
                <?php
                foreach ($selects as $select) {
                if ($ACL2->hasPermission($select['permKey'])) {
                    $check=1;
                } else {
                    $check=0;
                }
                    ?>
                <tr>
                    <td><?php echo $select['permName']; ?></td>
                    <td><?php echo \Joonika\checkValueHtmlFa($check); ?></td>
                    <td>
                    <?php
                        $getval = $database->get('jk_users_perms_users', '*', [
                            "AND" => [
                                "userID" => $_POST['userID'],
                                "permID" => $select['id']
                            ]
                        ]);
                        $norval = 'not';
                        if (isset($getval['id']) && $getval['value'] == 1) {
                            $norval = '1';

                        } elseif (isset($getval['id']) && $getval['value'] == 0) {
                            $norval = '0';
                        }
                        $access = false;
                        $roles = \Joonika\Modules\Users\usersRoleGroups($_POST['userID']);
                        if (sizeof($roles) >= 1) {
                            foreach ($roles as $role) {
                                $haspermgr = $database->get("users_perms_groups", '*', [
                                    "AND" => [
                                        "permID" => $select['id'],
                                        "groupID" => $role['group'],
                                        "roleID" => [$role['role'], 0]
                                    ]
                                ]);
                                if (isset($haspermgr['id'])) {
                                    $access = true;
                                } else {
                                    $access = false;
                                }
                            }
                        }
                        if ($access == true) {
                            $deftxt = __("yes");
                        } else {
                            $deftxt = __("no");
                        }
                        ?>
                        <select name="perm_<?php echo $select['id']; ?>" class="form-control">
                            <option value=""><?php __e("default group & role"); ?> - <?php echo $deftxt; ?></option>
                            <option value="1"
                                    <?php if ($norval == '1'){ ?>selected="selected"<?php } ?>><?php __e("yes"); ?></option>
                            <option value="0"
                                    <?php if ($norval == '0'){ ?>selected="selected"<?php } ?>><?php __e("no"); ?></option>
                        </select>
                    </td>
                    <?php
                }
                ?>
                </tbody>
            </table>
                <div class="clearfix"></div>
                <?php
            }
            ?>
        </div>
        </div>
        </div>

        <?php
        }
        ?>
        </div>
            <?php
        \Joonika\Forms\form_end();

        $View->footer_js('
        <script>
        ' . ajax_load([
                "on" => "submit",
                "formID" => "permu_" . $_POST['userID'],
                "url" => JK_DOMAIN_LANG . 'cp/users/permissions/user/save_perm',
                "success_response" => "#save_result_" . $_POST['userID'],
                "data" => '$(this).serialize()',
                "loading" => [
                    "elem" => "span",
                ]
            ]) . '
        </script>
        ');
        echo $View->footer_js;
    }
} else {

    echo alert([
        "type" => "warning",
        "text" => __("please select a user")
    ]);
}