<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('blog_add_media')) {
    error403();
    die;
}
global $Users;
$Users->loggedCheck();

global $View;
if(isset($_POST['mediaID'])){
    $file=\Joonika\Upload\getFileInfo($_POST['mediaID']);
?>
    <table class="table responsive">
        <tr>
            <td><label for="file_uri">آدرس فایل</label></td>
        </tr>
<tr>
        <td><input type="text" id="file_uri" class="form-control disabled ltr" value="<?php echo JK_DOMAIN.$file['file']; ?>"></td>
        </tr>
        <tr>
            <td><button class="btn btn-default btn-xs" type="button"
                        onclick="addtexttoclipboard('file_uri')">کپی در حافظه</button></td>
        </tr>
        <?php
        $View->footer_js('<script>
        function addtexttoclipboard(elemname){
    copyToClipboard(document.getElementById(elemname));
        }
        function copyToClipboard(elem) {
	  // create hidden text element, if it doesn\'t already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
    	  succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}
        </script>
        ');
        ?>
    </table>

<?php
}else{
echo \Joonika\Upload\field_upload([
    "title" => __("add media"),
    "name" => "addMedia",
    "ColType"=>'12,12',
    "maxfiles"=>1,
    "module"=>"blog_post",
    "afterSuccess"=>"
    ".ajax_load([
            "url" => JK_DOMAIN_LANG . 'cp/main/upload/addMedia',
            "data" => '{mediaID:$("#addMedia").val()}',
            "success_response" => "#add_media_body",
            "loading" => [
            ]
        ])."
    ",
    "text"=>__('Drop files to upload'),
]);
}
echo $View->footer_js;