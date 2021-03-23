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
        "url" => JK_DOMAIN_LANG . 'cp/personnel/profileEditPage/basics/formEdit',
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
                <td class="bg-info text-white"><?php __e("name") ?></td>
                <td><?php echo \Joonika\Modules\Users\sexTitle($user['sex']).' '.nickName($user['id']); ?></td>
            </tr>
            <tr>
                <td class="bg-info text-white"><?php __e("username") ?></td>
                <td class="ltr text-left"><?php echo $user['username']; ?></td>
            </tr>
            <tr>
                <td class="bg-info text-white"><?php __e("email") ?></td>
                <td class="ltr text-left"><?php echo $user['email']; ?></td>
            </tr>
            <tr>
                <td class="bg-info text-white"><?php __e("personnel id") ?></td>
                <td class="ltr text-left"><?php echo $person['personnelID']; ?></td>
            </tr>
            <tr>
                <td class="bg-info text-white"><?php __e("birthday") ?></td>
                <td class="ltr text-left"><?php echo \Joonika\Idate\date_int("Y/m/d",$person['birthday']); ?></td>
            </tr>
            <tr>
                <td class="bg-info text-white"><?php __e("marital status") ?></td>
                <td class="ltr text-left"><?php echo \Joonika\Modules\Personnel\maritalStatus($person['maritalStatus']); ?></td>
            </tr>
            <tr>
                <td class="bg-info text-white"><?php __e("spouse name") ?></td>
                <td class="ltr text-left"><?php echo $person['spouseName']; ?></td>
            </tr>
            <tr>
                <td class="bg-info text-white"><?php __e("children count") ?></td>
                <td class="ltr text-left"><?php echo $person['children']; ?></td>
            </tr>
            <tr>
                <td class="bg-info text-white"><?php __e("national code") ?></td>
                <td class="ltr text-left"><?php echo $person['nationalCode']; ?></td>
            </tr>
            <tr>
                <td class="bg-info text-white"><?php __e("military status") ?></td>
                <td class="ltr text-left"><?php echo \Joonika\Modules\Personnel\militaryStatus($person['militaryStatus']); ?></td>
            </tr>
            <tr>
                <td class="bg-info text-white"><?php __e("address") ?></td>
                <td><?php echo $person['address']; ?></td>
            </tr>
            <tr>
                <td class="bg-info text-white"><?php __e("phone") ?></td>
                <td class="ltr text-left"><?php echo $person['phone']; ?></td>
            </tr>
            </tbody>
        </table>
        <div class="clearfix"></div>
        <hr/>
        <button type="button" class="btn btn-info" onclick="editBasics(<?php echo $user['id'] ?>)"><i class="fa fa-edit"></i> <?php __e("edit") ?></button>
    </div>
</div>
