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
                <span class="sr-only"><?php __e("reset password") ?></span>
            </h1>
        </header>
        <!-- form -->
        <?php


        //        print_r($form);
        \Joonika\Forms\form_create([
            "id" => "forgotTokenForm",
            "class" => "auth-form"
        ]);
        $error=true;
        $errorMessage=__("token not valid or expired");
        $pathTemp=$Route->path;
        if(isset($pathTemp[3])){
            global $database;
            $getToken=$database->get('jk_users_token',"*",[
                    "token"=>$pathTemp[3]
            ]);
            if(isset($getToken['id'])){
                $error=false;
            }
        }
        if($error){
            echo alertDanger($errorMessage);
        }else{
            $View->footer_js('
<script>
' . ajax_validate([
                    "on" => "submit",
                    "formID" => "forgotTokenForm",
                    "validate" => true,
                    "prevent" => true,
                    "url" => JK_DOMAIN_LANG . 'cp/main/forgot/changePassword',
                    "success_response" => "#check_login_body",
                    "loading" => [
                    ]
                ]) . '
</script>');
            echo \Joonika\Forms\field_hidden([
                "name" => "token",
                "value" => $getToken['token'],
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
            <div class="form-group">
                <button class="btn btn-lg btn-primary btn-block" type="submit"><?php __e("change password") ?></button>
            </div>
            <?php
        }
        echo \Joonika\Forms\form_end();
        ?>
    </main>

<?php

$View->foot();