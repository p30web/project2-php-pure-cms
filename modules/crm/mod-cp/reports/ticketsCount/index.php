<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('reports_crm_ticketsCount')) {
	error403();
	die;
}
global $View;
global $Users;
global $Route;
global $database;
global $Cp;
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
$View->header_styles_files('/modules/reports/files/assets/css/reports.css');

\Joonika\Idate\idateReady();
$Cp->setSidebarActive('reports');
$View->footer_js('<script>
' . ajax_validate([
		"on" => "submit",
		"formID" => "report_form",
		"url" => JK_DOMAIN_LANG . 'cp/crm/reports/ticketsCount/getReport',
		"success_response" => "#load_report",
		"loading" => ['iclass-size' => 1, 'elem' => 'span']
	]) . '
</script>');
$View->head();
?>
	<div class="card">
		<div class="card-body">
            <?php
            global $data;
            $departments=[];
            new \Joonika\Modules\Crm\Crm();
            $reporterDeps = \Joonika\Modules\Crm\ticketDepartmentReporterMy();
            if(sizeof($reporterDeps)>=1){
	            $departments['all']=__("all departments");
	            foreach ($reporterDeps as $reporterDep){
		            $departments[$reporterDep]=langDefineGet(JK_LANG, 'crm_tickets_departments', 'id', $reporterDep);
	            }
            }
            if(sizeof($departments)>=1){

            ?>
			<div class="container">
				<div class="row">
					<?php
					echo \Joonika\Forms\form_create([
						"id"=>"report_form",
						"class"=>"form-inline flex"
					]);
					echo \Joonika\Forms\field_select(
						[
							"name"=>"departments",
							"title"=>__("departments"),
							"ColType"=>"12,12",
							"array"=>$departments,
						]
					);
					echo \Joonika\Idate\field_date(
						[
							"title"=>__("from date"),
							"name"=>"from_date",
							"required" => true,
							"format"=>"3",
						]
					);
					echo \Joonika\Idate\field_date(
						[
							"title"=>__("to date"),
							"name"=>"to_date",
							"required" => true,
							"format"=>"3",
						]
					);
					echo \Joonika\Forms\field_submit([
						"text"=>__("search"),
						"ColType"=>"12,12",
						"btn-class"=>"btn btn-primary mt-4",
						"icon"=>"fa fa-search"
					]);
					echo \Joonika\Forms\form_end();
					?>
				</div>
			</div>
            <?php
            }else{
                echo alertDanger(__("you are not in any department reporter"));
            }
            ?>
		</div>
	</div>
	<div id="load_report"></div>
<?php
modal_create([
	"bg" => "success",
	"size" => "lg",
]);
$View->foot();