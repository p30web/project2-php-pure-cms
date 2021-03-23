<?php
	if (!defined('jk')) die('Access Not Allowed !');
	global $ACL;
	if (!$ACL->hasPermission('reports')) {
		error403();
		die;
	}
	global $View;
	global $Users;
	global $Cp;
	global $Route;
	$Cp->setSidebarActive('reports/index');
	
	$View->footer_js('
<script>
</script>
');
	$View->head();
?>
    <div class="card card-info IRANSans">
        <div class="card-body">
			<?php
				global $reports;
				$reportsFound = [];
				$reports = [];
				\Joonika\listModulesReadFiles("mod-cp/reports/reports.php");
				if (sizeof($reports) >= 1) {
					foreach ($reports as $report) {
						if (!isset($report['permission']) || $ACL->hasPermission($report['permission'])) {
							array_push($reportsFound, $report);
						}
					}
				}
				if (sizeof($reportsFound) == 0) {
					echo alertWarning(__("no reports found"));
				} else {
					foreach ($reportsFound as $rep) {
					    if(!isset($rep['icon'])){
					        $rep['icon']="fa fa-chart-line";
                        }
						?>
                        <div class="card text-center">
                            <div class="card-header card-title">
								<i class="<?php echo $rep['icon'] ?>"></i>
								<?php echo $rep['title'] ?>
                            </div>
                            <div class="card-body p-1">
                                <div class="container">
                                    <div class="row justify-content-md-center align-items-center">
										<?php
											if (isset($rep['sub']) && sizeof($rep['sub']) >= 1) {
												foreach ($rep['sub'] as $subReport) {
													if(!isset($subReport['icon'])){
														$subReport['icon']="fa fa-chart-pie";
													}
													?>
                                                    <div class="col-md-auto">
                                                    <a href="<?php echo JK_DOMAIN_LANG.'cp/'.$rep['name'].'/reports/'.$subReport['name'].'/index'; ?>"
                                                       class="btn btn-outline-primary   ">
                                                        <div class="d-flex ">
                                                                <i class="<?php echo $subReport['icon']; ?> fa-2x d-flex align-items-center px-2"></i>
	                                                            <span class="d-flex align-items-center"><?php echo $subReport['title']; ?></span>
                                                        </div>
                                                    </a>
                                                    </div>
													<?php
												}
											}
										?>
                                    </div>
                                </div>


                            </div>
                        </div>
						
						<?php
					}
				}
			?>
        </div>
    </div>
<?php
	$View->foot();