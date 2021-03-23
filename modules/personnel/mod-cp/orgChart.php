<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_org_chart')) {
    error403();
    die;
}
global $View;
global $Route;
global $Users;
global $Cp;
global $database;
$Cp->setSidebarActive('personnel/orgChart');
$View->header_styles_files("/modules/cp/assets/jqueryui/jquery-ui.min.css");
$View->header_styles_files("/modules/personnel/files/primitives.latest.css");
$View->footer_js_files("/modules/cp/assets/jqueryui/jquery-ui.min.js");
$View->footer_js_files("/modules/personnel/files/primitives.min.js");


$View->footer_js('<script>
function groupDetails(groupID) {
  $("#modal_global_title").html("'.__("view group").'");
      $("#modal_global").modal("show");
      ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/personnel/orgChart/groupDetails',
        "success_response" => "#modal_global_body",
        "data" => "{groupID:groupID}",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
}

</script>');

$View->head();
$pglnk=JK_DOMAIN_LANG."cp/personnel/orgChart/all";
$pglnkTxt=__("view all groups");
$viewSt=false;
if(isset($Route->path[2])){
    $pglnk=JK_DOMAIN_LANG."cp/personnel/orgChart";
    $pglnkTxt=__("view active groups");
    $viewSt=true;
}
?>
<a href="<?php echo $pglnk ?>" class="btn btn-outline-info"><?php echo $pglnkTxt; ?></a>
<hr/>
    <div id="basicdiagram" class="Samim" style="direction:ltr;width: 100%; height: 800px; border-style: dotted; border-width: 1px;"></div>

<?php
modal_create([
    "bg" => "success",
    "size" => "lg",
]);
$datatemp='';
$groups=[];
$groups=\Joonika\Modules\Users\groupsSubGroups(0,$groups);

if(sizeof($groups)>=1){
    foreach ($groups as $gr){
        $group=$database->get('jk_groups','*',[
                "id"=>$gr
        ]);
        if($group['status']=="active"){
        if($group['parent']==0){
            $parent='null';
        }else{
            $parent=$group['parent'];
        }
        $groups=\Joonika\Modules\Users\groupsSubGroups($group['id']);
        array_push($groups,$group['id']);
        $usersCount=0;
        $usersSelects=$database->select('jk_users_groups_rel','userID',[
            "AND"=>[
                "status"=>'active',
                "groupID"=>$groups
            ]
        ]);
        if(sizeof($usersSelects)==0){
            $usersSelects=0;
        }
        $usersCount=$database->count("jk_users",[
           "AND"=>[
                   "status"=>"active",
                   "id"=>$usersSelects,
           ]
        ]);

        $cn=true;
if(!$viewSt && $usersCount==0){
    $cn=false;
}
if($cn){
            $datatemp.='

new primitives.orgdiagram.ItemConfig({
                    id: '.$group['id'].',
                    parent: '.$parent.',
                    title: "'.\Joonika\Modules\Users\groupTitle($group['id']).'",
                    description: "'.$usersCount.'",
                    link: "'.$group['id'].'",
                    templateName: "temp1"
                }),
';
}
    }
    }
}
$View->footer_js( '
<script>
var control;
		var timer = null;

		document.addEventListener(\'DOMContentLoaded\', function () {
			var options = new primitives.orgdiagram.Config();

			var items = [
                '.$datatemp.'
            ];

options.items = items;
    options.hasSelectorCheckbox = primitives.common.Enabled.False;
                    options.cursorItem = 0;
                    options.modal = true;
            options.templates = [temp1()];
            options.onItemRender = onTemplateRender;
 function onTemplateRender(event, data) {
                switch (data.renderingMode) {
                    case primitives.common.RenderingMode.Create:
                        /* Initialize widgets here */
                        break;
                    case primitives.common.RenderingMode.Update:
                        /* Update widgets here */
                        break;
                }

                var itemConfig = data.context;

                if (data.templateName == "temp1") {
                    data.element.find("[name=titleBackground]").css({ "background": itemConfig.itemTitleColor });

                    var fields = ["title", "description", "link"];
                    for (var index = 0; index < fields.length; index++) {
                        var field = fields[index];

                        var element = data.element.find("[name=" + field + "]");
                        if (element.text() != itemConfig[field]) {
                            element.text(itemConfig[field]);
                        }
                        if(field=="link"){
                        element.html("<a href=\'javascript:;\' class=\'btn btn-info btn-xs small \' onclick=\'groupDetails("+itemConfig[field]+")\'><i class=\'fa fa-user\'></i></a>");
                        element.append(" <a href=\'javascript:;\' class=\'btn btn-default btn-xs small \' onclick=\'jobdesc("+itemConfig[field]+")\'><i class=\'fa fa-info\'></i></a>");
                        }
                    }
                }
            }
function temp1() {
                var result = new primitives.orgdiagram.TemplateConfig();
                result.name = "temp1";

                       result.itemSize = new primitives.common.Size(130, 80);

                result.minimizedItemSize = new primitives.common.Size(3, 3);
                result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);


                var itemTemplate = jQuery(
                  \'<div class="bp-item bp-corner-all bt-item-frame">\'
                    + \'<div name="titleBackground" class="bp-item bp-corner-all  text-center bp-title-frame" style="top: 2px; left: 2px; width: 98%; height: 18px; background: rgb(65, 105, 225);">\'
                        + \'<div name="title" class="bp-item bp-title text-center" style="font-size:12px!important;top: 1px; left: 4px; width: 120px; height: 16px; color: rgb(255, 255, 255);">\'
                        + \'</div>\'
                    + \'</div>\'
                    + \'<div name="description" class="bp-item text-center" style="top: 30px; width: 100%; height: 36px; font-size: 10px;"></div>\'
                    + \'<div name="link" class="bp-item pull-left" style="top: 50px; width: 100%; height: 36px; font-size: 6px;"></a>\'
                + \'</div>\'
                ).css({
                    width: result.itemSize.width + "px",
                    height: result.itemSize.height + "px"
                }).addClass("bp-item bp-corner-all bt-item-frame");
                result.itemTemplate = itemTemplate.wrap(\'<div>\').parent().html();

                return result;
            }
            $("#basicdiagram").orgDiagram(options);

		});
</script>');

$View->foot();