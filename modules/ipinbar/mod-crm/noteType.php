<?php
function noteType_module_smsIRSent($noteID)
{
	global $database;
	$noteVal = $database->get("crm_tickets_notes", 'note', [
		"id" => $noteID
	]);
	parse_str($noteVal, $vars);
	$number = null;
	$sms = null;
	if (isset($vars['number'])) {
		$number = $vars['number'];
	}
	if (isset($vars['smsID'])) {
		$sms = langDefineGet(JK_LANG, 'smsir_temps', 'id', $vars['smsID']);
	}
	echo __("sms") . ": " . $sms . "<br/>" . sprintf(__("sms sent to %s"), $number);
}

function noteType_ipinbar_noteFunctions($noteID)
{
	global $database;
	$vars = $database->select('crm_tickets_notes_module_rel', '*', [
		"noteID" => $noteID
	]);
	if (sizeof($vars) >= 1) {
		foreach ($vars as $var) {
			if (function_exists("ipin_field_view_" . $var['var'])) {
				call_user_func("ipin_field_view_" . $var['var'], [$var['value']]);
			}
		}
	}
}

function ipin_field_view_ipinNoteID($var = [])
{
	if (isset($var[0])) {
		global $database;
		$getIp = $database->get('ipinbar_note_modules', '*', [
			"id" => $var[0]
		]);
		$textCat = langDefineGet(JK_LANG, 'crm_tickets_note_modules', 'id', $getIp['module']);
		$text = langDefineGet(JK_LANG, 'ipinbar_note_modules', 'id', $getIp['id']);
		?>
        <div>
			<?php
			echo $textCat;
			?> :
            <strong><?php echo $text; ?></strong>
        </div>
		<?php

	}
}

function note_module_ipinbar_noteFunctions_form($args = [])
{
	global $View;
	global $database;
	global $data;
	if (isset($args['noteModuleID'])) {
		$fields = [];
		$fieldsDB = $database->select('ipinbar_note_modules', 'id', [
			"AND" => [
				"status" => "active",
				"module" => $args['noteModuleID'],
			],
			"ORDER" => ["sort" => "ASC"],
		]);
		if (sizeof($fieldsDB) >= 1) {
			foreach ($fieldsDB as $fieldDB) {
				$fields[$fieldDB] = langDefineGet(JK_LANG, 'ipinbar_note_modules', 'id', $fieldDB);
			}
		}
		echo \Joonika\Forms\field_select(
			[
				"name" => "noteModuleInput_ipinNoteID",
				"title" => __("text"),
				"required" => true,
				"first" => true,
				"ColType" => "12,12",
				"array" => $fields,
			]
		);
	}
	$origins = \Joonika\Modules\Crm\ticketOrigins($args['ticketID']);
	if (sizeof($origins) >= 1) {
		foreach ($origins as $origin) {
			if ($origin['name'] == "ContactCenter") {
				$data['noteModuleInput_ipinNumber'] = $origin['value'];
			}
		}
	}
	echo \Joonika\Forms\field_text(
		[
			"name" => "noteModuleInput_ipinNumber",
			"direction" => "ltr",
			"title" => __("ipin username"),
			"required" => true,
			"ColType" => "12,12",
		]
	);
	echo div_start('col-12', 'noteModuleInput_ipinNumber_body', true);
	$View->footer_js('<script>
    ' . ajax_load([
			"on" => "change",
			"formID" => "noteModuleInput_ipinNumber",
			"prevent" => false,
			"url" => JK_DOMAIN_LANG . 'ipinbar/searchNumber',
			"success_response" => "#noteModuleInput_ipinNumber_body",
		]) . '
</script>');
}

function note_module_ipinbar_noteFunctions_transit_form($args = [])
{
	global $View;
	global $database;
	global $data;
	if (isset($args['noteModuleID'])) {
		$countries = [];
		$fieldsDB = $database->select('jk_users_locations_countries', 'id', [
			"status" => "active",
			"ORDER" => ["sort" => "ASC"],
		]);
		if (sizeof($fieldsDB) >= 1) {
			foreach ($fieldsDB as $fieldDB) {
				$countries[$fieldDB] = langDefineGet(JK_LANG, 'jk_users_locations_countries', 'id', $fieldDB);
			}
		}
		echo \Joonika\Forms\field_select(
			[
				"name" => "noteModuleInput_countryFav[]",
				"id" => "noteModuleInput_countryFav",
				"title" => __("country"),
				"required" => true,
				"multiple" => true,
				"first" => true,
				"ColType" => "12,12",
				"array" => $countries,
			]
		);
	}
	$origins = \Joonika\Modules\Crm\ticketOrigins($args['ticketID']);
	if (sizeof($origins) >= 1) {
		foreach ($origins as $origin) {
			if ($origin['name'] == "ContactCenter") {
				$data['noteModuleInput_ipinNumber'] = $origin['value'];
			}
		}
	}
	echo \Joonika\Forms\field_text(
		[
			"name" => "noteModuleInput_ipinNumber",
			"direction" => "ltr",
			"title" => __("ipin username"),
			"required" => true,
			"ColType" => "12,12",
		]
	);
	echo div_start('col-12', 'noteModuleInput_ipinNumber_body', true);
	$View->footer_js('<script>

    ' . ajax_load([
			"on" => "change",
			"formID" => "noteModuleInput_ipinNumber",
			"prevent" => false,
			"url" => JK_DOMAIN_LANG . 'ipinbar/searchNumber',
			"success_response" => "#noteModuleInput_ipinNumber_body",
		]) . '
</script>');
}

function noteType_ipinbar_noteFunctions_transit($noteID)
{
	global $database;
	$vars = $database->select('crm_tickets_notes_module_rel', '*', [
		"noteID" => $noteID
	]);
	$countries = '';
	if (sizeof($vars) >= 1) {
		foreach ($vars as $var) {
			if ($var['var'] == 'countryFav') {
				$countries .= langDefineGet(JK_LANG, 'jk_users_locations_countries', 'id', $var['value']) . ' - ';
			}
		}
		$countries = rtrim($countries, ' - ');
	}
	echo __("countries favorite") . ' : ' . $countries;
}

function noteType_ipinbar_noteFunctions_transit_submit($vars = [])
{
	if (isset($vars['data']) && isset($vars['ticketID'])) {
		global $database;
		$data=$vars['data']['countryFav'];
		foreach ($data as $dt){
			$database->insert('ipinbar_favorites', [
				"type"=>"country",
				"origin"=>$vars['data']['ipinNumber'],
				"value"=>$dt,
				"creator"=>JK_LOGINID,
				"status"=>"active",
			]);
		}

	}
}
function note_module_ipinbar_noteFunctions_province_form($args = [])
{
	global $View;
	global $database;
	global $data;
	if (isset($args['noteModuleID'])) {
		$countries = [];
		$fieldsDB = $database->select('jk_users_locations_provinces', 'id', [
			"status" => "active",
			"ORDER" => ["sort" => "ASC"],
		]);
		if (sizeof($fieldsDB) >= 1) {
			foreach ($fieldsDB as $fieldDB) {
				$countries[$fieldDB] = langDefineGet(JK_LANG, 'jk_users_locations_provinces', 'id', $fieldDB);
			}
		}
		echo \Joonika\Forms\field_select(
			[
				"name" => "noteModuleInput_provinceFav[]",
				"id" => "noteModuleInput_provinceFav",
				"title" => __("province"),
				"required" => true,
				"multiple" => true,
				"first" => true,
				"ColType" => "12,12",
				"array" => $countries,
			]
		);
	}
	$origins = \Joonika\Modules\Crm\ticketOrigins($args['ticketID']);
	if (sizeof($origins) >= 1) {
		foreach ($origins as $origin) {
			if ($origin['name'] == "ContactCenter") {
				$data['noteModuleInput_ipinNumber'] = $origin['value'];
			}
		}
	}
	echo \Joonika\Forms\field_text(
		[
			"name" => "noteModuleInput_ipinNumber",
			"direction" => "ltr",
			"title" => __("ipin username"),
			"required" => true,
			"ColType" => "12,12",
		]
	);
	echo div_start('col-12', 'noteModuleInput_ipinNumber_body', true);
	$View->footer_js('<script>

    ' . ajax_load([
			"on" => "change",
			"formID" => "noteModuleInput_ipinNumber",
			"prevent" => false,
			"url" => JK_DOMAIN_LANG . 'ipinbar/searchNumber',
			"success_response" => "#noteModuleInput_ipinNumber_body",
		]) . '
</script>');
}

function noteType_ipinbar_noteFunctions_province($noteID)
{
	global $database;
	$vars = $database->select('crm_tickets_notes_module_rel', '*', [
		"noteID" => $noteID
	]);
	$countries = '';
	if (sizeof($vars) >= 1) {
		foreach ($vars as $var) {
			if ($var['var'] == 'provinceFav') {
				$countries .= langDefineGet(JK_LANG, 'jk_users_locations_provinces', 'id', $var['value']) . ' - ';
			}
		}
		$countries = rtrim($countries, ' - ');
	}
	echo __("province favorite") . ' : ' . $countries;
}

function noteType_ipinbar_noteFunctions_province_submit($vars = [])
{
	if (isset($vars['data']) && isset($vars['ticketID'])) {
			global $database;
				    $data=$vars['data']['provinceFav'];
				    foreach ($data as $dt){
					    $database->insert('ipinbar_favorites', [
							    "type"=>"province",
							    "origin"=>$vars['data']['ipinNumber'],
							    "value"=>$dt,
							    "creator"=>JK_LOGINID,
							    "status"=>"active",
						    ]);
                    }

	}
}

function note_module_ipinbar_favorite_form($args = [])
{
	global $View;
	global $database;
	global $data;
	if (isset($args['noteModuleID'])) {
		$countries = [];
		$fieldsDB = $database->select('ipinbar_introduction_methods', 'id', [
			"status" => "active",
			"ORDER" => ["sort" => "ASC"],
		]);
		if (sizeof($fieldsDB) >= 1) {
			foreach ($fieldsDB as $fieldDB) {
				$countries[$fieldDB] = langDefineGet(JK_LANG, 'ipinbar_introduction_methods', 'id', $fieldDB);
			}
		}
		echo \Joonika\Forms\field_select(
			[
				"name" => "noteModuleInput_introduction_methods[]",
				"id" => "noteModuleInput_introduction_methods",
				"title" => __("method"),
				"required" => true,
				"multiple" => true,
				"first" => true,
				"ColType" => "12,12",
				"array" => $countries,
			]
		);
	}
	$origins = \Joonika\Modules\Crm\ticketOrigins($args['ticketID']);
	if (sizeof($origins) >= 1) {
		foreach ($origins as $origin) {
			if ($origin['name'] == "ContactCenter") {
				$data['noteModuleInput_ipinNumber'] = $origin['value'];
			}
		}
	}
	echo \Joonika\Forms\field_text(
		[
			"name" => "noteModuleInput_ipinNumber",
			"direction" => "ltr",
			"title" => __("ipin username"),
			"required" => true,
			"ColType" => "12,12",
		]
	);
	echo div_start('col-12', 'noteModuleInput_ipinNumber_body', true);
	$View->footer_js('<script>

    ' . ajax_load([
			"on" => "change",
			"formID" => "noteModuleInput_ipinNumber",
			"prevent" => false,
			"url" => JK_DOMAIN_LANG . 'ipinbar/searchNumber',
			"success_response" => "#noteModuleInput_ipinNumber_body",
		]) . '
</script>');
}

function noteType_ipinbar_favorite($noteID)
{
	global $database;
	$vars = $database->select('crm_tickets_notes_module_rel', '*', [
		"noteID" => $noteID
	]);
	$countries = '';
	if (sizeof($vars) >= 1) {
		foreach ($vars as $var) {
			if ($var['var'] == 'introduction_methods') {
				$countries .= langDefineGet(JK_LANG, 'ipinbar_introduction_methods', 'id', $var['value']) . ' - ';
			}
		}
		$countries = rtrim($countries, ' - ');
	}
	echo __(" introduction methods") . ' : ' . $countries;
}

