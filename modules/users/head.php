<?php
global $Cp;
if(isset($Cp->topIconsUsers)){
    array_push($Cp->topIconsUsers,[
        "icon"=>"fa fa-image",
        "link"=>JK_DOMAIN_LANG.'cp/users/changeImage',
        "text"=>__("change image"),
    ]);
    array_push($Cp->topIconsUsers,[
        "icon"=>"fa fa-key",
        "link"=>JK_DOMAIN_LANG.'cp/users/changePassword',
        "text"=>__("change password"),
    ]);
}