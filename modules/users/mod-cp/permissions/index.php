<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_permissions')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
$Cp->setSidebarActive('users/permissions');
$View->footer_js( '
<script>
    function updatePermission() {
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/users/permissions/update',
        "data" => "{}",
        "success_response" => "#update_panel",
        "loading" => true
    ]) . '
    }
</script>
');
$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            <?php
            global $permission_tabs;
            tab_menus($permission_tabs, JK_DOMAIN_LANG . 'cp/users/permissions/',2);
            modal_create([
                "bg" => "success",
            ]);

            ?>
            <br/>
            <a href="javascript:;" onclick="updatePermission()" class="btn btn-xs btn-info"><?php __e("update permissions") ?>
                <i class="fa fa-sync-alt"></i></a>
            <span id="update_panel"></span>
<hr/>
<div class="row ltr text-left">
            <?php
            global $database;
            $mods=$database->select('jk_users_permissions',"module",[
                    "GROUP"=>"module"
            ]);
            if(sizeof($mods)>=1){
                foreach ($mods as $mod){
                    ?>
                    <div class="col-4">
                        <div class="card card-info">
                            <div class="card-header text-center">
                                <?php echo $mod; ?>
                            </div>
                            <div class="card-body">
                                <?php
                                $perms=$database->select('jk_users_permissions','*',[
                                        "module"=>$mod
                                ]);
                                if(sizeof($perms)>=1){
                                    ?>
                                    <table class="table responsive table-sm table-bordered">
                                    <tbody><?php
                                    foreach ($perms as $perm){
                                    ?>
                                        <tr>
                                            <td><?php echo $perm['permKey'] ?></td>
                                            <td class=""><a class="btn btn-sm btn-info" href="<?php echo JK_DOMAIN_LANG ?>cp/users/permissions/index/acl/<?php echo $perm['permKey']; ?>"><i class="fa fa-info-circle"></i></a></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody></table>
                                        <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
</div>

        </div>
    </div>

<?php

$View->foot();