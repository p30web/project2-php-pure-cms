<?php

global $database;
$getNote=$database->get('tableBar_temp',"*",[
        "AND"=>[
                "status"=>"active",
                "car_type"=>$_POST['gettype'],
                "id[!]"=>$_POST['getid'],
        ],
    "ORDER"=>["id"=>"DESC"]
]);
if(!isset($getNote['id'])){
    $getLast=$database->get('tableBar_temp','*',[
            "id"=>$_POST['getid']
    ]);
    if(isset($getLast['id']) && $getLast['status']=="active"){
        $col2=$getLast['goods_type'];
        if($getLast['source']!=$getLast['destination']){
            $col3=$getLast['source'].' <span class="text-muted"> <i class="fa fa-arrow-left"></i> </span>'.$getLast['destination'];
        }else{
            $col3=$getLast['source'].' <span class="text-muted"> (درون شهری)</span>';
        }
        $col4='<span class="text-muted">کرایه: </span>'.number_format($getLast['price']).' <span class="text-muted">تومان</span> <a class="btn btn-warning btn-sm float-left p-0" href="https://cp.ipinbar.net/"><i class="fa fa-arrow-alt-circle-left"></i></a>';
        ?>
        <div class="col-12 col-md-4"><?php echo $col2; ?></div>
        <div class="col-12 col-md-4"><?php echo $col3; ?></div>
        <div class="col-12 col-md-4"><?php echo $col4; ?></div>
        <script>
            $("#get_bar_table_<?php echo $_POST['gettype'] ?>").attr("data-get",<?php echo $getLast['id'] ?>)
        </script>
        <?php
    }else{
        ?>
        <div class="col-12 col-md-4">-</div>
        <div class="col-12 col-md-4">-</div>
        <div class="col-12 col-md-4">-</div>
        <script>
            $("#get_bar_table_<?php echo $_POST['gettype'] ?>").attr("data-get",<?php echo $getLast['id'] ?>);
        </script>
        <?php
    }
}else{
    $getLast=$getNote;
    $col2=$getLast['goods_type'];
    if($getLast['source']!=$getLast['destination']){
        $col3=$getLast['source'].' <span class="text-muted"> <i class="fa fa-arrow-left"></i> </span>'.$getLast['destination'];
    }else{
        $col3=$getLast['source'].' <span class="text-muted"> (درون شهری)</span>';
    }
    $col4='<span class="text-muted">کرایه: </span>'.number_format($getLast['price']).' <span class="text-muted">تومان</span> <a class="btn btn-warning btn-sm float-left p-0" href="https://cp.ipinbar.net/"><i class="fa fa-arrow-alt-circle-left"></i></a>';
    ?>
    <script>
        var duration = 500;
                    $("#get_bar_table_<?php echo $_POST['gettype'] ?>").html("<i class='fa fa-spinner fa-spin'></i>").fadeOut(duration, function () {
                        $("#get_bar_table_<?php echo $_POST['gettype'] ?>").html('<div class="col-12 col-md-4"><?php echo $col2; ?></div>\n' +
                            '        <div class="col-12 col-md-4"><?php echo $col3; ?></div>\n' +
                            '        <div class="col-12 col-md-4"><?php echo $col4; ?></div>').fadeIn(duration).attr("data-get",<?php echo $getLast['id'] ?>);
                    });
    </script>
    <?php
}