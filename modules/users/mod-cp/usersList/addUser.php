<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_add')) {
    error403();
    die;
}
global $View;
global $Route;
global $database;
if (isset($_POST['saveform']) && !isset($_POST['id'])) {

    $database->insert('jk_users', [
        "username" => $_POST['username'],
        "email" => $_POST['email'],
        "password" => hashpass($_POST['password']),
        "country" => $_POST['country'],
        "countryCode" => $_POST['countryCode'],
        "mobile" => $_POST['mobile'],
        "sex" => $_POST['sex'],
        "name" => $_POST['name'],
        "family" => $_POST['family'],
        "regDate" => date("Y/m/d H:i:s"),
        "websiteID" => $_POST['websiteID'],
    ]);
    echo redirect_to_js();
}

\Joonika\Forms\form_create([
    "id" => "userEditFrom",
]);
if (isset($_POST['id']) && $_POST['id'] != '') {
    $user = $database->get('jk_users', '*', [
        "id" => $_POST['id'],
    ]);
    if (isset($user['id'])) {
        global $data;
        $data = $user;
        echo \Joonika\Forms\field_hidden([
            "name" => "id",
            "value" => $_POST['id'],
        ]);
        if (isset($_POST['saveform'])) {
            $database->update('jk_users', [
                "username" => $_POST['username'],
                "email" => $_POST['email'],
                "country" => $_POST['country'],
                "countryCode" => $_POST['countryCode'],
                "mobile" => $_POST['mobile'],
                "sex" => $_POST['sex'],
                "name" => $_POST['name'],
                "family" => $_POST['family'],
                "websiteID" => $_POST['websiteID'],
            ], [
                "id" => $_POST['id']
            ]);
            echo redirect_to_js();
        }
    }
}
?>
    <div class="row">
        <?php
        global $data;
        echo \Joonika\Forms\field_hidden([
            "name" => "saveform",
            "value" => 1,
        ]);
        echo div_start('col-12');
        echo \Joonika\Forms\field_text(
            [
                "name" => "username",
                "direction" => "ltr",
                "title" => __("username"),
                "required" => true,
                "ColType" => "12,12",
            ]
        );
        echo div_close();

        echo div_start('col-12');
        echo \Joonika\Forms\field_text(
            [
                "name" => "email",
                "type" => "email",
                "direction" => "ltr",
                "title" => __("email"),
                "required" => true,
                "ColType" => "12,12",
            ]
        );
        echo div_close();

        if (!isset($_POST['id']) || $_POST['id'] == "") {
            echo div_start('col-12');
            echo \Joonika\Forms\field_text(
                [
                    "name" => "password",
                    "type" => "password",
                    "direction" => "ltr",
                    "title" => __("password"),
                    "required" => true,
                    "ColType" => "12,12",
                ]
            );
            echo div_close();
        }

        echo div_start('col-12');
        $array = [
            "ir" => __("iran")
        ];
        echo \Joonika\Forms\field_select(
            [
                "name" => "country",
                "title" => __("country"),
                "required" => true,
                "array" => $array,
                "ColType" => "12,12",
            ]
        );
        echo div_close();

        echo div_start('col-12');
        if (!isset($data['countryCode'])) {
            $data['countryCode'] = '98';
        }
        echo \Joonika\Forms\field_text(
            [
                "name" => "countryCode",
                "direction" => "ltr",
                "title" => __("country code"),
                "required" => true,
                "ColType" => "12,12",
            ]
        );
        echo div_close();

        echo div_start('col-12');
        echo \Joonika\Forms\field_text(
            [
                "name" => "mobile",
                "direction" => "ltr",
                "title" => __("mobile"),
                "ColType" => "12,12",
            ]
        );
        echo div_close();

        echo div_start('col-12');
        echo \Joonika\Forms\field_select(
            [
                "name" => "sex",
                "title" => __("sex"),
                "required" => true,
                "array" => [
                        "male"=>__("mr."),
                        "female"=>__("ms."),
                        ""=>__("unknown"),
                ],
                "ColType" => "12,12",
            ]
        );
        echo div_close();
        echo div_start('col-12');
        echo \Joonika\Forms\field_text(
            [
                "name" => "name",
                "title" => __("name"),
                "ColType" => "12,12",
            ]
        );
        echo div_close();

        echo div_start('col-12');
        echo \Joonika\Forms\field_text(
            [
                "name" => "family",
                "title" => __("family"),
                "ColType" => "12,12",
            ]
        );
        echo div_close();

        echo div_start('col-12');
        $array = [];
        $array[0] = __("all websites");
        $websites = $database->select('jk_websites', '*', [
        ]);
        if (sizeof($websites) >= 1) {
            foreach ($websites as $website) {
                $array[$website['id']] = $website['domain'];
            }
        }
        echo \Joonika\Forms\field_select(
            [
                "name" => "websiteID",
                "title" => __("website"),
                "ColType" => "12,12",
                "array" => $array,
            ]
        );
        echo div_close();


        ?>
    </div>
<?php
echo \Joonika\Forms\field_submit([
    "text" => __("save"),
    "ColType" => "12,12",
    "btn-class" => "btn btn-primary btn-lg btn-block",
    "icon" => "fa fa-save"
]);

\Joonika\Forms\form_end();

$View->footer_js('<script>
' . ajax_validate([
        "on" => "submit",
        "formID" => "userEditFrom",
        "url" => JK_DOMAIN_LANG . 'cp/users/usersList/addUser',
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;