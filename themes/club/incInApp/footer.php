<?php
if (!defined('jk')) die('Access Not Allowed !');
global $View;

?>
<script src="<?php echo THEME_CDN; ?>/themes/ipin/assets/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo THEME_CDN; ?>/themes/ipin/assets/js/custom.js"></script>
<script src="<?php echo THEME_CDN; ?>/themes/ipin/assets/js/popper.min.js"></script>
<script src="<?php echo THEME_CDN; ?>/themes/ipin/assets/js/bootstrap.min.js"></script>

<?php

echo $View->getFooterJsFiles();

if ($View->footer_js != "") {
    echo $View->footer_js;
}
?>
<!-- Google Analytics -->
<script type="text/javascript">!function () {
        function t() {
            var t = document.createElement("script");
            t.type = "text/javascript", t.async = !0, localStorage.getItem("rayToken") ? t.src = "https://app.raychat.io/scripts/js/" + o + "?rid=" + localStorage.getItem("rayToken") + "&href=" + window.location.href : t.src = "https://app.raychat.io/scripts/js/" + o;
            var e = document.getElementsByTagName("script")[0];
            e.parentNode.insertBefore(t, e)
        }

        var e = document, a = window, o = "d97fd942-08b0-4081-81b0-7883a2933bc6";
        "complete" == e.readyState ? t() : a.attachEvent ? a.attachEvent("onload", t) : a.addEventListener("load", t, !1)
    }();</script>
<!-- End Google Analytics -->
<script type="text/javascript">
    var _paq = _paq || [];
    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
        var u="//stats.ipinbar.net/";
        _paq.push(['setTrackerUrl', u+'piwik.php']);
        _paq.push(['setSiteId', '1']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
    })();
</script>

</body>

</html>
