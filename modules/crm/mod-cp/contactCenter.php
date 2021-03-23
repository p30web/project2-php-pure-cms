<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
$Users->loggedCheck();
if (!$ACL->hasPermission('crm_contactCenter')) {
    error403();
    die;
}
global $View;
global $Route;
global $database;
global $Cp;
$Cp->setSidebarActive('crm/contactCenter');
$View->header_styles_files('/modules/cp/assets/datatable/datatables.min.css');
$View->footer_js_files('/modules/cp/assets/datatable/datatables.min.js');
$View->footer_js_files('/modules/cp/assets/select2/js/select2.full.min.js');
$View->header_styles_files('/modules/cp/assets/select2/css/select2.min.css');
$View->footer_js_files("/modules/cp/assets/js/ckeditor/ckeditor.js");
$View->footer_js_files('/modules/cp/assets/js/jquery-validation/jquery.validate.min.js');
\Joonika\Upload\dropzone_load();

$View->footer_js('<script>
function contactCenterForm() {
  ' . ajax_load([
        "formID" => "contactCenterForm",
        "url" => JK_DOMAIN_LANG . 'cp/crm/ContactCenter/search',
        "success_response" => "#searchBody",
        "data" => '$("#contactCenterForm").serialize()',
        "loading" => ['iclass-size' => 3, 'elem' => 'span']
    ]) . '
}
$("#contactCenterForm").on("submit",function(e) {
  e.preventDefault();
  contactCenterForm();
});


function addTicket(number,subject="") {
$("#modal_global").modal("show");
    ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/crm/tickets/ajax/addOrigin',
        "success_response" => "#modal_global_body",
        "data" => '{number:number,subject:subject,origin:"ContactCenter",originValue:number}',
        "loading" => ['iclass-size' => 3, 'elem' => 'span']
    ]) . '
}

</script>');



$View->head();
$number="";
if(isset($Route->path[2])){
    $number=$Route->path[2];
}


if($number!=""){
$View->footer_js('<script>
contactCenterForm();
</script>');
}
?>
    <div class="card">
        <div class="card-body">
            <form class="form-inline" method="post" action="" id="contactCenterForm">
                <div class="form-group mb-2 ml-2 mr-2">
                    <label for="SearchByPhoneNumber" class="d-inline"><?php __e("phone number") ?></label>
                    <input type="radio" name="searchBy" class="" id="SearchByPhoneNumber" value="phoneNumber" checked>
                </div>
                <div class="form-group mb-2 ml-2 mr-2">
                    <label for="SearchByTicketNumber" class="d-inline"><?php __e("ticket Number") ?></label>
                    <input type="radio" name="searchBy" class="" id="SearchByTicketNumber" value="ticketNumber">
                </div>
                <div class="form-group mb-2 ml-2 mr-2">
                    <input type="text" class="form-control ltr" name="search" id="search" placeholder="" value="<?php echo $number; ?>">
                </div>
                <button type="submit" class="btn btn-primary mb-2" id="submitContactCenterForm"><i class="fa fa-search-plus"></i></button>
            </form>
        </div>
    </div>
    <div class="card-body" id="searchBody">
    </div>
<?php
modal_create([
    "bg" => "success",
    "size" => "lg",
]);
$View->foot();