<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('cp')) {
    error403();
    die;
}
global $View;
global $database;
global $Users;
global $Cp;
//$Cp->setSidebarActive('users/usersList');

$View->footer_js( '
<script>
function changeImage() {
  $("#modal_global_title").html("'.__("change image").'");
      $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/users/changeImage/changeImage',
        "success_response" => "#modal_global_body",
        "data" => "{userID:".JK_LOGINID."}",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}
function selectAsMain(id=\'\') {
swal({
  title: \'' . __("are you sure that want to select this image as main profile image") . '\',
  type: \'warning\',
  showCancelButton: true,
  confirmButtonColor: \'#3085d6\',
  confirmButtonText: \'' . __("Yes") . '!\',
  cancelButtonText: \'' . __("cancel") . '!\'
}).then((result) => {
if(result.value){
  ' . ajax_load([
        "data" => "{id:id}",
        "url" => JK_DOMAIN_LANG . 'cp/users/changeImage/setMainImage',
        "success_response" => "#action_body",
        "loading" => [
        ]
    ]) . '
    }
});
}
</script>
');
$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-4 text-center">
                    <img src="<?php echo \Joonika\Modules\Users\profileImage(JK_LOGINID); ?>" class="img img-fluid">
                    <br/>
                    <button type="button" onclick="changeImage()" class="btn btn-info"><?php echo __("change image"); ?></button>
                </div>
                <div class="col-12 col-md-8">
                    <h5 class="text-center"><?php __e("history of your profile images") ?></h5>
                    <table class="table table-sm responsive table-bordered">
                        <tbody>
                        <?php
                        $images=$database->select('jk_users_profile_images','*',[
                                "AND"=>[
                                        "userID"=>JK_LOGINID,
                                        "status"=>"active",
                                ],
                            "ORDER"=>["id"=>"DESC"]
                        ]);
                        if(sizeof($images)>=1){
                            foreach ($images as $image){
                                ?>
                                <tr>
                                    <td><img src="<?php echo \Joonika\Upload\getfile($image['fileID']); ?>" width="80" height="80" class="img"></td>
                                    <td><?php
                                        if( \Joonika\Modules\Users\profileImage(JK_LOGINID)!='/'.\Joonika\Upload\getfile($image['fileID'],false)){
                                            ?>
                                            <button type="button" class="btn btn-info" onclick="selectAsMain(<?php echo $image['id']; ?>)"><?php __e("select as main profile") ?></button>
                                            <?php
                                        }
                                        ?></td>
                                    <td><button type="button" class="btn btn-warning"><i class="fa fa-times"></i></button></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>

                        </tbody>
                    </table>
                    <div id="action_body"></div>
                    <?php
                    modal_create([
                        "bg" => "success",
                        "size" => "lg",
                    ]);
                    ?>
                </div>

            </div>
        </div>
    </div>

<?php

$View->foot();