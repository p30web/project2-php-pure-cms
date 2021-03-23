<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $View;
global $database;
if (!$ACL->hasPermission('personnel_org_chart')) {
    error403();
    die;
}

$group = $database->get('jk_groups', "*", [
    "id" => $_POST['groupID']
]);
$directPersonnelCountRel = $database->select("jk_users_groups_rel", "userID", [
    "AND" => [
        "status" => 'active',
        "groupID" => $group['id']
    ]
]);

$directPersonnelCountRel = arrayIfEmptyZero($directPersonnelCountRel);
$directPersonnels = $database->select("jk_users", "id", [
    "AND" => [
        "id" => $directPersonnelCountRel,
        "status" => "active",
    ]
]);

$directPersonnelCount = sizeof($directPersonnels);


$groupsSub = \Joonika\Modules\Users\groupsSubGroups($group['id']);
$groupsSub = arrayIfEmptyZero($groupsSub);
$indirectPersonnelCountRel = $database->select("jk_users_groups_rel", "userID", [
    "AND" => [
        "status" => 'active',
        "groupID" => $groupsSub
    ]
]);
$indirectPersonnelCountRel = arrayIfEmptyZero($indirectPersonnelCountRel);
$indirectPersonnels = $database->select("jk_users", "id", [
    "AND" => [
        "id" => $indirectPersonnelCountRel,
        "status" => "active",
    ]
]);
$indirectPersonnelCount = sizeof($indirectPersonnels);

?>
    <div class="row" style="position: relative!important;">

        <div class="col-12 text-center m-3"><h5><?php echo \Joonika\Modules\Users\groupTitle($group['id']); ?></h5></div>
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <div class="text-muted"><?php __e("direct personnel") ?></div>
                    <h5 class="mt-1"><?php echo $directPersonnelCount; ?></h5>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <div class="text-muted"><?php __e("indirect personnel") ?></div>
                    <h5 class="mt-1"><?php echo $indirectPersonnelCount; ?></h5>
                </div>
            </div>
        </div>
        <div class="col-12 row">
            <?php
            new \Joonika\Modules\Personnel\Personnel();
            if (sizeof($directPersonnels) >= 1) {
                    $roles = \Joonika\Modules\Users\rolesArray();
                    if (sizeof($roles) >= 1) {
                        foreach ($roles as $roleKey => $roleTitle) {
                            $usersGroup = $database->select('jk_users_groups_rel', 'userID', [
                                "AND" => [
                                    "status" => "active",
                                    "roleID" => $roleKey,
                                    "userID" => $directPersonnels,
                                ]
                            ]);
                            if (sizeof($usersGroup) >= 1) {
                                foreach ($usersGroup as $use) {
                                    \Joonika\Modules\Personnel\personnelCardSimple($use,"col-12 col-md-6");
                                }
                            }

                        }
                    }
            }
            if (sizeof($indirectPersonnels) >= 1) {
                ?>

                <div class="w-100"><hr/></div>
                    <?php
                    $roles = \Joonika\Modules\Users\rolesArray();
                    if (sizeof($roles) >= 1) {
                        foreach ($roles as $roleKey => $roleTitle) {
                            $usersGroup = $database->select('jk_users_groups_rel', 'userID', [
                                "AND" => [
                                    "status" => "active",
                                    "roleID" => $roleKey,
                                    "userID" => $indirectPersonnels,
                                ]
                            ]);
                            if (sizeof($usersGroup) >= 1) {
                                foreach ($usersGroup as $use) {
                                    \Joonika\Modules\Personnel\personnelCardSimple($use,"col-12 col-md-6",true);
                                }
                            }

                        }
                    }
            }
            ?>
        </div>
    </div>
<?php

echo $View->getFooterJsFiles();
echo $View->footer_js;