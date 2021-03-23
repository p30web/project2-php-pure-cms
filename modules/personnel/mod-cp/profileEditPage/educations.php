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
function addEducation(fieldID=\'\') {
    $("#modal_global_title").html("'.__("edit").'");
      $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/personnel/profileEditPage/educations/formEdit',
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
        <table class="table responsive">
            <thead>
            <tr>
                <th><?php __e("grade"); ?></th>
                <th><?php __e("field title"); ?></th>
                <th><?php __e("education status"); ?></th>
                <th><?php __e("graduation date"); ?></th>
                <th><?php __e("confirmed status"); ?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $fields=$database->select('personnel_fields_rel','*',[
                "userID"=>$user['id'],
                "ORDER"=>["ID"=>"DESC"]
            ]);
            if(sizeof($fields)>=1){
                foreach($fields as $field){
                    ?>
                    <tr>
                        <td><?php echo \Joonika\Modules\Personnel\gradeTitle($field['grade']); ?></td>
                        <td><?php echo \Joonika\Modules\Personnel\fieldTitle($field['fieldID']); ?></td>
                        <td><?php echo \Joonika\Modules\Personnel\educationStatus($field['type']); ?></td>
                        <td><?php echo \Joonika\Idate\date_int("Y/m/d",$field['datetime']); ?></td>
                        <td><?php echo statusReturnConfirmedUnconfirmed($field['status']); ?></td>
                        <td><button type="button" class="btn btn-info" onclick="addEducation(<?php echo $field['id'] ?>)"><i class="fa fa-edit"></i></button></td>
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
        <button type="button" class="btn btn-info" onclick="addEducation()"><i class="fa fa-plus"></i> <?php __e("add") ?></button>
    </div>
</div>
