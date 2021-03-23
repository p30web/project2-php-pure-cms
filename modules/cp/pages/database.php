<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
$Users->loggedCheck();
if(!$ACL->hasPermission('cp_database')){
    error403();die;
}
global $View;
global $Cp;
$Cp->setSidebarActive('main/database');
global $database;
$View->head();

    ?>
    <div class="panel panel-flat IRANSans">
        <div class="panel-body">
    <?php
    $dbinfo=$database->info();
    if(sizeof($dbinfo)>=1 && sizeof($dbinfo)==5){
    ?>
        <h5 class="text-center text-info"><?php __e("database information") ?></h5>
        <div class="table-responsive ltr">
        <table class="table table-xs small text-xs padding2table  table-striped table-bordered tablebghead-info ltr">
    <tbody>
    <?php
    $ir=0;
    $output = [
        0 => 'server information',
        1 => 'driver name',
        2 => 'client version',
        3 => 'server version',
        4 => 'connection status',
    ];
    foreach ($dbinfo as $dbin){
        ?>
        <tr>
            <td class="bg-grey"><?php echo ucfirst($output[$ir]); ?></td>
            <td><?php echo $dbin; ?></td>
            <td><i class="fa fa-check text-success"></i></td>
        </tr>
        <?php
        $ir+=1;
    }
    ?>

    </tbody>
</table>
</div>
<hr/>
            <?php
            }
$tablesq=$database->query("show tables")->fetchAll();
if(sizeof($tablesq)>=1){

    ?>
    <h5 class="text-center text-info"><?php __e("tables information") ?></h5>
            <div class="table-responsive">
                <table class="table table-xs small text-xs padding2table  table-striped table-bordered tablebghead-info">
                    <thead>
                    <tr>
                        <th><?php __e("row") ?></th>
                        <th><?php __e("table") ?></th>
                        <th><?php __e("columns") ?></th>
                        <th><?php __e("records") ?></th>
                        <th><?php __e("indexes") ?></th>
                        <th><?php __e("status") ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $irowcount=1;
                    $needclCounts=0;
                    $countrecords=0;
                    $keycounts=0;
                    foreach ($tablesq as $tbl){
                        $tableName=$tbl[0];
                        $needcl=$database->query("SHOW COLUMNS FROM $tableName")->fetchAll();
                        $needclCount=sizeof($needcl);
                        $needclCounts+=$needclCount;
                        $keycount=0;
                        if(sizeof($needcl)>=1){
                            foreach ($needcl as $ncl){
                                if($ncl['Key']!=''){
                                    $keycount+=1;
                                }
                            }
                        }
                        $keycounts+=$keycount;
                        $countrecord=$database->count($tableName,[]);
                        $countrecords+=$countrecord;
//                        print_r($needcl);
//                        echo '<br/>';
//                        echo '<br/>';
//                        echo '<br/>';
//                        print_r($tbl);
                        ?>
                        <tr>
                            <td><?php echo $irowcount; ?></td>
                            <td><?php echo $tableName; ?></td>
                            <td><?php echo sizeof($needcl); ?></td>
                            <td><?php echo $countrecord; ?></td>
                            <td><?php echo $keycount; ?></td>
                            <td><?php
                                if($keycount<=1){
                                    echo '<i class="fa fa-exclamation-triangle text-warning"></i>';
                                }else{
                                    echo '<i class="fa fa-check text-success"></i>';
                                }
                                ?></td>
                        </tr>
                        <?php
                        $irowcount+=1;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td><?php echo __("total"); ?></td>
                        <td><?php echo $irowcount-1; ?></td>
                        <td><?php echo $needclCounts; ?></td>
                        <td><?php echo $countrecords; ?></td>
                        <td><?php echo $keycounts; ?></td>
                        <td><?php
                            if($keycounts<=(($irowcount-1)*2)){
                                echo '<i class="fa fa-exclamation-triangle text-warning"></i>';
                            }else{
                                echo '<i class="fa fa-check text-success"></i>';
                            }
                            ?></td>
                    </tr>
                    </tfoot>
                </table>
            </div>

    <?php
}
?>

        </div>
    </div>
    <?php
$View->foot();
