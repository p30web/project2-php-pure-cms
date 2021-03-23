<?php
if(!defined('jk')) die('Access Not Allowed !');
global $Cp;
global $View;
if($Cp->topHeader) {
    ?>
    </div>
    <!-- /.page-inner -->
    </div>
    <!-- /.page -->
    </div>
    <!-- .app-footer -->
    <?php
}
include_once(__DIR__ . '/footer.php');
?>
<!-- /.app-footer -->
<!-- /.wrapper -->
</main>
<!-- /.app-main -->
</div>
<!-- /.app -->

<!-- BEGIN BASE JS -->
<script src="/modules/cp/assets/js/jquery-3.3.1.min.js"></script>
<script src="/modules/cp/assets/js/popper.min.js"></script>
<script src="/modules/cp/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- END BASE JS -->
<!-- BEGIN PLUGINS JS -->
<script src="/modules/cp/assets/js/stacked-menu.min.js"></script>
<script src="/modules/cp/assets/sweetalert2/sweetalert2.all.min.js"></script>
<!-- END PLUGINS JS -->
<!-- BEGIN THEME JS -->
<script src="/modules/cp/assets/js/main.js"></script>
<!-- END THEME JS -->
<!-- BEGIN PAGE LEVEL JS -->

<!-- END PAGE LEVEL JS -->

<?php
if(sizeof($View->footer_js_files)>=1){
    foreach ($View->footer_js_files as $footer_js_file) {
        ?>
<script  type="text/javascript" src="<?php echo $footer_js_file ?>"></script>
<?php
    }
}
echo $View->footer_js;
?>

<!-- Global site tag (gtag.js) - Google Analytics -->
</body>
</html>
