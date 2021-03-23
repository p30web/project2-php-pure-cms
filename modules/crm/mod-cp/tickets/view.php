<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
$Users->loggedCheck();
if (!$ACL->hasPermission('crm_tickets')) {
	error403();
	die;
}
global $View;
global $Route;
global $database;
global $Cp;
$Cp->setSidebarActive('crm/tickets');
$View->header_styles_files('/modules/cp/assets/datatable/datatables.min.css');
$View->footer_js_files('/modules/cp/assets/datatable/datatables.min.js');
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
\Joonika\Upload\dropzone_load();

$View->footer_js('<script>
' . ajax_validate([
		"on" => "submit",
		"formID" => "newNote",
		"ckeditor" => true,
		"url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/saveNote',
		"success_response" => "#action_body",
		"loading" => ['iclass-size' => 1, 'elem' => 'span']
	]) . '
</script>');


$View->head();

$continue = true;
$error = __("unknown");
if (!isset($Route->path[3])) {
	$continue = false;
	$error = __("ticket id not valid");
}
if ($continue) {
	$ticketID = $Route->path[3];
	$ticket = $database->get('crm_tickets', "*", [
		"id" => $ticketID
	]);
	if (!isset($ticket['id'])) {
		$continue = false;
		$error = __("ticket id not found");
	}
}
if ($continue && $ticket['status'] == "removed") {
	$continue = false;
	$error = __("ticket removed");
}
if ($continue) {
	if (!$ACL->hasPermission('crm_tickets_view_all') && $ticket['global'] == 0) {
		$followers = $database->select('crm_tickets_followers', 'userID', [
			"AND" => [
				"ticketID" => $ticketID,
				"status" => "active",
			]
		]);
		if (sizeof($followers) >= 1) {
			if (!in_array(JK_LOGINID, $followers)) {
				$continue = false;
				$error = __("you are not follower of the ticket");
			}
		} else {
			$continue = false;
			$error = __("this ticket has not follower");
		}
	}
}
if (!$continue) {
	echo alertDanger($error);
} else {
	new \Joonika\Modules\Crm\Crm();
	if ($ticket['closedOn'] != "") {
		$ticket['closedOn'] = \Joonika\Idate\date_int("Y/m/d H:i:s", $ticket['closedOn']);
	}
	\Joonika\Modules\Crm\ticketFollowerReadFind($ticketID);
	?>
    <div class="card mb-0">
        <div class="card-body p-3">
            <div class="text-center"><span
                        class="badge badge-pill badge-primary"><?php __e("title") ?> : </span>
				<?php echo $ticket['title']; ?>
            </div>
        </div>
    </div>
    <div id="ticket_actions_head">
		<?php

		$View->footer_js('<script>
function ticket_actions_head() {
     ' . ajax_load([
				"url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/headTicket',
				"data" => '{ticketID:' . $ticketID . '}',
				"success_response" => "#ticket_actions_head",
				"error_swal" => false,
				"loading" => false
			]) . '
}
ticket_actions_head();



    
</script>');
		?>
    </div>
	<?php
	global $origins;
	$origins = \Joonika\Modules\Crm\ticketOrigins($ticket['id']);
	\Joonika\listModulesReadFiles("mod-crm/TicketHeader.php");
	?>
    <div class="row">
        <div class="col-12 col-md-8">

            <div id="ticket_actions_notes">


				<?php
				$View->footer_js('<script>
function ticket_actions_notes() {
     ' . ajax_load([
						"url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/notes',
						"data" => '{ticketID:' . $ticketID . '}',
						"success_response" => "#ticket_actions_notes",
						"error_swal" => false,
						"loading" => false
					]) . '
}
ticket_actions_notes();

</script>');
				?>
            </div>
            <div id="action_body"></div>
			<?php
			if ($ticket['status'] != "closed") {
				?>
                <div class="card mb-4">
                    <div class="card-body p-0">
                        <div class="  mb-0 ">
                            <div class="container">
                                <div class="row align-items-center">

                                    <div class="col-12 col-md-2 text-center p-0 d-none d-md-block">
                                        <img src="<?php echo \Joonika\Modules\Users\profileImage(JK_LOGINID); ?>"
                                             class="d-none img img-fluid rounded-circle d-md-block" alt="">
                                        <div><?php echo nickName(JK_LOGINID) ?></div>
                                    </div>
                                    <div class="col-12 col-md-10">

										<?php
										$noteModules = $database->select('crm_tickets_note_modules', '*', [
											"status" => "active",
										]);
										$View->footer_js('<script>
                                            function addNoteModule(noteModuleID){
                                                $("#modal_global").modal("show");
                                                  ' . ajax_load([
												"url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/addNoteModule',
												"data" => "{ticketID:" . $ticketID . ",noteModuleID:noteModuleID}",
												"success_response" => "#modal_global_body",
												"loading" => ['iclass-size' => 1, 'elem' => 'span']
											]) . '
                                            }
                                            </script>');
										if (sizeof($noteModules) >= 1) {
											foreach ($noteModules as $noteModule) {
												$title = langDefineGet(JK_LANG, "crm_tickets_note_modules", 'id', $noteModule['id']);
												?>
                                                <button type="button" class="btn btn-outline-info btn-sm"
                                                        onclick="addNoteModule(<?php echo $noteModule['id']; ?>)"><?php echo $title;  ?></button>
												<?php
											}
										}
										?>
										<?php
										\Joonika\Forms\form_create([
											'id' => "newNote"
										]);
										echo \Joonika\Forms\field_hidden([
											"name" => "ticketID",
											"value" => $ticketID,
										]);
										echo \Joonika\Forms\field_editor([
											"name" => "newNoteTxt",
											"type" => "simple",
											"title" => '<hr/>' . __("new note"),
											"ColType" => "12,12",
										]);
										echo \Joonika\Upload\field_upload([
											"title" => __("attachments"),
											"name" => "attachments",
											"ColType" => '12,12',
											"thMaker" => 0,
											"maxfiles" => 20,
											"module" => "crm_tickets",
										]);
										echo \Joonika\Forms\field_submit([
											"text" => __("save"),
											"ColType" => "12,12",
											"btn-class" => "btn btn-primary mb-2",
											"icon" => "fa fa-save"
										]);
										\Joonika\Forms\form_end();
										?>
                                        <div id="action_body"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
			}
			?>


        </div>
        <div class="col-12 col-md-4">
            <div class="" id="ticket_actions_origins">
				<?php
				$View->footer_js('<script>
function ticket_actions_origins() {
     ' . ajax_load([
						"url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/actions/origins',
						"data" => '{ticketID:' . $ticketID . '}',
						"success_response" => "#ticket_actions_origins",
						"error_swal" => false,
						"loading" => false
					]) . '
}
ticket_actions_origins();
function rmOrigin(id) {
      swal({
  title: \'' . __("are you sure to remove") . '\',
  type: \'warning\',
  showCancelButton: true,
  confirmButtonColor: \'#3085d6\',
  confirmButtonText: \'' . __("Yes, delete it") . '!\',
  cancelButtonText: \'' . __("cancel") . '!\'
}).then((result) => {
if(result.value){
  ' . ajax_load([
						"data" => "{ticketID:" . $ticket['id'] . ",remid:id}",
						"url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/actions/origins',
						"success_response" => "#ticket_actions_origins",
						"loading" => [
						]
					]) . '
    }
});
    }

</script>');
				?>
            </div>

            <div class="card card-body">
                <div class="row small text-center" id="ticket_actions_btns">
					<?php
					$View->footer_js('<script>
function ticket_actions_btns() {
     ' . ajax_load([
							"url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/actions/action',
							"data" => '{ticketID:' . $ticketID . '}',
							"success_response" => "#ticket_actions_btns",
							"error_swal" => false,
							"loading" => false
						]) . '
}
ticket_actions_btns();

function ticketAction(action) {
  let thisIdBtn="ticketAction_"+action;
  $("#"+thisIdBtn).append(\'<i class="fa fa-spinner fa-spin loadingAction"></i>\');
   ' . ajax_load([
							"url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/actions/action',
							"data" => '{action:action,ticketID:' . $ticketID . '}',
							"success_response" => "#ticket_actions_btns",
							"error_response" => '$(".loadingAction").remove();',
							"success_response_after" => '$(".loadingAction").remove();',
							"loading" => false
						]) . '
}

</script>');
					?>
                </div>
                <div id="ticket_actions_body"></div>
            </div>
            <div class="card ">
                <div class="card-header text-center small">
					<?php __e("followers") ?>
					<?php
					$View->footer_js('
<script>
function removeFollower(id){
    
     swal({
  title: \'' . __("are you sure to remove") . '\',
  type: \'warning\',
  showCancelButton: true,
  confirmButtonColor: \'#3085d6\',
  confirmButtonText: \'' . __("Yes, delete it") . '!\',
  cancelButtonText: \'' . __("cancel") . '!\'
}).then((result) => {
if(result.value){
         ' . ajax_load([
							"url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/actions/removeFollower',
							"data" => '{ticketID:' . $ticketID . ',remid:id}',
							"success_response" => "#action_body",
							"loading" => ['iclass-size' => 1, 'elem' => 'span']
						]) . '
    }
});

}
function emailFollower(id){
         ' . ajax_load([
							"url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/actions/emailToFollower',
							"data" => '{ticketID:' . $ticketID . ',fid:id}',
							"success_response" => "#action_body",
							"loading" => ['iclass-size' => 1, 'elem' => 'span']
						]) . '
}
function addFollower(){
    $("#modal_global").modal("show");
         ' . ajax_load([
							"url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/actions/addFollower',
							"data" => '{ticketID:' . $ticketID . '}',
							"success_response" => "#modal_global_body",
							"loading" => ['iclass-size' => 1, 'elem' => 'span']
						]) . '
}
function ticket_actions_followers() {
     ' . ajax_load([
							"url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/actions/followers',
							"data" => '{ticketID:' . $ticketID . '}',
							"success_response" => "#ticket_actions_followers",
							"error_swal" => false,
							"loading" => false
						]) . '
}
ticket_actions_followers();
</script>
');

					if ($ticket['status'] != "closed") {
						?>
                        <button type="button" class="btn btn-sm btn-success" onclick="addFollower()"><i
                                    class="fa fa-plus"></i></button>
						<?php
					}
					?>
                </div>
                <div class="card-body">
                    <div class="row" id="ticket_actions_followers"></div>
                    <div id="ticket_followers_body"></div>
                </div>
            </div>
            <div class="card ">
                <div class="card-header text-center small">
					<?php __e("history") ?>
                </div>
                <div class="card-body">
                    <div class="row" id="ticket_actions_histories">
						<?php
						$View->footer_js('
<script>
function ticket_actions_histories() {
     ' . ajax_load([
								"url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/actions/histories',
								"data" => '{ticketID:' . $ticketID . '}',
								"success_response" => "#ticket_actions_histories",
								"error_swal" => false,
								"loading" => false
							]) . '
}
ticket_actions_histories();
</script>
');

						?>
                    </div>
                    <div id="ticket_history_body"></div>
                </div>
            </div>

        </div>
		<?php
		modal_create([
		]);
		?>
    </div>
	<?php
	$View->footer_js('<script>
setInterval(function(){ 
ticket_actions_followers();
ticket_actions_histories();
ticket_actions_btns();
ticket_actions_notes();
ticket_actions_head();
ticket_actions_origins();
 }, 5000);
</script>');
}
$View->foot();