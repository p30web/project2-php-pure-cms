<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_info_edit')) {
    error403();
    die;
}
global $View;
global $Users;
global $Route;
global $database;
global $Cp;
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
$Cp->setSidebarActive('personnel/profile');
$View->header_styles_files("/modules/personnel/files/style.css");
$View->footer_js('
<script>

</script>
');
global $lnkProfile;
\Joonika\Idate\idateReady();

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

            $profileTabs = [
                [
                    "link" => 'basics',
                    "permissions" => "personnel_info_edit",
                    "icon" => "fa fa-key",
                    "title" => __("basics")
                ], [
                    "link" => 'educations',
                    "permissions" => "personnel_info_edit",
                    "icon" => "fa fa-user-graduate",
                    "title" => __("educations")
                ], [
                    "link" => 'scientific_skills',
                    "permissions" => "personnel_info_edit",
                    "icon" => "fa fa-graduation-cap",
                    "title" => __("scientific skills")
                ], [
                    "link" => 'skills',
                    "permissions" => "personnel_info_edit",
                    "icon" => "fa fa-graduation-cap",
                    "title" => __("skills")
                ], [
                    "link" => 'languages',
                    "permissions" => "personnel_info_edit",
                    "icon" => "fa fa-language",
                    "title" => __("languages")
                ], [
                    "link" => 'medical',
                    "permissions" => "personnel_info_edit",
                    "icon" => "fa fa-user-md",
                    "title" => __("medical information")
                ]
            ];

            tab_menus($profileTabs, $lnkProfile['update'].'/',$lnkProfile['checkActive']);
            ?>
            <div class="">
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
        </div>
        <!-- /right content -->

    </div>
    <!-- /inner container -->

    <!-- /content area -->

<?php
modal_create([
    "bg" => "success",
    "size" => "lg",
]);
$View->foot();