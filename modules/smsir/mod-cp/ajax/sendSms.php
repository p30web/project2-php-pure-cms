<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('cp')) {
    error403();
    die;
}
global $View;
global $database;

if (isset($_POST['submit'])) {
    $vars = [];
    foreach ($_POST as $checkK => $chekV) {
        if (substr($checkK, 0, 5) == "varF_") {
            $vars[substr($checkK, 5)] = $chekV;
        }
    }
    new \Joonika\Modules\Smsir\Smsir();
    $smsSt = \Joonika\Modules\Smsir\sendSmsIr($_POST['number'], $_POST['smsID'], $vars);
    if (!$smsSt) {
        echo alertDanger(__("problem send sms"));
    } else {
        if ($smsSt == "sent") {
            echo alertSuccess(__("successfully sent"));
            \Joonika\listModulesReadFiles("mod-sms/onSent.php");
        } else {
            echo alertDanger($smsSt);
        }
    }
}

$sms = $database->get('smsir_temps', '*', [
    "id" => $_POST['smsID']
]);

\Joonika\Forms\form_create([
    "id" => "EditFrom"
]);

echo \Joonika\Forms\field_hidden([
    "name" => "smsID",
    "value" => $_POST['smsID'],
]);

echo '<div class="row">';
echo '<div class="col-12">';
echo \Joonika\Forms\field_text(
    [
        "name" => "number",
        "direction" => "ltr",
        "title" => __("number"),
        "required" => true,
        "value" => $_POST['number'],
        "ColType" => "12,12",
    ]
);
echo '</div>';

parse_str($sms['vars'], $str);

if (sizeof($str) >= 1) {
    foreach ($str as $stK => $stV) {
        if ($stV == "") {
            echo '<div class="col-12">';
            echo \Joonika\Forms\field_text(
                [
                    "name" => "varF_" . $stK,
                    "title" => $stK,
                    "required" => true,
                    "value" => $stV,
                    "ColType" => "12,12",
                ]
            );
            echo '</div>';
        } else {
            echo '<div class="col-12">';
            echo \Joonika\Forms\field_hidden(
                [
                    "name" => "varF_" . $stK,
                    "value" => $stV,
                ]
            );
            echo '</div>';
        }
    }
}


echo '</div>';

echo \Joonika\Forms\field_submit([
    "text" => __("send sms"),
    "ColType" => "12,12",
    "btn-class" => "btn btn-primary btn-lg btn-block",
    "icon" => "fa fa-save"
]);

\Joonika\Forms\form_end();

$View->footer_js('<script>
' . ajax_validate([
        "on" => "submit",
        "formID" => "EditFrom",
        "url" => JK_DOMAIN_LANG . 'cp/smsir/ajax/sendSms',
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;