<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets_config')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
$Cp->setSidebarActive('crm/ticketsConfig');
$View->header_styles_files("/modules/cp/assets/nestable/jquery.nestable.css");
$View->footer_js_files("/modules/cp/assets/nestable/jquery.nestable-".JK_DIRECTION.".js");
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
$View->footer_js( '
<script>
      ' . ajax_validate([
        "on" => "submit",
        "formID" => "EditForm",
        "url" => JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/settings/update',
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
            global $ticketsConfig;
            tab_menus($ticketsConfig, JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/',2);
            ?>
            <hr/>

            <?php
            new \Joonika\Modules\Crm\Crm();
            \Joonika\Forms\form_create([
                "id" => "EditForm"
            ]);
            global $data;

            echo '<div class="row">';
            echo '<div class="col-12 col-md-6" >';
            global $data;
            $data['defaultContactCenterTicketDepartment']=jk_options_get("defaultContactCenterTicketDepartment");
            $deps=\Joonika\Modules\Crm\ticketsDepartments();
            echo \Joonika\Forms\field_select(
                [
                    "name" => "defaultContactCenterTicketDepartment",
                    "title" => __("default contact center ticket department"),
                    "required" => true,
                    "first" => true,
                    "array" => $deps,
                    "ColType" => "12,12",
                ]
            );
            echo '</div>';
            echo '<div class="col-12 col-md-6" >';
            $data['defaultContactCenterTicketGeneral']=jk_options_get("defaultContactCenterTicketGeneral");
            echo \Joonika\Forms\field_select(
                [
                    "name" => "defaultContactCenterTicketGeneral",
                    "title" => __("contact center global"),
                    "required" => true,
                    "first" => false,
                    "array" => [
                            "0"=>__("no"),
                            "1"=>__("yes"),
                    ],
                    "ColType" => "12,12",
                ]
            );
            echo '</div>';


            echo '</div>';

            echo \Joonika\Forms\field_submit([
                "text" => __("save"),
                "ColType" => "12,12",
                "btn-class" => "btn btn-primary btn-lg ",
                "icon" => "fa fa-save"
            ]);

            \Joonika\Forms\form_end();

            modal_create([
                "bg" => "success",
            ]);
            ?>
            <div id="action_body"></div>
        </div>
    </div>

<?php

$View->foot();