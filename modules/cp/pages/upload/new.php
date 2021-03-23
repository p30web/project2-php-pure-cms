<?php
if(!defined('jk')) die('Access Not Allowed !');

if(isset($_FILES['file'])) {
    include_once (JK_SITE_PATH.'modules/cp/inc/class.uploads.php');
    global $database;
    $inerted_id=0;
    if(isset($_POST['module'])){
        $folder=$_POST['module'];
    }else{
        $folder=null;
    }
    if(isset($_POST['date']) && $_POST['date']==false){
        $date=false;
    }else{
        $date=true;
    }
    if(isset($_POST['module'])){
        $module=$_POST['module'];
    }else{
        $module=null;
    }

    $upload_dir = \Joonika\Upload\upload_folder($folder,$date);

    $uploadPath = JK_SITE_PATH . $upload_dir . DS;
    $mainFile = $uploadPath. $_FILES['file']['name'];
    $handle = new \Joonika\Upload\upload($_FILES['file'], 'fa_IR');


    if ($handle->uploaded) {

        $handle->Process($uploadPath);

        if ($handle->processed) {
            $rowup=$upload_dir.$handle->file_dst_name;

            $database->insert('jk_uploads',[
                "file"=>$rowup,
                "name"=>$handle->file_dst_name,
                "creatorID"=>JK_LOGINID,
                "folder"=>$upload_dir,
                "datetime"=>date("Y/m/d H:i:s"),
                "mime"=>$handle->file_src_mime,
                "parent"=>0,
                "source"=>"original",
                "module"=>$module,
            ]);
            $inerted_id = $database->id();

$thMaker=true;
if(isset($_POST['thMaker']) && $_POST['thMaker']==0){
    $thMaker=false;
}

            if($handle->file_is_image && $thMaker){


                $ths=\Joonika\Upload\getThumbnails();
                if(sizeof($ths)>=1){
                    $irp=1;
                    foreach ($ths as $th){

                                $image_x=$th['w'];
                                $image_y=$th['h'];

                                $handle_th = new \Joonika\Upload\upload($_FILES['file'], JK_LANG_LOCALE);
                                $handle_th->mime_check = true;
                                $handle_th->allowed = array( 'image/*');
                                $handle_th->image_resize = true;
                                $handle_th->image_x = $image_x;
                                $handle_th->image_y = $image_y;
                                $handle_th->file_auto_rename = true;
                                $handle_th->file_name_body_add  = '_th_'.$th['id'];

                                if ($handle_th->uploaded) {
                                    $handle_th->Process($uploadPath);
                                    if ($handle_th->processed) {
                                        $rowup2=$upload_dir.$handle_th->file_dst_name;
                                        $handleInsert2=$database->insert('jk_uploads',[
                                            "file"=>$rowup2,
                                            "name"=>$handle_th->file_dst_name,
                                            "creatorID"=>JK_LOGINID,
                                            "folder"=>$upload_dir,
                                            "datetime"=>date("Y/m/d H:i:s"),
                                            "mime"=>$handle_th->file_src_mime,
                                            "parent"=>$inerted_id,
                                            "source"=>$th['name'],
                                            "module"=>$module,
                                        ]);
                                    }
                                }


                        $irp+=1;

                    }

                }


            }

        }

    }
    $retunparam=$inerted_id;

    if(isset($_POST['return'])){
        if($_POST['return']=='id'){
            $retunparam=$inerted_id;
        }elseif($_POST['return']=='file'){
            $retunparam=$rowup;
        }
    }
    $array=[
        'filename'=>$retunparam,
        'fileid'=>$retunparam,
    ];
    echo json_encode($array);

}