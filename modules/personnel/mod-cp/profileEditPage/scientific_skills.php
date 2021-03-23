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
function addSkill(fieldID=\'\') {
    $("#modal_global_title").html("'.__("edit").'");
      $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/personnel/profileEditPage/scientific_skills/formEdit',
        "success_response" => "#modal_global_body",
        "data" => "{userID:".$user["id"].",id:fieldID}",
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
        <table class="table responsive table-sm">
            <thead>
            <tr>
                <th><?php __e("title"); ?></th>
                <th><?php __e("duration"); ?></th>
                <th><?php __e("institute"); ?></th>
                <th><?php __e("has certification ?"); ?></th>
                <th><?php __e("description"); ?></th>
                <th><?php __e("datetime"); ?></th>
                <th><?php __e("confirmed status"); ?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $skills=$database->select('personnel_scientific_skills','*',[
                "userID"=>$user['id'],
                "ORDER"=>["ID"=>"DESC"]
            ]);
            if(sizeof($skills)>=1){
                foreach($skills as $skill){
                    ?>
                    <tr>
                        <td><?php echo $skill['title']; ?></td>
                        <td><?php echo $skill['duration']; ?></td>
                        <td><?php echo $skill['institute']; ?></td>
                        <td><?php echo statusReturnYesNoInt($skill['certHas']); ?></td>
                        <td><?php echo $skill['description']; ?></td>
                        <td><?php echo \Joonika\Idate\date_int("Y/m/d",$skill['datetime']); ?></td>
                        <td><?php echo statusReturnConfirmedUnconfirmed($skill['status']); ?></td>
                        <td><button type="button" class="btn btn-info" onclick="addSkill(<?php echo $skill['id'] ?>)"><i class="fa fa-edit"></i></button></td>
                    </tr>
                    <?php
                }
            }else{
                ?>
                <td colspan="5"></td>
                <?php
            }
            ?>
            </tbody>
        </table>

        <div class="clearfix"></div>
        <hr/>
        <button type="button" class="btn btn-info" onclick="addSkill()"><i class="fa fa-plus"></i> <?php __e("add") ?></button>
    </div>
</div>
