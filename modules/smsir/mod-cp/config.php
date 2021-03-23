<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
$Users->loggedCheck();
if (!$ACL->hasPermission('smsir_config')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
$Cp->setSidebarActive('smsir/config');
$View->footer_js( '
<script>
      ' . ajax_validate([
        "on" => "submit",
        "formID" => "smsSettingForm",
        "url" => JK_DOMAIN_LANG . 'cp/smsir/config/saveConfig',
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
                "id"=>"smsSettingForm",
                "class"=>"row",
            ]);
            ?>
            <div class="col-12">
                <?php
                $data['smsirAPIKey']=jk_options_get("smsirAPIKey");
                $data['smsirSecretKey']=jk_options_get("smsirSecretKey");
                $data['smsirAPIURL']=jk_options_get("smsirAPIURL");

                echo '<div class="col-md-4">';
                echo \Joonika\Forms\field_text([
                    "name"=>"smsirAPIKey",
                    "title"=>"API Key",
                    "direction"=>"ltr",
                    "ColType"=>"12,12",
                ]);
                echo '</div>';
                echo '<div class="col-md-4">';
                echo \Joonika\Forms\field_text([
                    "name"=>"smsirSecretKey",
                    "title"=>"API Secret Key",
                    "direction"=>"ltr",
                    "ColType"=>"12,12",
                    ]);
                echo '</div>';
                echo '<div class="col-md-4">';
                echo \Joonika\Forms\field_text([
                    "name"=>"smsirAPIURL",
                    "title"=>"API URL",
                    "direction"=>"ltr",
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