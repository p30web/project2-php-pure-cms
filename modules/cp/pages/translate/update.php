<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('cp_translate')) {
    error403();
    die;
}

global $database;

function getDirContents_translate($dir, &$results = array())
{
    if (file_exists($dir)) {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DS . $value);
            if (!is_dir($path)) {
                if (strpos($path, '.php') !== false) {
                    $results[] = $path;
                }
            } else if ($value != "." && $value != "..") {
                getDirContents_translate($path, $results);
            }
        }
        return $results;
    }
}


$translates = [];
$filesgetina = [];


$new = getDirContents_translate( JK_DIR_INCLUDES . '/');

if (sizeof($new) >= 1) {
    foreach ($new as $ne) {
        array_push($filesgetina, [
                "path" => $ne,
            ]
        );
    }
}


$theme = getDirContents_translate(JK_DIR_THEMES);

if (sizeof($theme) >= 1) {
    foreach ($theme as $ne) {
        array_push($filesgetina, [
                "path" => $ne,
            ]
        );
    }
}


        $new = getDirContents_translate(JK_DIR_MODULES);
        if (sizeof($new) >= 1) {
            foreach ($new as $ne) {
                array_push($filesgetina, [
                        "path" => $ne,
                    ]
                );
            }
        }


if (sizeof($filesgetina) >= 1) {
    foreach ($filesgetina as $filesget) {
        $filegetin = file_get_contents($filesget['path']);
        //preg_match_all("/(?:__|__e)\((?:\"|')(.*?)(?:\"|')/", $filegetin, $matches);
        preg_match_all("'(?:__|__e)\((.*?)\)'s", $filegetin, $matches);
        if (sizeof($matches[1]) >= 1) {
            foreach ($matches[1] as $matche) {
                if ($matche[0] == "'") {
                    $matche = rtrim($matche, "'");
                    $matche = ltrim($matche, "'");
                    array_push($translates, [
                        "var" => $matche,
                    ]);
                } elseif ($matche[0] == '"') {
                    $matche = rtrim($matche, '"');
                    $matche = ltrim($matche, '"');
                    array_push($translates, [
                        "var" => $matche,
                    ]);
                }

            }
        }
    }
}

$dbupdatetr = [];

if (sizeof($translates) >= 1) {
    foreach ($translates as $translate) {
        $hasbefore = $database->has("jk_translate", [
            "AND" => [
                "var" => $translate['var'],
                "lang" => JK_LANG,
            ]
        ]);
        array_push($dbupdatetr, $translate['var']);
        if (!$hasbefore) {
            $insert = $database->insert("jk_translate", [
                "var" => $translate['var'],
                "lang" => JK_LANG,
            ]);
        } else {
            $updd = $database->get("jk_translate", '*', [
                "AND" => [
                    "var" => $translate['var'],
                    "lang" => JK_LANG,
                ]
            ]);
            if ($updd['status'] != 'active') {
                $database->update("jk_translate", [
                    "status" => "active"
                ], [
                    "ID" => $updd['id'],
                ]);
            }
        }
    }
}
if (sizeof($dbupdatetr) >= 1) {
    $updateunused = $database->delete('jk_translate', [
        "var[!]" => $dbupdatetr
    ]);
}
echo alert([
    "type" => "success",
    "elem" => "span",
    "text" => __("updated") . ' , ' . __("please wait")
]);
echo redirect_to_js('', 500);
