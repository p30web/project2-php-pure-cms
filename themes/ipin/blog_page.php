<?php
if(!defined('jk')) die('Access Not Allowed !');
global $View;
global $Theme;
global $Route;
global $database;
if(!isset($Route->path[0])){
    error404();
    die;
}
$data=$database->get('jk_data',"*",[
    "AND"=>[
        "status"=>["active","draft"],
        "module"=>"blog_page",
        "slug"=>urldecode($Route->path[0]),
    ]
]);
if(!isset($data['id'])){
    error404();
    die;
}
$View->title=$data['title']." | ".$View->title;
$Theme->siteDescription=$data['description'];
$thumbnail=\Joonika\Upload\getDataThumbail($data['id'],'th-255-155',false,'themes/ipin/assets/img/default-255-155.png');
\Joonika\Modules\Blog\datePlusView($data['id']);
$data['text']=\Joonika\Modules\Blog\textView($data['text']);
if($data['template']!='default' && file_exists(JK_DIR_THEMES.'ipin/pages/'.$data['template'])){
include_once (JK_DIR_THEMES.'ipin/pages/'.$data['template']);
}else{
$View->head();
?>
    <div class="page-title">
        <div class="container">
            <div class="pt-5 pb-4">
                <h1 class="page-title-h2"><?php echo $data['title'] ?></h1>
                <div class="page-sub-title pt-3"><?php echo $data['description'] ?></div>
            </div>
        </div>
    </div>
<div class="container">
    <div class="row">
        <div class="col-12 col-md-9 mt-4">
        <div class="row ">
            <div class="card col-12 flex-md-row mb-4 shadow-sm h-md-250 post-standard">
                <img class="card-img-right flex-auto" src="/<?php echo $thumbnail; ?>" alt="<?php echo $data['title']; ?>">
                <div class="card-body d-flex flex-column align-items-md-start align-items-center">
                    <h3 class="mb-0 ">
                        <a class="text-dark" href=""><?php echo $data['title'] ?></a>
                    </h3>
                    <p class="card-text mb-auto d-none d-md-block mt-md-2"><?php echo $data['description'] ?></p>
                </div>
            </div>
            <div class="card post-standard col-12">
                <div class="card-body entry-content  text-justify">
                    <p>
                        <?php
                        echo $data['text'];
                        ?>
                    </p>
                <!-- Post tags -->
                <hr/>
                    <?php
                    $tags=\Joonika\Modules\Blog\tagsGetFromData($data['id'],'array');
                    if(sizeof($tags)>=1){
                    ?>
                    <div class="post-tags float-right">
                        <?php
                        foreach ($tags as $tag){
                            ?>
                            <a href="<?php echo JK_DOMAIN_LANG.'tag/'.$tag; ?>" rel="tag"><?php echo $tag; ?></a>
                            <?php
                        }
                        ?>
                    </div>

                    <?php
                    }
                    ?>
                    <div class="clearfix"></div>
                </div>

            </div>


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
    "ORDER"=>["id"=>"DESC"],
    "LIMIT"=>[0,10]
]);
if(sizeof($getPosts)>=1) {
    foreach ($getPosts as $getPost) {
        $thumbnail=\Joonika\Upload\getDataThumbail($getPost['id'],'th-70-70',false,'themes/ipin/assets/img/default-255-155.png');
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
}
