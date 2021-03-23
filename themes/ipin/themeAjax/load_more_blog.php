<?php

global $database;
if(isset($_POST['lastID'])){
    $getPosts = $database->select('jk_data', '*', [
        "AND" => [
            "id[<]" => $_POST['lastID'],
            "status" => "active",
            "datetime[<=]" => date("Y/m/d H:i:s"),
            "module" => "blog_post"
        ],
        "ORDER"=>["id"=>"DESC"],
        "LIMIT"=>[0,10],
    ]);
    $dataLast=0;
    if(sizeof($getPosts)>=1){
        foreach ($getPosts as $getPost){
            $thumbnail=\Joonika\Upload\getDataThumbail($getPost['id'],'th-255-155',false,'themes/ipin/assets/img/default-255-155.png');
            ?>
            <a href="<?php echo JK_DOMAIN_LANG . $getPost['slug']; ?>" class="col-12 col-md-12">
                <div class="card flex-md-row mb-4 shadow-sm h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                        <strong class="d-inline-block mb-2 text-primary"><?php echo $getPost['title'] ?></strong>
                        <div class="mb-1 text-muted"><?php echo \Joonika\Idate\date_int("d F Y", $getPost['datetime']); ?></div>
                        <p class="card-text mb-auto"><?php echo $getPost['description'] ?></p>
                        <div class="btn btn-warning btn-sm">مشاهده</div>
                    </div>
                    <img class="card-img-right flex-auto d-none d-lg-block " style="width: 273px;height: 170px;" src="/<?php echo $thumbnail; ?>" alt="<?php echo $getPost['title'] ?>">
                </div>
            </a>
            <?php
            $dataLast=$getPost['id'];
        }
        ?>
        <script>
            reSticky();
            $("#load_more_blog").attr("data-last","<?php echo $dataLast ?>");
        </script>
<?php
    }else{
        ?>
        <script>
            $("#load_more_blog").remove();
        </script>
        <?php
    }
}
