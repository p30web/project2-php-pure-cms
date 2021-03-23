<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_profile')) {
    error403();
    die;
}
global $View;
global $Users;
global $Route;
global $database;
global $Cp;
$Cp->setSidebarActive('personnel/profile');
$View->header_styles_files("/modules/personnel/files/style.css");
$View->footer_js('
<script>

</script>
');
global $lnkProfile;

if (isset($Route->path[2]) && is_numeric($Route->path[2])) {
    if (!$ACL->hasPermission('personnel_info_all')) {
        error403();
        die;
    }
    $userID = $Route->path[2];
    $lnkProfile=[
        "info"=>JK_DOMAIN_LANG.'cp/personnel/profile/'.$userID,
        "update"=>JK_DOMAIN_LANG.'cp/personnel/profileEdit/'.$userID,
        "checkActive"=>3,
    ];
} else {
    $userID = JK_LOGINID;
    $lnkProfile=[
        "info"=>JK_DOMAIN_LANG.'cp/personnel/profile',
        "update"=>JK_DOMAIN_LANG.'cp/personnel/profileEdit',
        "checkActive"=>2,
    ];
}
$user = $database->get('jk_users', '*', [
    "id" => $userID
]);

$View->head();


?>
    <!-- Content area -->
    <div class="row">

        <!-- Inner container -->
        <div class="col-12 col-md-3">

            <?php
            include_once (__DIR__.'/profile/sidebar.php')
            ?>


        </div>
        <!-- /left sidebar component -->


        <!-- Right content -->
        <div class="col-12 col-md-9">
            <?php
            $tempPath=$Route->path;
            $pget="";
            if(isset($tempPath[2]) && is_numeric($tempPath[2]) && isset($tempPath[3])){
                $pget=$tempPath[3];
            }elseif(isset($tempPath[2]) && !is_numeric($tempPath[2])){
                $pget=$tempPath[2];
            }

            if($pget!=""){
                if(file_exists(__DIR__.'/profileEditPage/'.$pget.'.php')){
                    require_once (__DIR__.'/profileEditPage/'.$pget.'.php');
                }else{
                    error404();
                }
            }else{
                ?>
                <div class="card card-body"><?php __e("please fill all forms by using top menu") ?></div>
                <?php
            }

            ?>
        </div>
        <!-- /right content -->

    </div>
    <!-- /inner container -->

    <!-- /content area -->

<?php
$View->foot();