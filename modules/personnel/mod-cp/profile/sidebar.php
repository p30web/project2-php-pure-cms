<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_info')) {
    error403();
    die;
}
global $lnkProfileLinks;
?>
<div class="">
    <!-- Navigation -->
    <div class="card pb-3">
        <div class="card-body bg-info text-center card-img-top"
        <div class="card-img-actions d-inline-block mb-3">
            <img class="img-fluid rounded-circle" src="<?php echo \Joonika\Modules\Users\profileImage($userID); ?>" width="128"
                 height="128" alt="">
        </div>

        <h6 class="text-center pt-3"><?php
            echo nickName($user['id'])
            ?></h6>
        <?php
        $rolegroups = \Joonika\Modules\Users\usersRoleGroups($user['id']);

        if (sizeof($rolegroups) >= 1) {
            foreach ($rolegroups as $rolegroup) {
                ?>
                <span class="d-block text-center"><?php
                    echo \Joonika\Modules\Users\roleTitle($rolegroup['role']) . ' ' . \Joonika\Modules\Users\groupTitle($rolegroup['group'])
                    ?></span>
                <?php
            }
        }
        ?>
    </div>
    <div class="card-body p-0 mb-3">
        <div class="list-group">
            <a href="<?php echo $lnkProfileLinks['info'] ?>" class="list-group-item list-group-item-action">
                <i class="fa fa-info float-<?php echo JK_DIRECTION_SIDE_R ?>"></i> <?php echo __("view information") ?>
            </a>
            <a href="<?php echo $lnkProfileLinks['update'] ?>" class="list-group-item list-group-item-action">
                <i class="fa fa-edit float-<?php echo JK_DIRECTION_SIDE_R ?>"></i> <?php echo __("update information") ?>
            </a>
        </div>
    </div>
    <!-- /navigation -->
    <!-- Latest connections -->
    <div class="card">
        <div class="card-header bg-transparent header-elements-inline">
            <span class="card-title font-weight-semibold"><?php __e("hierarchy") ?></span>
            <div class="header-elements">
                <span class="badge bg-success badge-pill"></span>
            </div>
        </div>

        <ul class="media-list media-list-linked mr-0 pr-0 pt-3 list-group">
            <!--                            <li class="media font-weight-semibold border-0 py-2">Office staff</li>-->
            <?php
            $thisUserRoles = [];
            $thisUserGroups = [];
            $varTops = [];
            $rolesGet = \Joonika\Modules\Users\usersRoleGroups($user['id']);
            if (sizeof($rolesGet) >= 1) {

                foreach ($rolesGet as $roleg) {
                    array_push($thisUserRoles, $roleg['role']);
                    array_push($thisUserGroups, $roleg['group']);
                }

            }
            if (sizeof($thisUserRoles) == 0) {
                $thisUserRoles = -1;

            }else{
                if(sizeof($thisUserRoles)>=1){

                    foreach ($thisUserRoles as $thisUserRole){
                        $getsort=$database->get('jk_roles','sort',[
                            "id"=>$thisUserRole
                        ]);
                        $hasVarTops = $database->select('jk_roles', "id", [
                                "AND"=>[
                            "sort[<]" => $getsort,
                            "showInHierarchy" => 1,
                                ]
                        ]);
                        if(sizeof($hasVarTops)>=1){
                            foreach ($hasVarTops as $hasVarTop){
                                array_push($varTops,$hasVarTop);
                            }
                        }
                    }
                }

            }
            if (sizeof($thisUserGroups) == 0) {
                $thisUserGroups = -1;
            }
            $Groups = \Joonika\Modules\Users\groupsParentGroups($thisUserGroups);
            $userGroups = [$thisUserGroups];
            if (sizeof($Groups) >= 1) {
                foreach ($Groups as $group) {
                    array_push($userGroups, $group);
                }


                if (sizeof($varTops) >= 1) {
                    foreach ($userGroups as $userGroup) {
                        $usselect = $database->select("jk_users_groups_rel", "userID", [
                            "AND" => [
                                "roleID" => $varTops,
                                "groupID" => $userGroup,
                                "status" => "active",
                            ]
                        ]);
                        $usselect=arrayIfEmptyZero($usselect);
                        $use=$database->select('jk_users',"*",[
                            "AND" => [
                                "id" => $usselect,
                                "id[!]" => $user['id'],
                                "status" => "active",
                            ]
                        ]);
                        if(sizeof($use)>=1){
                            foreach ($use as $u){
                                ?>
                                <li class="text-center list-group-item p-0 pb-3 pt-3">
                                    <a href="<?php echo JK_DOMAIN_LANG ?>cp/personnel/profile/<?php echo $u['id'] ?>" class="media">
                                        <div class="mr-3">
                                            <img src="/files/general/default-avatar-128.png"
                                                 class="rounded-circle" width="40" height="40" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="media-title font-weight-semibold"><?php echo nickName($u['id']) ?></div>
                                            <?php
                                            $rolegroupsH = \Joonika\Modules\Users\usersRoleGroups($u['id']);

                                            if (sizeof($rolegroupsH) >= 1) {
                                                foreach ($rolegroupsH as $rolegrouph) {
                                                    ?>
                                                    <span class="d-block text-center text-muted"><?php
                                                        echo \Joonika\Modules\Users\roleTitle($rolegrouph['role']) . ' ' . \Joonika\Modules\Users\groupTitle($rolegrouph['group'])
                                                        ?></span>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </a>
                                </li>
                                <?php
                            }
                        }

                    }
                }
            }


            ?>
        </ul>
    </div>
    <!-- /latest connections -->

</div>
