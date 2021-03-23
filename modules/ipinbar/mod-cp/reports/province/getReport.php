<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('reports_crm_ticketsCount')) {
    error403();
    die;
}
global $database;
if (isset($_POST['provinces']) && sizeof($_POST['provinces']) >= 1) {
    $provinces = $_POST['provinces'];
} else {
    $provinces = $database->select('jk_users_locations_provinces', "id", [
        "status" => "active"
    ]);
    if (sizeof($provinces) >= 1) {
        foreach ($provinces as $province) {
            $cts[$province] = langDefineGet(JK_LANG, 'jk_users_locations_provinces', 'id', $province);
        }
    } else {
        $provinces = 0;
    }
}
$getRecords = $database->select('ipinbar_favorites', 'origin', [
    "AND" => [
        "type" => "province",
        "value" => $provinces,
    ],
    "GROUP" => "origin"
]);
if (sizeof($getRecords) >= 1) {
    ?>
    <div class="card">
        <div class="card-body">
            <table class="table responsive table-xs small text-xs padding2table table-hover table-striped table-bordered tablebghead-info">
                <thead>
                <tr>
                    <th><?php __e("number") ?></th>
                    <th><?php __e("name") ?></th>
                    <th><?php __e("countries") ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                new \Joonika\Modules\Ipinbar\Ipinbar();
                foreach ($getRecords as $record) {
                    $provincesG = $database->select('ipinbar_favorites', 'value', [
                        "AND" => [
                            "type" => "province",
                            "origin" => $record,
                        ]
                    ]);
                    $txtshow = '';
                    if (sizeof($provincesG) >= 1) {
                        foreach ($provincesG as $provinceG) {
                            if (!in_array($provinceG, $provinces)) {
                                $txtshow .= '<span class="text-gray">' . langDefineGet(JK_LANG, 'jk_users_locations_provinces', 'id', $provinceG) . '</span> - ';
                            } else {
                                $txtshow .= '<span class="text-green">' . langDefineGet(JK_LANG, 'jk_users_locations_provinces', 'id', $provinceG) . '</span> - ';
                            }
                        }
                        $txtshow = trim($txtshow, ' - ');
                    }
                    ?>
                    <tr>
                        <td><?php echo $record ?></td>
                        <td><?php echo \Joonika\Modules\Ipinbar\getUserNameFamily($record, false); ?></td>
                        <td><?php echo $txtshow; ?></td>
                        <td></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
} else {
    echo alertWarning(__("no report found"));
}
