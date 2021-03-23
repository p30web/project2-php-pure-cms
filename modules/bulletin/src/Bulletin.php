<?php
/**
 * Created by PhpStorm.
 * User: ipin
 * Date: 30/12/2018
 * Time: 03:49 PM
 */

namespace Joonika\Modules\bulletin;

class Bulletin
{
    private $data = [];

    public function set_data($title, $text, $status)
    {
        // get data for validation
        $this->data = [
            'title' => $title,
            'text' => $text,
            'status' => $status,
        ];

        $filter = [
            'title' => ['filter' => 'FILTER_SANITIZE_STRING'],
            'text' => ['filter' => 'FILTER_SANITIZE_STRING'],
            'status' => ['filter' => 'FILTER_SANITIZE_STRING'],
        ];

        if (filter_var_array($this->data, $filter)) {
            //if data is valid insert into database (in table bulletin)
            $this->insert_announce($this->data);
        } else {
            //if data is not valid
            echo 'your input is invalid';
        }
    }

    public function list_announce($all = false, $group = null, $user_id = null)
    {
        global $database;
        if ($all === true) {
            $store = $database->select("bulletin", "*");
            return $store;
        } elseif (isset($group) && $group != '') {
            $sql = "select users.id , bulletin.title , bulletin.text , bulletin.status from users
            right join bulletin_middle on users.id = bulletin_middle.user_id
            right join bulletin on bulletin_middle.announce_id = bulletin.id";
            $store = $database->query($sql);
            return $store;
        } elseif (isset($user_id)) {
            $store = $database->select("bulletin", "*", ["userid" => $user_id]);
            return $store;
        } else {
            $store = $database->select("bulletin", "*");
            return $store;
        }
    }

    public function insert_announce($input)
    {
        global $database;
        if ($database->insert('bulletin', $input)) {
            header("location:" . $_SERVER['HTTP_REFERER']);
            $_SESSION['msg'] = 'insert data is success';
        }
    }

    public function update_announce($id)
    {

    }

    public function delete_announce($id)
    {

    }
}