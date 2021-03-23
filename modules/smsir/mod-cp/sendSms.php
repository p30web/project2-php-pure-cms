<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
$Users->loggedCheck();
if (!$ACL->hasPermission('smsir_sendSms')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
$Cp->setSidebarActive('smsir/sendSms');
$View->footer_js( '
<script>
      ' . ajax_validate([
        "on" => "submit",
        "formID" => "sendSmsForm",
        "url" => JK_DOMAIN_LANG . 'cp/smsir/sendSms/send',
        "success_response" => "#action_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
      
</script>
');
$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            <?php
            global $database;
            global $data;

            \Joonika\Forms\form_create([
                "id"=>"sendSmsForm",
                "class"=>"row",
            ]);
            ?>
            <div class="col-12">
                <?php
                echo '<div class="col-md-4">';
                $lists=$database->select('smsir_temps',"id",[
                    "status"=>"active"
                ]);
                $cts=[];
                if(sizeof($lists)>=1){
                    foreach ($lists as $list){
                        $cts[$list]=langDefineGet(JK_LANG,'smsir_temps','id',$list);
                    }
                }
                echo \Joonika\Forms\field_select([
                    "name" => "tempID",
                    "ColType" => "12,12",
                    "title" => __("template"),
                    "first" => true,
                    "array" => $cts,
                    "required" => true
                ]);
                echo '</div>';
                echo '<div class="col-md-4">';
                echo \Joonika\Forms\field_textarea([
                    "name"=>"numbers",
                    "title"=>__("numbers"),
                    "help"=>__("every line one phone"),
                    "direction"=>"rtl",
                    "ColType"=>"12,12",
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
            <div id="action_body"></div>
        </div>
    </div>

<?php
$View->foot();