<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_info_edit')) {
    error403();
    die;
}
if (!isset($pget)) {
    error403();
    die;
}
$View->footer_js('<script>
function editBasics() {
    $("#modal_global_title").html("'.__("edit").'");
      $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/personnel/profileEditPage/medical/formEdit',
        "success_response" => "#modal_global_body",
        "data" => "{userID:".$user["id"]."}",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}

</script>')
?>
<?php
new \Joonika\Modules\Personnel\Personnel();
$person=\Joonika\Modules\Personnel\personnelDetails($user['id']);
?>
<div class="card">
    <div class="card-body">
        <table class="table table-hover table-bordered">
            <tbody>
            <tr>
                <td class="bg-info text-white"><?php __e("body weight") ?></td>
                <td class="ltr text-left"><?php echo $person['weight']; ?></td>
            </tr>
            <tr>
                <td class="bg-info text-white"><?php __e("body height") ?></td>
                <td class="ltr text-left"><?php echo $person['height']; ?></td>
            </tr>
            <tr>
                <td class="bg-info text-white"><?php __e("blood type") ?></td>
                <td class="ltr text-left"><?php echo $person['bloodType']; ?></td>
            </tr>
            </tbody>
        </table>
        <div class="clearfix"></div>
        <hr/>
        <button type="button" class="btn btn-info" onclick="editBasics(<?php echo $user['id'] ?>)"><i class="fa fa-edit"></i> <?php __e("edit") ?></button>
    </div>
</div>
