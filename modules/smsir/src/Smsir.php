<?php

namespace Joonika\Modules\Smsir;

if (!defined('jk')) die('Access Not Allowed !');

class Smsir
{
    /**
     * Users constructor.
     */
    public function __construct()
    {
    }

}

function sendSmsIr($mobile, $smsID, $args = [])
{
    global $database;
    try {
        $sms = $database->get('smsir_temps', '*', [
            "id" => $smsID
        ]);
        $APIKey = jk_options_get("smsirAPIKey");
        $SecretKey = jk_options_get("smsirSecretKey");
        $APIURL = jk_options_get("smsirAPIURL");

        // message data
        $dataParameterArray = [];
	    if (sizeof($args) >= 1) {
		    foreach ($args as $argK => $argV) {
			    array_push($dataParameterArray, [
				    "Parameter" => $argK,
				    "ParameterValue" => $argV
			    ]);
		    }
	    }elseif(sizeof($args)==0){
	    	parse_str($sms['vars'],$vars);
		    if(sizeof($vars)>=1){
			    foreach ($vars as $argK => $argV) {
				    array_push($dataParameterArray, [
					    "Parameter" => $argK,
					    "ParameterValue" => $argV
				    ]);
			    }
		    }
	    }
        $data = array(
            "ParameterArray" => $dataParameterArray,
            "Mobile" => $mobile,
            "TemplateId" => $sms['templateID']
        );
        include_once __DIR__ . '/SmsIR_UltraFastSend.php';

        $SmsIR_UltraFastSend = new \SmsIR_UltraFastSend($APIKey, $SecretKey, $APIURL);
        $UltraFastSend = $SmsIR_UltraFastSend->ultraFastSend($data);
        if ($UltraFastSend == "sent") {
            $database->insert('smsir_sent', [
                "text"=>$smsID,
                "phone"=>$mobile,
                "datetime"=>date("Y/m/d H:i:s"),
            ]);
        }
//        var_dump($UltraFastSend);
        return $UltraFastSend;
    } catch (\Exception $e) {
        return $e->errorMessage();
    }
}

function listTemps()
{
    global $database;
    $smsLists = $database->select('smsir_temps', '*', [
        "status" => "active"
    ]);
    $return = [];
    if (sizeof($smsLists) >= 1) {
        foreach ($smsLists as $smsList) {
            $return[$smsList['id']] = langDefineGet(JK_LANG, 'smsir_temps', 'id', $smsList['id']);
        }
    }
    return $return;
}
function lastDateSentValid($mobile,$templateID,$timeValid=300)
{
    global $database;
    $smsLists = $database->get('smsir_sent', '*', [
        "AND"=>[
            "text"=>$templateID,
            "phone"=>$mobile,
            "datetime[>=]"=>date("Y/m/d H:i:s",time()-$timeValid),
        ]
        ]);
    if(isset($smsLists['id'])){
        return false;
    }else{
        return true;
    }

}