<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $View;
global $Users;
global $Cp;
global $Route;
if ($Users->isLogged()) {
    if (isset($Route->query_string['return'])) {
        $url = $Route->query_string['return'];
    } else {
        $url = JK_DOMAIN_LANG;
    }
    redirect_to($url);
}

$Cp->topHeader = false;
$View->head();

?>
    <!-- .auth -->
    <main class="auth">
        <header id="auth-header" class="auth-header">
            <h1>
                <img src="<?php $this->brandIconUrl="inverse"; echo $View->getBrandIconUrl(); ?>" alt="" height="72">
                <span class="sr-only"><?php __e("forgot password ?") ?></span>
            </h1>
        </header>
        <!-- form -->
        <?php
        //        print_r($form);
        \Joonika\Forms\form_create([
            "id" => "forgotForm",
            "class" => "auth-form"
        ]);
        echo \Joonika\Forms\field_text([
            "name" => "usernameEmail",
            "title" => __("username or email"),
            "direction" => "ltr",
            "ColType" => "12,12",
        ]);

        ?>
        <div id="check_login_body"></div>
        <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block" type="submit"><?php __e("send forgot link to email") ?></button>
        </div>
        <?php
        echo \Joonika\Forms\form_end();
        ?>
    </main>

<?php
$View->footer_js('
<script>
' . ajax_validate([
        "on" => "submit",
        "formID" => "forgotForm",
        "validate" => true,
        "prevent" => true,
        "url" => JK_DOMAIN_LANG . 'cp/main/login/forgot',
        "success_response" => "#check_login_body",
        "loading" => [
        ]
    ]) . '
</script>');
$View->foot();