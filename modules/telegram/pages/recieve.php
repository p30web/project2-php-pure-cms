<?php
if (!defined('jk')) die('Access Not Allowed !');

global $Route;
if(isset($Route->path[2])){
    $tBotID=$Route->path[2];
global $database;
$string = json_decode(file_get_contents('php://input'));

function objectToArray( $object )
{
    if( !is_object( $object ) && !is_array( $object ) )
    {
        return $object;
    }
    if( is_object( $object ) )
    {
        $object = get_object_vars( $object );
    }
    return array_map( 'objectToArray', $object );
}

$result = objectToArray($string);
//    include_once __DIR__.'/modules/telegram/src/Telegram.php';
//    new \Joonika\Modules\Telegram();
//    \Joonika\Modules\send(1,'101492429',print_r($result,true));

if(isset($result['message']) && !isset($result['callback_query'])) {

    $from_id = '';
    $from_firstname = '';
    $from_lastname = '';
    $from_username = '';
    $from_isbot = 0;
    $from_language_code = '';
    $chat_id = '';
    $chat_text = '';
    $chat_date = '';
    $chat_type = '';
    $update_id = '';

    if(isset($result['message']['from']['id'])){
        $from_id =$result['message']['from']['id'] ;
    }
    if(isset($result['update_id'])){
        $update_id =$result['update_id'] ;
    }
    if(isset($result['message']['from']['first_name'])){
        $from_firstname = $result['message']['from']['first_name'];
    }
    if(isset($result['message']['from']['last_name'])){
        $from_lastname = $result['message']['from']['last_name'];
    }
    if(isset($result['message']['from']['username'])){
        $from_username = $result['message']['from']['username'];
    }
    if(isset($result['message']['from']['is_bot']) && $result['message']['from']['is_bot']==true){
        $from_isbot = 1;
    }
    if(isset($result['message']['from']['language_code'])){
        $from_language_code = $result['message']['from']['language_code'];
    }
    if(isset($result['message']['chat']['id'])){
        $chat_id = $result['message']['chat']['id'];
    }
    if(isset($result['message']['chat']['type'])){
        $chat_type = $result['message']['chat']['type'];
    }
    if(isset($result['message']['text'])){
        $chat_text = $result['message']['text'];
    }
    if(isset($result['message']['date'])){
        $chat_date = $result['message']['date'];
        $chat_date=date("Y/m/d H:i:s");
    }


    $insert=$database->insert('telegram_receives',[
        "botID"=>$tBotID,
        "update_id"=>$update_id,
        "from_id"=>$from_id,
        "from_firstname"=>$from_firstname,
        "from_lastname"=>$from_lastname,
        "from_username"=>$from_username,
        "from_isbot"=>$from_isbot,
        "from_language_code"=>$from_language_code,
        "chat_id"=>$chat_id,
        "chat_text"=>$chat_text,
        "chat_date"=>$chat_date,
        "chat_type"=>$chat_type,
        "data"=>json_encode($result),
    ]);

}
}