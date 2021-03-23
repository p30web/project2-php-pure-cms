<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('reports_crm_ticketsCount')) {
    error403();
    die;
}
global $database;
if (isset($_POST['countries']) && sizeof($_POST['countries']) >= 1) {
    $countries = $_POST['countries'];
} else {
    $countries = $database->select('jk_users_locations_countries', "id", [
        "status" => "active"
    ]);
    if (sizeof($countries) >= 1) {
        foreach ($countries as $country) {
            $cts[$country] = langDefineGet(JK_LANG, 'jk_users_locations_countries', 'id', $country);
        }
    } else {
        $countries = 0;
    }
}
$getRecords = $database->select('ipinbar_favorites', 'origin', [
    "AND" => [
        "type" => "country",
        "value" => $countries,
    ],
    "GROUP"=>"origin"
]);
if (sizeof($getRecords) >= 1) {
    ?>
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
            $countriesG = $database->select('ipinbar_favorites', 'value', [
                "AND" => [
                    "type" => "country",
                    "origin" => $record,
                ]
            ]);
            $txtshow = '';
            if (sizeof($countriesG) >= 1) {
                foreach ($countriesG as $countryG) {
                    if (!in_array($countryG, $countries)) {
                        $txtshow .= '<span class="text-gray">' . langDefineGet(JK_LANG, 'jk_users_locations_countries', 'id', $countryG) . '</span> - ';
                    } else {
                        $txtshow .= '<span class="text-green">' . langDefineGet(JK_LANG, 'jk_users_locations_countries', 'id', $countryG) . '</span> - ';
                    }
                }
                $txtshow = trim($txtshow,' - ');
            }
            ?>
            <tr>
                <td><?php echo $record ?></td>
                <td><?php echo \Joonika\Modules\Ipinbar\getUserNameFamily($record,false); ?></td>
                <td><?php echo $txtshow; ?></td>
                <td></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <?php
} else {
    echo alertWarning(__("no report found"));
}
