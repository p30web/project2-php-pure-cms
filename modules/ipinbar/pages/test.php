<?php
die;
global $database;
$datas = [];
$notes = $database->select('crm_tickets_notes_module_rel', 'noteID', [
    "GROUP" => "noteID"
]);
if (sizeof($notes) >= 1) {
    new \Joonika\Modules\Crm\Crm();
    foreach ($notes as $note) {
        $vas = $database->select('crm_tickets_notes_module_rel', '*', [
            "noteID" => $note
        ]);
//		print_r($vas);
        if (sizeof($vas) >= 1) {
            $ipinNum = "";
            $countries = [];
            $provinces = [];
            foreach ($vas as $va) {
                $ddate=\Joonika\Modules\Crm\noteData($note);
                if ($va['var'] == "ipinNumber") {
                    $ipinNum = $va['value'];
                } elseif ($va['var'] == 'countryFav') {
                    array_push($countries, ['value' => $va['value'], 'creator' => $ddate['userID'], 'datetime' => $ddate['datetime']]);
                } elseif ($va['var'] == 'provinceFav') {
                    array_push($provinces, ['value' => $va['value'], 'creator' => $ddate['userID'], 'datetime' => $ddate['datetime']]);
                }
//                print_r($va);
//                echo module
            }

//			echo $ipinNum;
            if (sizeof($countries) >= 1 || sizeof($provinces) >= 1) {
                array_push($datas, [
                    "number" => $ipinNum,
                    "countries" => $countries,
                    "provinces" => $provinces,
                ]);
            }


        }
    }
}
//print_r($datas);
//die;
if (sizeof($datas) >= 1) {
    foreach ($datas as $data) {
        if (sizeof($data['countries']) >= 1) {
            foreach ($data['countries'] as $c) {
                $hasc=$database->has('ipinbar_favorites',[
                   "AND"=>[
                       "status" => "active",
                       "type" => "country",
                       "origin" => $data['number'],
                       "value" => $c['value'],
                   ]
                ]);
                if(!$hasc){

                $database->insert('ipinbar_favorites', [
                    "type" => "country",
                    "origin" => $data['number'],
                    "value" => $c['value'],
                    "creator" => $c['creator'],
                    "datetime" => $c['datetime'],
                ]);
                }

            }
        }
        if (sizeof($data['provinces']) >= 1) {
            foreach ($data['provinces'] as $c) {
                $hasc=$database->has('ipinbar_favorites',[
                    "AND"=>[
                        "status" => "active",
                        "type" => "country",
                        "origin" => $data['number'],
                        "value" => $c['value'],
                    ]
                ]);
                if(!$hasc){


                $database->insert('ipinbar_favorites', [
                    "type" => "province",
                    "origin" => $data['number'],
                    "value" => $c['value'],
                    "creator" => $c['creator'],
                    "datetime" => $c['datetime'],
                ]);
                }

            }
        }
    }
}