<?php

namespace Joonika\Modules\Telegram;

if (!defined('jk')) die('Access Not Allowed !');

class Telegram
{
    /**
     * Users constructor.
     */
    public function __construct()
    {
    }

}
function send($botID, $to, $text, $reply_markup = '')
{
    if (is_array($to) && sizeof($to) >= 1) {
        foreach ($to as $t) {
            req($botID, 'sendMessage', [
                'chat_id' => $t,
                'text' => $text,
                'parse_mode' => "HTML",
                'reply_markup' => $reply_markup,
            ]);
        }
    } else {
        req($botID, 'sendMessage', [
            'chat_id' => $to,
            'text' => $text,
            'parse_mode' => "HTML",
            'reply_markup' => $reply_markup,
        ]);
    }
}

function edit($botID, $to, $message_id, $text, $reply_markup = '')
{
    if (is_array($to) && sizeof($to) >= 1) {
        foreach ($to as $t) {
            if ($reply_markup != '') {
                req($botID, 'editMessageText', [
                    'chat_id' => $t,
                    'message_id' => $message_id,
                    'text' => $text,
                    'parse_mode' => "HTML",
                    'reply_markup' => $reply_markup,
                ]);
            } else {
                req($botID, 'editMessageText', [
                    'chat_id' => $t,
                    'message_id' => $message_id,
                    'text' => $text,
                    'parse_mode' => "HTML",
                ]);
            }
        }
    } else {
        if ($reply_markup != '') {
            req($botID, 'editMessageText', [
                'chat_id' => $to,
                'message_id' => $message_id,
                'text' => $text,
                'parse_mode' => "HTML",
                'reply_markup' => $reply_markup,
            ]);
        } else {
            req($botID, 'editMessageText', [
                'chat_id' => $to,
                'message_id' => $message_id,
                'text' => $text,
                'parse_mode' => "HTML",
            ]);
        }
    }
}

function req($botID, $method, $datas = [])
{
    global $database;
    $api = $database->get("telegram_bots", 'api', [
        "id" => $botID
    ]);
    $url = "https://tg.shetab.xyz/req/bot$api/$method";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($datas));
    $res = curl_exec($ch);
    if (curl_error($ch)) {
        var_dump(curl_error($ch));
    } else {
        return json_decode($res);
    }
}