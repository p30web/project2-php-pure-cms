<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('reports_personnel_timeManagement')) {
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
        "url" => JK_DOMAIN_LANG . 'cp/personnel/reports/timeManagement/getReport',
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
            echo \Joonika\Forms\form_create([
                "id"=>"report_form",
            ]);
            ?>
			<div class="container">
				<div class="row">
					<?php
                    echo div_start('col-md-3');
                    echo \Joonika\Idate\field_date(
                        [
                            "title"=>__("from date"),
                            "name"=>"from_date",
                            "required" => true,
                            "format"=>"3",
                        ]
                    );
                    echo div_close();
                    echo div_start('col-md-3');
                    echo \Joonika\Idate\field_date(
                        [
                            "title"=>__("to date"),
                            "name"=>"to_date",
                            "required" => true,
                            "format"=>"3",
                        ]
                    );
                    echo div_close();
                    echo div_start('col-md-3');

                    echo \Joonika\Forms\field_submit([
						"text"=>__("search"),
						"ColType"=>"12,12",
						"btn-class"=>"btn btn-primary mt-4",
						"icon"=>"fa fa-search"
					]);
                    echo div_close();

					?>
				</div>
			</div>
            <?php
            echo \Joonika\Forms\form_end();
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