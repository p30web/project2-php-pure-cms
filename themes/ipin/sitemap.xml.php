<?php
global $database;
header( "Content-type: text/xml" );

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
echo "\n";

$base_url = JK_DOMAIN_LANG;

$pages=[
    [
        "link"=>"",
        "title"=>"آی‌پین",
        "priority"=>"1.0",
    ],
    [
        "link"=>"blog",
        "title"=>"مجله",
        "priority"=>"0.8",
    ],
];
$pagesdbs=$database->select('jk_data','*',[
    "AND"=>[
        "status"=>"active",
        "datetime[<=]"=>date("Y/m/d H:i:s"),
        "module"=>"blog_page"
    ],
    "ORDER"=>["id"=>"DESC"],
]);
if(sizeof($pagesdbs)>=1){
    foreach ($pagesdbs as $pagesdb){
        array_push($pages,[
            "link"=>$pagesdb['slug'],
            "title"=>$pagesdb['title'],
            "priority"=>"0.5",
        ]);
    }
}

$postsdbs=$database->select('jk_data','*',[
    "AND"=>[
        "status"=>"active",
        "datetime[<=]"=>date("Y/m/d H:i:s"),
        "module"=>"blog_post"
    ],
    "ORDER"=>["id"=>"DESC"],
]);
if(sizeof($postsdbs)>=1){
    foreach ($postsdbs as $postsdb){
        array_push($pages,[
            "link"=>$postsdb['slug'],
            "title"=>$postsdb['title'],
            "priority"=>"0.3",
        ]);
    }
}

foreach( $pages as $page ) {
        $url = $base_url . rawurlencode( $page['link'] );
    echo '<url>';
    echo "<loc>{$url}</loc>";
    echo "<priority>{$page['priority']}</priority>";
    echo '</url>';
    echo "\n";
}

echo '</urlset>';
