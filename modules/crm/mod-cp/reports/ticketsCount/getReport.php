<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('reports_crm_ticketsCount')) {
	error403();
	die;
}
if (!isset($_POST['from_date']) || !isset($_POST['to_date']) || $_POST['from_date'] == "" || $_POST['to_date'] == "") {
	echo alertDanger(__("date not valid"));
} else {
	global $database;
	$report = new \Joonika\Modules\Reports\Reports();
	$from_date = \Joonika\Idate\datetodate($_POST['from_date'], 3, "0", 6, 'en');
	$to_date = \Joonika\Idate\datetodate($_POST['to_date'], 3, "0", "Y/m/d 23:59:59", 'en');


	new \Joonika\Modules\Crm\Crm();
	if(isset($_POST['departments']) && $_POST['departments']!="all"){
		$departments = $_POST['departments'];
	}else{
	$departments = [];

	$reporterDeps = \Joonika\Modules\Crm\ticketDepartmentReporterMy();
	if (sizeof($reporterDeps) >= 1) {
		foreach ($reporterDeps as $reporterDep) {
			array_push($departments, $reporterDep);
		}
	}
	}
	$tickets = $database->select('crm_tickets','id', [
		"AND" => [
			"department" => $departments,
			"createdOn[<>]" => [$from_date, $to_date],
		]
	]);
	$ticketsCount=sizeof($tickets);
	$tickets=arrayIfEmptyZero($tickets);
	$notesCount = $database->count('crm_tickets_notes', [
			"ticketID" => $tickets,
	]);
	if($notesCount==null){
	    $notesCount=0;
    }

	$ticketsCountDetails = $database->query("SELECT status,COUNT(status) as count FROM crm_tickets WHERE (createdOn BETWEEN '$from_date' AND '$to_date') GROUP BY status")->fetchAll();
	$availStatus = [
		"new" => 0,
		"open" => 0,
		"hold" => 0,
		"confirm" => 0,
		"closed" => 0,
	];
	if (sizeof($ticketsCountDetails) >= 1) {
		foreach ($ticketsCountDetails as $td) {
			if (isset($availStatus[$td['status']])) {
				$availStatus[$td['status']] = $td['count'];
			}
		}
	}

	echo div_start('container row ' . JK_DIRECTION, '');
	echo div_start('w-100', '', true);
	$totalData = [
		[
			"title"=>__("tickets"),
			"col"=>"6",
			"value"=>$ticketsCount,
		],[
			"title"=>__("notes"),
			"col"=>"6",
			"value"=>$notesCount,
		]
	];
	$report->panel_data_complex("div", '', 'col-12 col-md-4', __("total tickets"), $totalData, ["bg" => "primary"]);
	$report->panel_data_simple("div", '', 'col-12 col-md-4', __("open"), $availStatus['open'], ["bg" => "info", "icon" => "fa fa-envelope-open"]);
	$report->panel_data_simple("div", '', 'col-12 col-md-4', __("new"), $availStatus['new'], ["bg" => "success", "icon" => "fa fa-plus"]);
	echo div_start('w-100', '', true);
	$report->panel_data_simple("div", '', 'col-12 col-md-4', __("hold"), $availStatus['hold'], ["bg" => "warning", "icon" => "fa fa-pause"]);
	$report->panel_data_simple("div", '', 'col-12 col-md-4', __("awaiting confirm"), $availStatus['confirm'], ["bg" => "success", "icon" => "fa fa-check"]);
	$report->panel_data_simple("div", '', 'col-12 col-md-4', __("closed"), $availStatus['closed'], ["bg-color" => "silver", "text-color" => "black", "icon" => "fa fa-power-off"]);
	echo div_close();

	if (isset($_POST['departments'])) {
		if ($_POST['departments'] != "all") {
			$departments = [$_POST['departments']];
		}
		if (sizeof($departments) >= 1) {
			?>
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
						<?php
						foreach ($departments as $department) {
							$tickets = $database->select('crm_tickets','id', [
								"AND" => [
									"createdOn[<>]" => [$from_date, $to_date],
									"department" => $department
								]
							]);
							$ticketsCount=sizeof($tickets);
							$tickets=arrayIfEmptyZero($tickets);

							$ticketsCountDetails = $database->query("SELECT status,COUNT(status) as count FROM crm_tickets WHERE (createdOn BETWEEN '$from_date' AND '$to_date') AND department=$department GROUP BY status")->fetchAll();
							$availStatus = [
								"new" => 0,
								"open" => 0,
								"hold" => 0,
								"confirm" => 0,
								"closed" => 0,
							];
							if (sizeof($ticketsCountDetails) >= 1) {
								foreach ($ticketsCountDetails as $td) {
									if (isset($availStatus[$td['status']])) {
										$availStatus[$td['status']] = $td['count'];
									}
								}
							}
							$depTitle=langDefineGet(JK_LANG, 'crm_tickets_departments', 'id', $department);

							$notesCount = $database->count('crm_tickets_notes', [
								"ticketID" => $tickets,
							]);
							if($notesCount==null){
								$notesCount=0;
							}
							$totalData = [
								[
									"title"=>__("tickets"),
									"col"=>"6",
									"value"=>$ticketsCount,
								],[
									"title"=>__("notes"),
									"col"=>"6",
									"value"=>$notesCount,
								],[
									"title"=>__("open"),
									"col"=>"6",
									"value"=>$availStatus['open'],
								],[
									"title"=>__("new"),
									"col"=>"6",
									"value"=>$availStatus['new'],
								],[
									"title"=>__("hold"),
									"col"=>"6",
									"value"=>$availStatus['hold'],
								],[
									"title"=>__("confirm"),
									"col"=>"6",
									"value"=>$availStatus['confirm'],
								],[
									"title"=>__("closed"),
									"col"=>"6",
									"value"=>$availStatus['closed'],
								]
							];

							$report->panel_data_complex("div", '', 'col-12 col-md-4', $depTitle, $totalData, ["bg" => "light","text-color"=>"grey"]);

						}
						?>
                        </div>
                    </div>
                </div>
            </div>
			<?php
		}
		global $View;
		$View->footer_js('<script>
$(\'.counter\').each(function () {
  var $this = $(this);
  jQuery({ Counter: 0 }).animate({ Counter: $this.text() }, {
    duration: 3000,
    easing: \'swing\',
    step: function () {
      $this.text(Math.ceil(this.Counter));
    }
  });
});
</script>');
		echo $View->footer_js;
	}
}