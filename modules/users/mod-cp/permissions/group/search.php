<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_permissions')) {
    error403();
    die;
}
if (isset($_POST['groupID']) && $_POST['groupID'] != '' && isset($_POST['roleID']) && $_POST['roleID'] != '') {
    global $View;
    global $database;
    $modules = $database->select('jk_users_permissions', 'module', [
        "GROUP" => "module",
        "ORDER"=>["module"=>"ASC"]
    ]);

    if (sizeof($modules) >= 1) {
        \Joonika\Forms\form_create(["id" => "permg_" . $_POST['groupID'] . '_' . $_POST['roleID']]);
        echo \Joonika\Forms\field_hidden([
            "name" => "groupID",
            "value" => $_POST['groupID']
        ]);
        echo \Joonika\Forms\field_hidden([
            "name" => "roleID",
            "value" => $_POST['roleID']
        ]);
        ?>
        <button class="btn btn-success"><?php __e("save"); ?></button>
        <button type="button" class="btn btn-default"
                onclick="defaultperms(<?php echo $_POST['groupID']; ?>,<?php echo $_POST['roleID']; ?>)"><?php __e("assign default permissions") ?></button>
        <span id="save_result_<?php echo $_POST['groupID'] . '_' . $_POST['roleID']; ?>"></span>
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
                "ORDER"=>["permKey"=>"ASC"]
            ]);
            if (sizeof($selects) >= 1) {
                ?>
            <table class="table responsive table-sm table-bordered">
                <tbody>
                <?php
                foreach ($selects as $select) {
                    $norval=0;
                    $haspermgr = $database->get("jk_users_perms_groups", '*', [
                        "AND" => [
                            "permID" => $select['id'],
                            "groupID" => $_POST['groupID'],
                            "roleID" => [$_POST['roleID'], 0]
                        ]
                    ]);

                    if (isset($haspermgr['id'])) {
                        $check=1;
                        $deftext=__("yes");
                    } else {
                        $check=0;
                        $deftext=__("no");
                    }


                    $haspermgr = $database->get("jk_users_perms_groups", '*', [
                        "AND" => [
                            "permID" => $select['id'],
                            "groupID" => $_POST['groupID'],
                            "roleID" => $_POST['roleID']
                        ]
                    ]);

                    if (isset($haspermgr['id'])) {
                        $norval = '1';
                    }
                    ?>
                <tr>
                    <td><?php echo $select['permName']; ?></td>
                    <td><?php echo \Joonika\checkValueHtmlFa($check); ?></td>
                    <td><select name="perm_<?php echo $select['id']; ?>" class="form-control">
                            <option value=""><?php __e("default"); ?> - <?php echo $deftext; ?></option>
                            <option value="1" <?php if ($norval == '1'){ ?>selected="selected"<?php } ?>><?php __e("yes"); ?></option>
                        </select>
                    </td>
                </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
                <?php
            }
            ?>
        </div>
        </div>
        </div>
            <?php

        }
        \Joonika\Forms\form_end();
?>
                </div>
                    <?php
        $View->footer_js('
        <script>
        ' . ajax_load([
                "on" => "submit",
                "formID" => "permg_" . $_POST['groupID'] . "_" . $_POST['roleID'],
                "url" => JK_DOMAIN_LANG . 'cp/users/permissions/group/save_perm',
                "success_response" => "#save_result_" . $_POST['groupID'] . "_" . $_POST['roleID'],
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
        "text" => __("please select a group & role")
    ]);
}