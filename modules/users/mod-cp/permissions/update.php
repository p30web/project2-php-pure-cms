<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_permissions')) {
    error403();
    die;
}
global $database;

function getDirContents_permissions($dir,$module=0, &$results = array())
{
    global $permissions;
    if (file_exists($dir)) {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DS . $value);
            if (!is_dir($path)) {
                if (strpos($path, '.php') !== false) {
                    if(substr($dir,0,strlen(JK_DIR_MODULES))){
                        $moduleK=str_replace(JK_DIR_MODULES,'',$dir);
                        $moduleA=explode(DS,$moduleK);
                        $module=$moduleA[0];
                    }
                    $results[] = [
                        "module"=>$module,
                        "path"=>$path,
                    ];
                }
            } else if ($value != "." && $value != "..") {

                if($dir==JK_DIR_MODULES){
                    $module=$value;
                    array_push($permissions, [
                        "var" => $value,
                        "module" => $value,
                    ]);
                }
                getDirContents_permissions($path,$module, $results);

            }
        }
        return $results;
    }
}
global $permissions;
$permissions = [];
$filesgetina = [];

$new = getDirContents_permissions( JK_DIR_INCLUDES . '/');

if (sizeof($new) >= 1) {
    foreach ($new as $ne) {
        array_push($filesgetina, [
                "path" => $ne['path'],
                "module"=>"core"
            ]
        );
    }
}


$theme = getDirContents_permissions(JK_DIR_THEMES);

if (sizeof($theme) >= 1) {
    foreach ($theme as $ne) {
        array_push($filesgetina, [
                "path" => $ne['path'],
                "module"=>"themes"
            ]
        );
    }
}


$new = getDirContents_permissions(JK_DIR_MODULES);
//print_r($new);
//die;
if (sizeof($new) >= 1) {
    foreach ($new as $ne) {
        array_push($filesgetina, [
                "path" => $ne['path'],
                "module" => $ne['module'],
            ]
        );
    }
}


    if (sizeof($filesgetina) >= 1) {
    foreach ($filesgetina as $filesget) {
        $filegetin = file_get_contents($filesget['path']);
        //preg_match_all("/(?:__|__e)\((?:\"|')(.*?)(?:\"|')/", $filegetin, $matches);
        preg_match_all("'(?:hasPermission)\((.*?)\)'si", $filegetin, $matches);
        if (sizeof($matches[1]) >= 1) {
            foreach ($matches[1] as $matche) {
                if ($matche[0] == "'") {
                    $matche = rtrim($matche, "'");
                    $matche = ltrim($matche, "'");
                    array_push($permissions, [
                        "var" => $matche,
                        "module" => $filesget['module'],
                    ]);
                } elseif ($matche[0] == '"') {
                    $matche = rtrim($matche, '"');
                    $matche = ltrim($matche, '"');
                    array_push($permissions, [
                        "var" => $matche,
                        "module" => $filesget['module'],
                    ]);
                }

            }
        }
    }
}

$dbupdatetr = [];
if (sizeof($permissions) >= 1) {
    foreach ($permissions as $permission) {
        array_push($dbupdatetr,$permission['var']);
        $hasbefore = $database->has("jk_users_permissions", [
            "AND" => [
                "permKey" => $permission['var'],
                "module" => $permission['module'],
            ]
        ]);
        if (!$hasbefore) {
            $insert = $database->insert("jk_users_permissions", [
                "permKey" => $permission['var'],
                "permName" => $permission['var'],
                "module" => $permission['module'],
            ]);
        }
    }
}
if(sizeof($dbupdatetr)>=1){
    $idsRem=$database->select("jk_users_permissions",'id',[
        "permKey[!]"=>$dbupdatetr
    ]);
    if(sizeof($idsRem)>=1){
        $database->delete('jk_users_perms_groups',[
            "permID"=>$idsRem
        ]);
        $database->delete('jk_users_perms_users',[
            "permID"=>$idsRem
        ]);
        $database->delete('jk_users_permissions',[
            "id"=>$idsRem
        ]);
    }


}
echo alert([
    "type" => "success",
    "elem" => "span",
    "text" => __("updated") . ' , ' . __("please wait")
]);
echo redirect_to_js('',1000);