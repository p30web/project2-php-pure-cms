<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('blog_pages_add')) {
    error403();
    die;
}
global $Route;
global $View;
global $Users;
global $Cp;
global $database;

$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
\Joonika\Upload\dropzone_load();
$Cp->setSidebarActive('blog/pages');
\Joonika\Idate\idateReady();

$View->head();
if(isset($Route->path[3])){
$id=$Route->path[3];
$get=$database->get('jk_data','*',[
        "AND"=>[
                "id"=>$id,
                "module"=>"blog_page",
            ]
]);
if(isset($get['id'])){
    global $data;
    $data=$get;
}
}
?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            <?php
            \Joonika\Forms\form_create([
                "id"=>'add_blog'
            ]);
            ?>
            <div class="row">
            <?php
            $dataID=0;
            if(isset($data['id'])){
                echo \Joonika\Forms\field_hidden([
                        "name"=>"editID",
                        "value"=>$data['id'],
                ]);
                $dataID=$data['id'];
            }

            echo div_start('col-6');
            echo \Joonika\Forms\field_text(
                [
                    "name" => "title",
                    "title" => __("title"),
                    "required" => true,
                    "ColType" => "12,12",
                ]
            );
            echo div_close();
            echo div_start('col-6');
            echo \Joonika\Forms\field_text(
                [
                    "name" => "slug",
                    "direction" => "ltr",
                    "title" => __("slug"),
                    "required" => true,
                    "ColType" => "12,12",
                ]
            );
            \Joonika\Forms\slugControl('title','slug');
            echo div_close();

            echo div_start('col-12');

            \Joonika\Forms\field_editor_html([
                "name"=>"text",
            ]);

            echo div_close();

            echo div_start('col-12');

            echo \Joonika\Forms\field_textarea([
                "name"=>"description",
                "title"=>__("description"),
            ]);

            echo div_close();

            $thumbnails=\Joonika\Upload\getThumbnails(JK_WEBSITE_ID);
            if(sizeof($thumbnails)>=1){
                foreach ($thumbnails as $thumbnail){
                    $data['thumbnail_'.$thumbnail['id']]=\Joonika\Modules\Blog\getDataTh($dataID,$thumbnail['id']);
                    echo div_start('col-4');
                    echo \Joonika\Upload\field_upload([
                        "title" => __("image").' '.$thumbnail['name'],
                        "name" => "thumbnail_".$thumbnail['id'],
                        "ColType"=>'12,12',
                        "maxfiles"=>1,
                        "thMaker"=>0,
                        "module"=>"blog_post",
                        "text"=>__('Drop files to upload'),
                    ]);
                    echo div_close();
                }
            }


            echo div_start('w-100','',true);
            echo div_start('col-4');

            echo \Joonika\Idate\field_date([
                    "title"=>__("publish time"),
                    "name"=>"datetime_s",
                    "format"=>"6",
                ]
            );

            echo div_close();
            echo div_start('col-4');
            $array = [
                "default" => __("default"),
            ];
            $files1 = @scandir(JK_DIR_THEMES.$Route->theme.DS . 'pages' . DS);
            if (isset($files1) && is_array($files1) && sizeof($files1) >= 1) {
                foreach ($files1 as $fl1) {
                    if ($fl1 != '.' && $fl1 != '..') {
                        $array[$fl1] = $fl1;

                    }
                }
            }
            echo \Joonika\Forms\field_select([
                "name" => "template",
                "title" => __("template file"),
                "ColType" => '12,12',
                "array" => $array,
                "direction" => "ltr",
                "required" => true
            ]);

            echo div_close();
            echo div_start('col-6');
            $tags='';
            $tags=\Joonika\Modules\Blog\tagsGetFromData($dataID);
            echo \Joonika\Forms\field_tags([
                "name"=>"tags",
                "value"=>$tags,
                "title"=>__("tags"),
                "ColType"=>"12,12",
            ]);

            echo div_close();
            echo div_start('w-100','',true);

            echo div_start('col-md-4');
            echo \Joonika\Forms\field_select([
                "name" => "status",
                "title" => __("status"),
                "ColType" => '12,12',
                "array" => [
                    "active"=>__("published"),
                    "draft"=>__("draft"),
                ],
                "direction" => "ltr",
                "required" => true
            ]);
            echo div_close();
            echo div_start('w-100','',true);
            echo \Joonika\Forms\field_submit([
                'btn-class'=>"btn btn-success btn-block",
            ]);
            echo div_start('','check_form',true);
            ?>
            </div>
            <?php

\Joonika\Forms\form_end();
            ?>
        </div>
    </div>

<?php
$View->footer_js('
<script>
' . ajax_validate([
        "on" => "submit",
        "formID" => "add_blog",
        "ckeditor" => true,
        "validate" => true,
        "prevent" => true,
        "url" => JK_DOMAIN_LANG . 'cp/blog/pages/add',
        "success_response" => "#check_form",
        "loading" => [
        ]
    ]) . '
</script>');
$View->foot();