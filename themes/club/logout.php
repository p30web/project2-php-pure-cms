<?php
if(!isset($_SESSION['clubUser'])){
    redirect_to(JK_DOMAIN_LANG);
    exit;
}
unset($_SESSION['clubUser']);
redirect_to(JK_DOMAIN_LANG);
exit;
