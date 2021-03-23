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
                <span class="sr-only"><?php __e("Sign In") ?></span>
            </h1>
            <?php
            if (jk_options_get('registrationAvailable')==1) {
                ?>
                <p>
                    <?php __e("Don't have a account?") ?>

                    <a href=""><?php __e("Create One") ?></a>
                </p>
                <?php
            }
            ?>
        </header>
        <!-- form -->
        <?php
        //        print_r($form);
        \Joonika\Forms\form_create([
            "id" => "loginForm",
            "class" => "auth-form"
        ]);
        echo \Joonika\Forms\field_text([
            "name" => "username",
            "title" => __("Username"),
            "direction" => "ltr",
            "ColType" => "12,12",
        ]);

        echo \Joonika\Forms\field_text([
            "type" => "password",
            "name" => "password",
            "title" => __("Password"),
            "direction" => "ltr",
            "ColType" => "12,12",
        ]);
        ?>
        <div id="check_login_body"></div>
        <!-- .form-group -->
        <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block" type="submit"><?php __e("login") ?></button>
        </div>

        <!-- /.form-group -->
        <!-- .form-group -->

            <div class="form-group text-center">
                <div class="custom-control custom-control-inline custom-checkbox">
                    <?php
                    echo \Joonika\Forms\field_check(
                        [
                            "name" => "remember",
                            "direction" => "ltr",
                            "title" => __("remember me"),
                            "ColType" => "12,12",
                        ]
                    );
                    ?>
                </div>
            </div>

        <!-- /.form-group -->
        <!-- recovery links -->
<?php
if (jk_options_get('forgotLink')==1) {
    ?>
    <div class="text-center pt-3">
        <a href="<?php echo JK_DOMAIN_LANG ?>cp/main/forgot" class="page-link"><?php __e("forgot ?") ?></a>
    </div>
    <?php
}
    ?>
        <!-- /recovery links -->
        <?php

        echo \Joonika\Forms\form_end();
        ?>
        <!-- /.auth-form -->
        <!-- copyright -->
    </main>

<?php
$View->footer_js('
<script>
' . ajax_validate([
        "on" => "submit",
        "formID" => "loginForm",
        "validate" => true,
        "prevent" => true,
        "url" => JK_DOMAIN_LANG . 'cp/main/login/logincheck',
        "success_response" => "#check_login_body",
        "loading" => [
        ]
    ]) . '
</script>');
$View->foot();