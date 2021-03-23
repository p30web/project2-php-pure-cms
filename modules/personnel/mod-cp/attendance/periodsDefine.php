<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_attendance_define')) {
    error403();
    die;
}
global $View;
global $Users;
global $Route;
global $database;
global $Cp;
$Cp->setSidebarActive('personnel/attendance');
$View->footer_js('<script>

function addPeriod(){
      $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/personnel/attendance/periodsDefine/add',
        "data" => "{}",
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}
</script>');
$View->head();
?>
    <div class="card">
        <div class="card-body">
            <?php
            global $attendanceTabs;
            tab_menus($attendanceTabs, JK_DOMAIN_LANG . 'cp/personnel/attendance/',2);
            ?>
            <hr/>
            <a href="javascript:;" onclick="addPeriod()" class="btn btn-xs btn-info"><?php __e("add period") ?>
                <i class="fa fa-plus-circle"></i></a>
            <hr/>
            <table class="table table-xs">
                <thead>
                <tr>
                    <th><?php echo __("title"); ?></th>
                    <th><?php echo __("start date"); ?></th>
                    <th><?php echo __("end date"); ?></th>
                    <th><?php echo __("status"); ?></th>
                    <th><?php echo __("operation"); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $prds=$database->select("attendance_periods","*",[
                        "ORDER"=>["ID"=>"DESC"]
                ]);
                if(sizeof($prds)>=1){
                    foreach ($prds as $prd){
                        ?>
                        <tr>
                            <td><?php echo __("title"); ?></td>
                            <td><?php echo __("start date"); ?></td>
                            <td><?php echo __("end date"); ?></td>
                            <td><?php echo __("status"); ?></td>
                            <td><?php echo __("operation"); ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
modal_create([
    "bg" => "success",
]);
$View->foot();