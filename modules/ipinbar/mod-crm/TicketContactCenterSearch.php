<?php
if (!defined('jk')) die('Access Not Allowed !');
if (isset($_POST['searchBy']) && $_POST['searchBy'] == "phoneNumber" && isset($_POST['search'])) {
new \Joonika\Modules\Ipinbar\Ipinbar();
    \Joonika\Modules\Ipinbar\ticketInfoUserBoxFull("username=".$_POST['search']);
}
global $View;
?>
<div class="small">
    <?php
    global $database;
    $smsTemplates = $database->select("smsir_temps", '*', [
        "status" => "active",
    ]);
    if (sizeof($smsTemplates) >= 1) {
        ?>
        <span class="text-center mb-2 mt-2"><i class="fa fa-comment-dots"></i> SMS</span>
        <?php
        foreach ($smsTemplates as $smsTemplate) {
            ?>
            <button type="button"
                    onclick="SMSPanelSend('<?php echo $smsTemplate['id']; ?>','<?php echo $_POST['search']; ?>')"
                    class="btn btn-outline-success btn-sm mb-1">
                <i class="fa fa-comment-dots"></i>
                <?php echo langDefineGet(JK_LANG, 'smsir_temps', 'id', $smsTemplate['id']) ?>
            </button>
            <?php
        }
    }
    global $View;
    $View->footer_js('<script>
function SMSPanelSend(smsID,number,ticketID=\'\') {
  $("#modal_global").modal("show");
   ' . ajax_load([
            "url" => JK_DOMAIN_LANG . 'cp/smsir/ajax/sendSms',
            "success_response" => "#modal_global_body",
            "data" => "{smsID:smsID,number:number,ticketID:ticketID}",
            "loading" => [
            ]
        ]) . '
}
</script>');
    ?>
</div>
