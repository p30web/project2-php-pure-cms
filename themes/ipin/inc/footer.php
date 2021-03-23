<?php
if (!defined('jk')) die('Access Not Allowed !');
global $View;

?>


<!--<script src="--><?php //echo THEME_CDN; ?><!--/themes/ipin/assets/js/jquery-3.3.1.min.js"></script>-->
<!--<script src="--><?php //echo THEME_CDN; ?><!--/themes/ipin/assets/js/custom.js"></script>-->
<!--<script src="--><?php //echo THEME_CDN; ?><!--/themes/ipin/assets/js/popper.min.js"></script>-->
<!--<script src="--><?php //echo THEME_CDN; ?><!--/themes/ipin/assets/js/bootstrap.min.js"></script>-->
<!--<script src="--><?php //echo THEME_CDN; ?><!--/themes/ipin/assets/aos/aos.js"></script>-->

<?php

echo $View->getFooterJsFiles();

if ($View->footer_js != "") {
    echo $View->footer_js;
}
?>
<!-- Google Analytics -->

<!-- End Google Analytics -->
<script>
    AOS.init({
        duration: 1100,
    });
    $(".js-download-app-dismiss").on("click",function () {
        $(".c-download-app").remove();
    });
</script>

</body>

</html>
