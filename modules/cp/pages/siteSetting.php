<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
$Users->loggedCheck();
if (!$ACL->hasPermission('cp_siteSetting')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
$Cp->setSidebarActive('main/siteSetting');
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
$View->footer_js( '
<script>
      ' . ajax_validate([
        "on" => "submit",
        "formID" => "siteSettingForm",
        "url" => JK_DOMAIN_LANG . 'cp/main/siteSetting/update',
        "success_response" => "#siteSettingBody",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
    function add_thumbnail() {
      $("#modal_global_title").html("'.__("add thumbnail size").'");
      $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/main/siteSetting/thumbnailEdit',
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
    }    
    function edit_thumbnail(id) {
      $("#modal_global_title").html("'.__("edit thumbnail size").'");
      $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/main/siteSetting/thumbnailEdit',
        "success_response" => "#modal_global_body",
        "data" => "{id:id}",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
    }
    function remove_thumbnail(id) {
      swal({
  title: \'' . __("are you sure to remove") . '\',
  type: \'warning\',
  showCancelButton: true,
  confirmButtonColor: \'#3085d6\',
  confirmButtonText: \'' . __("Yes, delete it") . '!\',
  cancelButtonText: \'' . __("cancel") . '!\'
}).then((result) => {
if(result.value){
  ' . ajax_load([
        "data" => "{remid:id}",
        "url" => JK_DOMAIN_LANG . 'cp/main/siteSetting/thumbnailRemove',
        "success_response" => "#thumbnail_th_\"+id+\"",
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
            <?php
            global $database;
            global $data;
            $data=$database->get('jk_languages','*',[
                    "AND"=>[
                        "websiteID"=>JK_WEBSITE_ID,
                        "slug"=>JK_LANG
                    ]
            ]);
            \Joonika\Forms\form_create([
                "id"=>"siteSettingForm",
                "class"=>"row",
            ]);
            echo '<div class="col-md-6">';
            echo \Joonika\Forms\field_text([
                "name"=>"siteTitle",
                "title"=>__("Site title"),
                "ColType"=>"12,12",
            ]);
            echo '</div>';
            echo '<div class="col-md-6">';
            echo \Joonika\Forms\field_text([
                "name"=>"siteDescription",
                "title"=>__("Site description"),
                "ColType"=>"12,12",
            ]);
            echo '</div>';
            echo '<div class="col-md-12">';
            echo \Joonika\Forms\field_tags([
                "name"=>"siteKeywords",
                "title"=>__("Site keywords"),
                "ColType"=>"12,12",
            ]);
            echo '</div>';

           ?>
            <div class="col-md-12">
                <h1 class="card-title text-center text-muted"><?php __e("thumbnail setting") ?> <button class="btn btn-outline-success btn-xs" onclick="add_thumbnail()" type="button"><i class="fa fa-plus"></i></button></h1>
                <div class="row" id="thumbnail_body">

                    <?php
                   $thumbnails=$database->select('jk_thumbnails','*',[
                           "websiteID"=>JK_WEBSITE_ID
                   ]);
                   if(sizeof($thumbnails)){
                       foreach ($thumbnails as $thumbnail){
                           ?>
                           <div class="col-4" id="thumbnail_th_<?php echo $thumbnail['id']; ?>">
                           <div class="card">
                               <div class="card-header text-center">
                                   <?php echo $thumbnail['name']; ?>
                                   <button type="button" class="btn btn-light btn-xs" onclick="edit_thumbnail(<?php echo $thumbnail['id'] ?>)"><i class="fa fa-edit"></i></button>
                                   <button type="button" class="btn btn-light btn-xs" onclick="remove_thumbnail(<?php echo $thumbnail['id'] ?>)"><i class="fa fa-times"></i></button>
                               </div>
                               <div class="card-body row">
                                   <div class="col-6">
                                       <i class="fa fa-arrows-alt-v"></i>
                                       <?php __e("height"); ?>
                                       <?php echo $thumbnail['height'].'px'; ?>
                                   </div>
                                   <div class="col-6">
                                       <i class="fa fa-arrows-alt-h"></i>
                                       <?php __e("width"); ?>
                                       <?php echo $thumbnail['width'].'px'; ?>
                                   </div>
                               </div>
                           </div>
                           </div>
                           <?php
                       }
                   }
                    ?>
                </div>
            </div>
            <div class="col-12 row">
                <?php
                $data['registrationAvailable']=jk_options_get("registrationAvailable");
                $data['forgotLink']=jk_options_get("forgotLink");
                $data['defaultSendEmail']=jk_options_get("defaultSendEmail");

                $emails=emailsArray();
                echo '<div class="col-md-4">';
                echo \Joonika\Forms\field_select([
                    "name"=>"defaultSendEmail",
                    "title"=>__("default email for send"),
                    "ColType"=>"12,12",
                    "array"=>ArrayKeyEqualValue($emails),
                ]);
                echo '</div>';
                echo '<div class="col-md-4">';
                $registrationAvailable=[
                  1=>__("yes"),
                  0=>__("no")
                ];
                echo \Joonika\Forms\field_select([
                    "name"=>"registrationAvailable",
                    "title"=>__("registration available"),
                    "ColType"=>"12,12",
                    "array"=>$registrationAvailable,
                ]);
                echo '</div>';
                echo '<div class="col-md-4">';
                echo \Joonika\Forms\field_select([
                    "name"=>"forgotLink",
                    "title"=>__("forgot link"),
                    "ColType"=>"12,12",
                    "array"=>$registrationAvailable,
                ]);
                echo '</div>';

                ?>
            </div>
            <hr class="w-100"/>
            <?php

            echo '<div class="col-md-12">';
            echo \Joonika\Forms\field_submit([
                    "text"=>__("save"),
                "ColType"=>"12,12",
                "btn-class"=>"btn btn-primary btn-lg btn-block",
                    "icon"=>"fa fa-save"
            ]);
            echo '</div>';
            modal_create([
                "bg" => "success",
                "size" => "lg",
            ]);
            ?>
<div id="siteSettingBody"></div>
        </div>
    </div>

<?php
$View->foot();