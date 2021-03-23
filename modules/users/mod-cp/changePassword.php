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
' . ajax_validate([
        "on" => "submit",
        "formID" => "loginForm",
        "validate" => true,
        "prevent" => true,
        "url" => JK_DOMAIN_LANG . 'cp/users/changePassword/change',
        "success_response" => "#check_login_body",
        "loading" => [
        ]
    ]) . '
</script>
');
$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            <div class="row <?php echo JK_DIRECTION; ?>">
                <div class="col-12 col-md-4 offset-4">
                    <?php
                    \Joonika\Forms\form_create([
                        "id" => "loginForm",
                    ]);
                    echo \Joonika\Forms\field_text([
                        "name" => "newPassword",
                        "type" => "password",
                        "title" => __("new password"),
                        "direction" => "ltr",
                        "ColType" => "12,12",
                    ]);
                    echo \Joonika\Forms\field_text([
                        "name" => "newPasswordC",
                        "type" => "password",
                        "title" => __("confirm new password"),
                        "direction" => "ltr",
                        "ColType" => "12,12",
                    ]);
                    ?>
                    <div id="check_login_body"></div>
                    <!-- .form-group -->
                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block" type="submit"><?php __e("change") ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php

$View->foot();