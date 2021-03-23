<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
$Users->loggedCheck();
if (!$ACL->hasPermission('ipinbar_smsSendingSetting')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
$Cp->setSidebarActive('ipinbar/smsSendingSetting');
$View->footer_js( '
<script>
      ' . ajax_validate([
        "on" => "submit",
        "formID" => "smsSendingSetting",
        "url" => JK_DOMAIN_LANG . 'cp/ipinbar/smsSendingSetting/saveConfig',
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
                "id"=>"smsSendingSetting",
                "class"=>"row",
            ]);
            ?>
            <div class="col-12">
                <?php
                $data['smsSendingSetting_driverLink']=jk_options_get("smsSendingSetting_driverLink");
                $data['smsSendingSetting_clientsLink']=jk_options_get("smsSendingSetting_clientsLink");
                $data['smsReceiveTicketDepartment']=jk_options_get("smsReceiveTicketDepartment");
                new \Joonika\Modules\Smsir\Smsir();
                $linkSms=\Joonika\Modules\Smsir\listTemps();

                echo '<div class="col-md-4">';
                echo \Joonika\Forms\field_select([
                    "name"=>"smsSendingSetting_driverLink",
                    "title"=>__("driver link sms"),
                    "ColType"=>"12,12",
                    "array"=>$linkSms
                ]);
                echo '</div>';
                echo '<div class="col-md-4">';
                echo \Joonika\Forms\field_select([
                    "name"=>"smsSendingSetting_clientsLink",
                    "title"=>__("clients link sms"),
                    "ColType"=>"12,12",
                    "array"=>$linkSms
                ]);
                echo '</div>';
                echo '<div class="col-md-4">';
                new \Joonika\Modules\Crm\Crm();
                $departments = \Joonika\Modules\Crm\ticketsDepartments();
                echo \Joonika\Forms\field_select([
                    "name"=>"smsReceiveTicketDepartment",
                    "title"=>__("sms receive department"),
                    "ColType"=>"12,12",
                    "array"=>$departments
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