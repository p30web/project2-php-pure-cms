<?php

namespace Joonika\Modules\Cp;
if (!defined('jk')) die('Access Not Allowed !');


class Dashboard
{
    private $widgets = [];

    /**
     * Users constructor.
     */
    public function __construct()
    {

    }

    public function set_widget($name, $view = '')
    {
        array_push($this->widgets, [
            'name' => $name,
            'view' => $view,
        ]);
    }

    public function get_widgets()
    {
        global $database;
        $widgets = $this->widgets;
        if (sizeof($widgets) >= 1) {
            foreach ($widgets as $item) {
                $get = $database->get('cp_dashboard_widgets', '*', [
                    'name' => $item['name'],
                ]);
                if (!$get['id']) {
                    $database->insert('cp_dashboard_widgets', [
                        'name' => $item['name'],
                        'view' => $item['view'],
                    ]);
                } else {
                    $database->update('cp_dashboard_widgets', [
                        'view' => $item['view'],
                    ], [
                        "id" => $get['id']
                    ]);
                }
            }

            $wids = $database->select('cp_dashboard_widgets', 'view', [
                "status" => "active",
                "ORDER" => ["sort" => "DESC"],
            ]);
            foreach ($wids as $wid) {
                if (function_exists($wid->view)) {
                    call_user_func($wid->view);
                } else {
                    $database->update('cp_dashboard_widgets', [
                        'status' => 'removed',
                    ], [
                        "view" => $wid->view
                    ]);
                }

            }
        }

    }


}