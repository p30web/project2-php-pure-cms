<?php
if(!defined('jk')) die('Access Not Allowed !');
global $Route;
global $View;
global $Theme;
global $database;

if(!isset($Route->path[0])){
    error404();
    die;
}

$tag=urldecode($Route->path[1]);
$tagids=$database->select('jk_data_tags',"id",[
        "title"=>$tag,
]);
if(sizeof($tagids)==0){
    $tagids=0;
}
$founddata=$database->select('jk_data_tags_rel',"dataID",[
        "tagID"=>$tagids
]);

$getPosts=$database->select('jk_data','*',[
    "AND"=>[
        "status"=>"active",
        "datetime[<=]"=>date("Y/m/d H:i:s"),
        "id"=>$founddata
    ],
]);
if(sizeof($getPosts)>=1){
    $desc="";
    $break=0;
    foreach ($getPosts as $getPost){
        $txtval=substr($getPost['description'],0,115);
        $desc.=str_replace("�","... ",$txtval);
        $break+=1;
        if($break==4){
            break;
        }
    }
    $desc.="...";
    $Theme->siteDescription="بایگانی: ".$desc;
}else{
    $Theme->siteDescription="بایگانی: ".$tag;
}
$View->title=$tag." | ".$View->title;
$View->head();
?>
    <div class="page-title">
        <div class="container">
            <div class="pt-5 pb-4">
                <h3 class="page-title-h3">مجله خبری آی‌پین</h3>
                <h1 class="page-sub-title-2"><?php echo $tag; ?></h1>
                <h2 class="page-title-h3"><?php echo $desc; ?></h2>
            </div>
        </div>
    </div>
    <div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-9 mt-4">
        <div class="row">
            <?php

            if(sizeof($getPosts)>=1){
                foreach ($getPosts as $getPost){
                    $thumbnail=\Joonika\Upload\getfile($getPost['thumbnail'],false,'th-255-155','file','themes/ipin/assets/img/default-255-155.png');
                    ?>
                    <a href="<?php echo JK_DOMAIN_LANG.$getPost['slug']; ?>" class="col-6 col-md-4">
                        <div class="card mb-4 shadow-sm img-overlay-card">
                            <img class="card-img-top img-overlay" src="/<?php echo $thumbnail; ?>" alt="<?php echo $getPost['title'] ?>">
                            <div class="img-overlay-middle text-center">
                                <div class="text"><?php echo $getPost['title'] ?></div>
                                <div class="text2"><?php echo $getPost['description'] ?></div>
                                <div class="btn btn-warning btn-sm">مشاهده</div>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><?php echo $getPost['title'] ?></p>
                                <div class="d-flex justify-content-between align-items-center">
<!--                                    <small class="text-muted"><i class="fa fa-eye"></i>--><?php //echo $getPost['views'] ?><!-- بازدید</small>-->
                                    <small class="text-muted"><i class="fa fa-calendar"></i> <?php echo \Joonika\Idate\date_int("d F Y",$getPost['datetime']); ?></small>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php
                }
            }else{
                ?>
                <div class="alert alert-warning">متاسفانه مطلبی یافت نشد</div>
                <?php
            }
            ?>
        </div>
        </div>
        <div class="col-12 col-md-3 mt-4">
            <div class="card card-body widget sidebar-wideget">
                <div class="sidebar-title text-right">
                    <h2>آخرین نوشته ها</h2>
                </div>
                <div class="last-post text-right">
                    <?php
$getPosts=$database->select('jk_data','*',[
    "AND"=>[
        "status"=>"active",
        "datetime[<=]"=>date("Y/m/d H:i:s"),
        "module"=>"blog_post"
    ],
]);
if(sizeof($getPosts)>=1) {
    foreach ($getPosts as $getPost) {
        $thumbnail=\Joonika\Upload\getfile($getPost['thumbnail'],false,'th-70-70','file','themes/ipin/assets/img/default-70-70.png');
        ?>
        <div class="item">
            <div class="img float-right"><a href="<?php echo JK_DOMAIN_LANG.$getPost['slug']; ?>"><img src="/<?php echo $thumbnail; ?>" alt=""></a>
            </div>
            <a class="title" href="<?php echo JK_DOMAIN_LANG.$getPost['slug']; ?>"><?php echo $getPost['title'] ?></a>
            <div class="date"><i class="fa fa-clock-o"></i> <?php echo \Joonika\Idate\date_int("d F Y",$getPost['datetime']); ?></div>
            <div class="clearfix"></div>
        </div>
        <?php
    }
}
        ?>
                </div>
            </div>


            <div class="card card-body widget sidebar-wideget widget_categories">
                <div class="sidebar-title text-right">
                    <h2>دسته بندی ها</h2>
                </div>
                <ul>
                    <?php
$getPosts=$database->select('jk_data','*',[
    "AND"=>[
        "status"=>"active",
        "datetime[<=]"=>date("Y/m/d H:i:s"),
        "module"=>"blog_category"
    ],
]);
if(sizeof($getPosts)>=1) {
    foreach ($getPosts as $getPost) {
        ?>
        <li><a href="<?php echo JK_DOMAIN_LANG.$getPost['slug'] ?>"><?php echo $getPost['title'] ?></a></li>
        <?php
    }
}
        ?>
                </ul>
            </div>


            <div class="widget sidebar-wideget widget_categories">
                <div class="sidebar-title text-right">
                    <h2>پست های اینستاگرام</h2>
                    <div class="row">
                        <div class="col-6 margin-bottom-20px"><a href="https://www.instagram.com/ipinbar/"><img src="<?php echo THEME_CDN; ?>/themes/ipin/assets/img/ipin.jpg"
                                                                               alt=""></a></div>
                        <div class="col-6 margin-bottom-20px"><a href="https://www.instagram.com/ipinbar/"><img src="<?php echo THEME_CDN; ?>/themes/ipin/assets/img/ipin2.jpg"
                                                                               alt=""></a></div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<?php
$View->foot();
