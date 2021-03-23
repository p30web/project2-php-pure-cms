<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_timeManagement')) {
	error403();
	die;
}
global $View;
global $Users;
global $Route;
global $database;
global $Cp;
$Cp->setSidebarActive('personnel/timeManagement');
$View->footer_js('<script>
    function viewHistory(userID) {
        $("#modal_global").modal("show");
      ' . ajax_load([
		"url" => JK_DOMAIN_LANG . 'cp/personnel/timeManagement/wallboard/viewHistory',
		"data" => "{userID:userID}",
		"success_response" => "#modal_global_body",
		"loading" => ['iclass-size' => 1, 'elem' => 'span']
	]) . '
    }
    function load_wallboard() {
           ' . ajax_load([
		"url" => JK_DOMAIN_LANG . 'cp/personnel/timeManagement/wallboard/viewWallboard',
		"data" => "{}",
		"success_response" => "#load_wallboard_body",
		"loading" => false
	]) . ' 
    }
    load_wallboard();
      setInterval(function() {
      load_wallboard();
    }, 5000);
</script>');
$View->head();
?>
    <div class="card">
        <div class="card-body">
			<?php
			global $timeManagementTabs;
			tab_menus($timeManagementTabs, JK_DOMAIN_LANG . 'cp/personnel/timeManagement/', 2);
			?>
            <div class="text-center text-success"><strong><?php echo __("date"); ?>
                    : <?php echo \Joonika\Idate\date_int("Y/m/d"); ?></strong></div>
            <hr/>
            <div id="load_wallboard_body">
            </div>
        </div>
    </div>
<?php
modal_create([
	"bg" => "success",
	"size" => "lg",
]);
$View->foot();