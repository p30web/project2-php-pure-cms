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
	if (isset($_POST['departments']) && $_POST['departments'] != "all") {
		$departments = [$_POST['departments']];
	} else {
		$departments = [];

		$reporterDeps = \Joonika\Modules\Crm\ticketDepartmentReporterMy();
		if (sizeof($reporterDeps) >= 1) {
			foreach ($reporterDeps as $reporterDep) {
				array_push($departments, $reporterDep);
			}
		}
	}

	$tickets = $database->select('crm_tickets', 'id', [
		"AND" => [
			"department" => $departments,
			"createdOn[<>]" => [$from_date, $to_date],
		]
	]);
	$tickets = arrayIfEmptyZero($tickets);
	$subjects = $database->select('crm_tickets', 'subject', [
		"id" => $tickets,
		"GROUP" => "subject"
	]);
	if (sizeof($subjects) == 0 ||
        sizeof($departments) == 0) {
		echo alertWarning(__("no report found"));
	} else {
		echo div_start('container');
		echo div_start('row');
		foreach ($departments as $department) {
			$count=0;
			$totalData = [];
			$depTitle = langDefineGet(JK_LANG, 'crm_tickets_departments', 'id', $department);
			foreach ($subjects as $subject) {
				$count = $database->count("crm_tickets", [
					"AND" => [
						"id" => $tickets,
						"department" => $department,
						"subject" => $subject,
					]
				]);
				if($count>=1 && $subject!=""){
				array_push($totalData, [
					"title" => \Joonika\Modules\Crm\ticketsSubjectTitle($subject),
					"col" => "3",
					"value" => $count,
				]);
				}
			}
			if($count>=1){
			$report->panel_data_complex("div", '', 'col-12 col-md-12', $depTitle, $totalData, ["bg" => "light","text-color"=>"grey"]);
			}
		}
		echo div_close();
		echo div_close();

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