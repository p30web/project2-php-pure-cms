<?php
if (!defined('jk')) die('Access Not Allowed !');
if (!function_exists('jk_die')) {

    /**
     * @param string $message
     */
    function jk_die($message = "")
    {
        echo $message;
        die;
    }
}
if (!function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}


if (!function_exists('redirect_to')) {
    function redirect_to($url = "")
    {
        header('Location: ' . $url);
        exit;
    }
}

if (!function_exists('__')) {
    function __($msg, $ucfirst = 0)
    {
        global $translate;
        if (isset($translate[$msg])) {
            if ($ucfirst == 1) {
                $return = ucfirst($translate[$msg]);
            } else {
                $return = $translate[$msg];
            }
        } else {
            if ($ucfirst == 1) {
                $return = ucfirst($msg);
            } else {
                $return = $msg;
            }
        }
        return $return;

    }


}

if (!function_exists('__e')) {
    function __e($msg, $ucfirst = 0)
    {
        echo __($msg, $ucfirst);
    }
}

function error404($return = true)
{
    http_response_code(404);
    if ($return) {
        ?>
        <div id="notfound">
            <div class="notfound">
                <div class="notfound-404">
                    <h1>404</h1>
                </div>
                <h2><?php __e("Oops! Not Found"); ?></h2>
            </div>
        </div>
        <?php
    }
}

function error403($return = true)
{
    http_response_code(403);
    if ($return) {
        ?>
        <div id="accessdenied">
            <div class="accessdenied">
                <div class="accessdenied-403">
                    <h1>403</h1>
                </div>
                <h2><?php __e("Oops! Access Denied"); ?></h2>
            </div>
        </div>
        <?php
    }
}

function loading_fa($options = [])
{
    $opt = [
        "class" => 'text-center',
        "iclass" => '0',
        "iclass-size" => '3',
        "elem" => 'div',
        "text-sr" => __("loading, please wait"),
        "text" => "",
    ];

    if (is_array($options) && sizeof($options) >= 1) {
        foreach ($options as $tr => $val) {
            if (isset($opt[$tr])) {
                $opt[$tr] = $val;
            }
        }
    }
    $butshow_start = '';
    $butshow_end = '';
    if ($opt['elem'] != '') {
        $butshow_start .= '<' . $opt['elem'];
        if ($opt['class'] != '') {
            $butshow_start .= ' class="' . $opt['class'];

            $butshow_start .= '" ';
        }
        if ($opt['iclass'] == 0) {
            $opticlass = 'fa fa-spinner fa-pulse fa-fw fa-' . $opt['iclass-size'] . 'x';
        } else {
            $opticlass = $opt['iclass'];
        }
        if ($opt['text'] != '') {
            $opttext = $opt['text'];
        } else {
            $opttext = '';
        }
        $butshow_start .= '><i class="' . $opticlass . '"></i><span class="sr-only">' . $opt['text-sr'] . ' ...</span>' . $opttext;

        $butshow_end .= '</' . $opt['elem'] . '>';
    }

    $butshow = $butshow_start . $butshow_end;

    return $butshow;
}


function ajax_load($options = [])
{
    $option = [
        "url" => '',
        "on" => '',
        "formID" => '',
        "validate" => false,
        "prevent" => false,
        "type" => 'post',
        "data" => '$(this).serialize()',
        "success_response" => '',
        "error_response" => '',
        "error_swal" => true,
        "type_response" => 'html',
        "success_response_after" => '',
        "loading" => false,
    ];
    $return = '';
    if (sizeof($option) >= 1) {
        foreach ($option as $key => $opt) {
            if (isset($options[$key])) {
                $option[$key] = $options[$key];
            }
        }
    }
    if ($option['on'] != '') {
        if ($option['formID'] != '') {
            if ($option['prevent'] == true) {
                $return .= '$("#' . $option['formID'] . '").on("' . $option['on'] . '",function(e){
            e.preventDefault();
            ';
            } else {
                $return .= '$("#' . $option['formID'] . '").on("' . $option['on'] . '",function(){
            ';
            }


        }
    }
    $return .= 'var datas=' . $option['data'] . ';
    ';
    if ($option['loading'] != '') {
        $return .= '$("' . $option['success_response'] . '").' . $option['type_response'] . '(\'' . loading_fa($option['loading']) . '\');';
    }
    $error_response='swal ( "' . __("An error occurred") . '" ,  "' . __("loading page failed") . ' \n ' . $option['url'] . '" ,  "error",{
          buttons: "' . __("ok") . '!",
        });';
if($option['error_swal']==false){
    $error_response="";
}
    $error_response.=$option['error_response'];
    $return .= '
    $.ajax({
        url: "' . $option['url'] . '",
        type: "' . $option['type'] . '",
        data: datas,
        success: function (response) {
            $("' . $option['success_response'] . '").' . $option['type_response'] . '(response);
            ' . $option['success_response_after'] . '
        }, error: function () {
        '.$error_response.'
        
}
    });
    ';

    if ($option['on'] != '') {
        if ($option['formID'] != '') {

            $return .= '
                return false
});
 ';

        }
    }
    return $return;
}

function ajax_validate($options = [])
{
    $option = [
        "url" => '',
        "on" => '',
        "formID" => '',
        "validate" => false,
        "prevent" => false,
        "ckeditor" => false,
        "type" => 'post',
        "data" => '$(form).serialize()',
        "type_response" => 'html',
        "success_response" => '',
        "success_response_after" => '',
        "loading" => false,
    ];
    $return = '';
    if (sizeof($option) >= 1) {
        foreach ($option as $key => $opt) {
            if (isset($options[$key])) {
                $option[$key] = $options[$key];
            }
        }
    }

    $return .= '
$(document).ready(function() {

            $("#' . $option['formID'] . '").validate({
                onfocusout: false,
            ignore: \'.select2-search__field\', // ignore hidden fields
        errorClass: \'validation-error-label\',
        successClass: \'validation-valid-label\',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },

        // Different components require proper error label placement
        errorPlacement: function(error, element) {

            // Styled checkboxes, radios, bootstrap switch
            if (element.parents(\'div\').hasClass("checker") || element.parents(\'div\').hasClass("choice") || element.parent().hasClass(\'bootstrap-switch-container\') ) {
                if(element.parents(\'label\').hasClass(\'checkbox-inline\') || element.parents(\'label\').hasClass(\'radio-inline\')) {
                    error.appendTo( element.parent().parent().parent().parent() );
                }
                 else {
                    error.appendTo( element.parent().parent().parent().parent().parent() );
                }
            }

            // Unstyled checkboxes, radios
            else if (element.parents(\'div\').hasClass(\'checkbox\') || element.parents(\'div\').hasClass(\'radio\')) {
                error.appendTo( element.parent().parent().parent() );
            }

            // Input with icons and Select2
            else if (element.parents(\'div\').hasClass(\'has-feedback\') || element.hasClass(\'select2-hidden-accessible\')) {
                error.appendTo( element.parent() );
            }

            // Inline checkboxes, radios
            else if (element.parents(\'label\').hasClass(\'checkbox-inline\') || element.parents(\'label\').hasClass(\'radio-inline\')) {
                error.appendTo( element.parent().parent() );
            }

            // Input group, styled file input
            else if (element.parent().hasClass(\'uploader\') || element.parents().hasClass(\'input-group\')) {
                error.appendTo( element.parent().parent() );
            }

            else {
                error.insertAfter(element);
            }
        },
        validClass: "validation-valid-label",
         success: function(label) {
            label.addClass("validation-valid-label")
        },
  submitHandler: function(form) {

';
    if ($option['ckeditor']) {
        $return .= '

for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }

                        ';
    }

    $return .= 'var datas=' . $option['data'] . ';
    ';
    if ($option['loading'] != '') {
        $return .= '$("' . $option['success_response'] . '").' . $option['type_response'] . '(\'' . loading_fa($option['loading']) . '\');';
    }

    $return .= '
    $.ajax({
        url: "' . $option['url'] . '",
        type: "' . $option['type'] . '",
        data: datas,
        success: function (response) {
            $("' . $option['success_response'] . '").' . $option['type_response'] . '(response);
            ' . $option['success_response_after'] . '
        }, error: function () {
        swal ( "' . __("An error occurred") . '" ,  "' . __("loading page failed") . ' \n ' . $option['url'] . '" ,  "error",{
          buttons: "' . __("ok") . '!",
        });
}
    });
    ';


    $return .= '

                }
                 });
                 });

                ';
    global $View;
    $View->footer_js_files('/modules/cp/assets/js/jquery-validation/jquery.validate.min.js');
    return $return;
}

function hashpass($password)
{
    $hash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 10));
    // you can set the "complexity" of the hashing algorithm, it uses more CPU power but it'll be harder to crack, even though the default is already good enough
    return $hash;
}

function redirect_to_js($url = '', $timeout = 0, $withScript = true)
{
    $txt = '';
    if ($withScript) {
        $txt .= '<script>';
    }
    $txt .= "setTimeout(function() {
            window.location = '" . $url . "'
        }, " . $timeout . ");";
    if ($withScript) {
        $txt .= '</script>';
    }
    return $txt;
}

function nickName($userID)
{
    global $database;
    $user = $database->get("jk_users", ['name', 'family', 'status'], [
        "id" => $userID
    ]);
    $stText = "";
    if ($user['status'] == "inactive") {
        $stText = ' <span class="text-danger">(' . __("inactive") . ')</span>';
    }
    return $user['name'] . ' ' . $user['family'] . $stText;
}

function arrayIfEmptyZero($array = [])
{
    if (sizeof($array) == 0) {
        $array = 0;
    }
    return $array;
}

function datatable_structure($options = [])
{
    $opt = [
        "id" => "id",
        "type" => "html",
        "ajax_type" => "POST",
        "ajax_url" => "",
        "tabIndex" => "",
        "drawCallback" => "",
        "columnDefs" => [],
        "iDisplayLength" => "25",
        "lengthMenu" => '[[25, 50,100, -1], [25, 50,100, "All"]]',
        "order" => "[[ 0, 'desc' ]]",
        "columns" => [],
        "language" => '"decimal": "",
    "emptyTable":     "' . __("No data available in table") . '",
    "info":           "' . __("Showing _START_ to _END_ of _TOTAL_ entries") . '",
    "infoEmpty":      "' . __("Showing 0 to 0 of 0 entries") . '",
    "infoFiltered":   "' . __("&#40; filtered from _MAX_ total entries &#41;") . '",
    "infoPostFix":    "",
    "thousands":      ",",
    "lengthMenu":     "' . __("Show _MENU_ entries") . '",
    "loadingRecords":     "' . __("Loading") . '...",
    "processing":     "' . __("processing") . '...",
    "search":         "' . __("Search") . '",
    "zeroRecords":    "' . __("No matching records found") . '",
    "paginate": {
        "first":      "' . __("First") . '",
        "last":       "' . __("Last") . '",
        "next":       "' . __("Next") . '",
        "previous":   "' . __("Previous") . '"
    },
    "aria": {
        "sortAscending":  ": ' . __("activate to sort column ascending") . '",
        "sortDescending": ": ' . __("activate to sort column descending") . '"
    }',
    ];

    if (sizeof($options) >= 1) {
        foreach ($options as $tr => $val) {
            if (isset($opt[$tr])) {
                $opt[$tr] = $val;
            }
        }
    }

    $typetext = '';
    if ($opt['type'] === 'ajax') {
        $typetext = '"processing": true,
        "serverSide": true,
        "ajax": {
            "url": "' . $opt['ajax_url'] . '",
            "type": "' . $opt['ajax_type'] . '"
        },';
    }
    $lengthMenu = '';
    if ($opt['lengthMenu'] != '') {
        $lengthMenu = '"lengthMenu": ' . $opt['lengthMenu'] . ',';
    }
    $iDisplayLength = '';
    if ($opt['iDisplayLength'] != '') {
        $iDisplayLength = '"iDisplayLength": ' . $opt['iDisplayLength'] . ',';
    }
    $tabIndex = '';
    if ($opt['tabIndex'] != '') {
        $tabIndex = '"tabIndex": ' . $opt['tabIndex'] . ',';
    }
    $order = '';
    if ($opt['order'] != '') {
        $order = '"order": ' . $opt['order'] . ',';
    }

    $columns = '';
    if (is_array($opt['columns'])) {
        if (sizeof($opt['columns']) >= 1) {
            $txtcols = '[';
            foreach ($opt['columns'] as $key => $col) {
                $txtcols .= '{ "data": "' . $col . '" },';
            }
            $txtcols .= ']';
            $columns = '"columns": ' . $txtcols . ',';
        }
    }


    $columnDefs = '';
    if (is_array($opt['columnDefs'])) {
        if (sizeof($opt['columnDefs']) >= 1) {
            $txtcols = '[';
            foreach ($opt['columnDefs'] as $key => $col) {
                $txtcols .= '{ "width": "' . $col . '", "targets": ' . $key . ' },';
            }
            $txtcols .= ']';
            $columnDefs = '"columnDefs": ' . $txtcols . ',';
        }
    } else {
        $columnDefs = '"columnDefs": ' . $opt['columnDefs'] . ',';
    }


    $return = '
    
    var table=$(\'#' . $opt['id'] . '\').DataTable( {
        ' . $columnDefs . '
        ' . $typetext . '
        ' . $lengthMenu . '
        ' . $iDisplayLength . '
        ' . $order . '
        ' . $columns . '
        ' . $tabIndex . '
        language: {
    ' . $opt['language'] . '
},
"drawCallback": function (Settings) {
$(\'[data-popup="tooltip"]\').tooltip();
' . $opt['drawCallback'] . '
},
   } );
    
    
    
    ';

    global $View;
    $View->header_styles_files('/modules/cp/assets/datatable/datatables.min.css');
    $View->footer_js_files('/modules/cp/assets/datatable/datatables.min.js');
    return $return;
}

function datatable_view($options = [])
{
    global $database;
    $opt = [
        "CountAll" => 0,
        "lists" => [],
        "data" => [],
    ];

    if (sizeof($options) >= 1) {
        foreach ($options as $tr => $val) {
            if (isset($opt[$tr])) {
                $opt[$tr] = $val;
            }
        }
    }
    $return = '';


    $results = array(
        "draw" => $_POST["draw"],
        "iTotalRecords" => $opt['CountAll'],
        "iTotalDisplayRecords" => $opt['CountAll'],
        "aaData" => $opt['data']);
    return json_encode($results);
}

function datatable_get_opt()
{
    $return = false;
    if (isset($_POST['columns'])) {

        $start = $_POST['start'];
        $length = $_POST['length'];

        if (!isset($_POST['search']['value']) || $_POST['search']['value'] == "") {
            $search = '';
        } else {
            $search = $_POST['search']['value'];

        }

        $orderby = $_POST['columns'][$_POST['order'][0]['column']]['data'];
        $orderval = strtoupper($_POST['order'][0]['dir']);

        $return = [
            "search" => $search,
            "orderby" => $orderby,
            "orderval" => $orderval,
            "start" => $start,
            "length" => $length,
        ];
    }
    return $return;
}

function alert($options = [])
{
    $opt = [
        "type" => 'info',
        "class" => 'alert text-center IRANSans alert-',
        "elem" => 'div',
        "text" => __("done"),
    ];

    if (sizeof($options) >= 1) {
        foreach ($options as $tr => $val) {
            if (isset($opt[$tr])) {
                $opt[$tr] = $val;
            }
        }
    }
    $butshow = '';
    $butshow_start = '';
    $butshow_end = '';
    if ($opt['elem'] != '') {
        $butshow_start .= '<' . $opt['elem'];
        if ($opt['class'] != '') {
            $butshow_start .= ' class="' . $opt['class'];
            if ($opt['type'] != '') {
                $butshow_start .= $opt['type'];
            }
            $butshow_start .= '" ';
        }
        $butshow_start .= '>';

        $butshow_end .= '</' . $opt['elem'] . '>';
    }

    $butshow = $butshow_start . $opt['text'] . $butshow_end;


    return $butshow;
}

function alertWarning($text="")
{
    if($text==""){
        $text=__("warning");
    }
    return alert([
        "type" => "warning",
        "text" => $text,
    ]);
}

function alertSuccess($text="")
{
	if($text==""){
		$text=__("success");
	}
	return alert([
        "type" => "success",
        "text" => $text,
    ]);
}

function alertDanger($text="")
{
	if($text==""){
		$text=__("danger");
	}
	return alert([
        "type" => "danger",
        "text" => $text,
    ]);
}

function alertInfo($text="")
{
	if($text==""){
		$text=__("info");
	}
	return alert([
        "type" => "info",
        "text" => $text,
    ]);
}

function fault()
{
	return alert([
        "type" => "danger",
        "text" => __("fault"),
        "elem" => "span"
    ]);
}

function modal_create($options = [])
{
    $option = [
        "id" => 'modal_global',
        "size" => '',
        "title" => '',
        "title-size" => 6,
        "text" => loading_fa(),
        "bg" => "",
    ];
    if (sizeof($option) >= 1) {
        foreach ($option as $key => $opt) {
            if (isset($options[$key])) {
                $option[$key] = $options[$key];
            }
        }
    }
    if ($option['size'] != '') {
        $option['size'] = 'modal-' . $option['size'];
    }
    if ($option['bg'] != '') {
        $option['bg'] = 'bg-' . $option['bg'];
    }

    ?>
    <div id="<?php echo $option['id']; ?>" class="modal fade IRANSans">
        <div class="modal-dialog <?php echo $option['size']; ?>">
            <div class="modal-content">
                <div class="modal-header <?php echo $option['bg']; ?>">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h<?php echo $option['title-size']; ?> class="modal-title"
                                                           id="<?php echo $option['id']; ?>_title"><?php echo $option['title']; ?></h<?php echo $option['title-size']; ?>>

                </div>
                <div class="modal-body" id="<?php echo $option['id']; ?>_body">
                    <?php echo $option['text'] ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function NestableTableGetData($id, $table, $lang, $parent = 0, $extra_float = "", $module = "")
{
    global $database;
    if ($module == "") {
        $selects = $database->select($table, '*', [
            "AND" => [
                "parent" => $parent,
                "status" => 'active',
            ],
            "ORDER" => ["parent" => "ASC", "sort" => "ASC"]
        ]);
    } else {
        $selects = $database->select($table, '*', [
            "AND" => [
                "parent" => $parent,
                "module" => $module,
                "status" => 'active',
            ],
            "ORDER" => ["parent" => "ASC", "sort" => "ASC"]
        ]);
    }
    if (sizeof($selects) >= 1) {
        ?>
    <ol class="dd-list dd-list-<?php echo JK_DIRECTION; ?>" id="nestable_dd_list_<?php echo $id; ?>">
        <?php
        foreach ($selects as $select) {
            ?>
            <li class="dd-item dd3-item" data-id="<?php echo $select['id'] ?>">
                <div class="dd-handle dd3-handle"></div>
                <div class="dd3-content"><?php
                    if ($lang == "") {
                        $title = $select['title'];
                    } else {
                        $title = langDefineGet($lang, $table, 'id', $select['id']);
                    }
                    if ($title == "") {
                        $title = '<span class="text-muted">' . __("not defined") . '</span>';
                    }
                    echo $title;
                    ?>
                    <span class="float-<?php echo JK_DIRECTION_SIDE_R; ?>" style="margin-top: -5px;">
                        <?php
                        if (isset($extra_float[$select['id']])) {
                            echo $extra_float[$select['id']];
                        }
                        ?>
                        <a class="btn btn-sm "
                           href="javascript:;"
                           onclick="nestableEdit_<?php echo $id; ?>(<?php echo $select['id']; ?>)">
                                    <i class="fa fa-edit text-info"></i>
                                </a>
                        <a class="btn btn-sm "
                           href="javascript:;"
                           onclick="nestableRemove_<?php echo $id; ?>(<?php echo $select['id']; ?>)">
                                                            <i class="fa fa-times text-danger"></i>
                                                        </a>
</span>
                </div>
                <?php

                NestableTableGetData($id, $table, $lang, $select['id'], $extra_float, $module);

                ?>
            </li>
            <?php

        }
        ?></ol><?php

    }
}

function NestableTableInitHtml($id)
{
    ?>
    <div class="dd" id="nestable_ajax_<?php echo $id; ?>"></div>
    <div id="nestable_sort_result_<?php echo $id; ?>"></div>
    <textarea title="nestable_list_ajax_output_<?php echo $id; ?>" id="nestable_list_ajax_output_<?php echo $id; ?>"
              class="d-none"></textarea>
    <?php
}

function NestableTableJS($id, $sortURL, $group = 1, $maxDepth = 3)
{
    global $View;
    $View->footer_js('
<script>
    $( document ).ready(function() {
        var UINestable = function () {
            var t = function (t) {
                var e = t.length ? t : $(t.target), a = e.data("output");
                window.JSON ? a.val(window.JSON.stringify(e.nestable("serialize"))) : a.val("JSON browser support required for this demo.")
            };
            return {
                init: function () {
                    $("#nestable_ajax_' . $id . '").nestable({group: ' . $group . ',maxDepth:' . $maxDepth . '}).on("change",function(e) {
                       t($("#nestable_ajax_' . $id . '").data("output", $("#nestable_list_ajax_output_' . $id . '")));
                       ' . ajax_load([
            "url" => $sortURL,
            "success_response" => "#nestable_sort_result_" . $id,
            "data" => "{sortval:$(\"#nestable_list_ajax_output_" . $id . "\").val()}",
            "loading" => [
            ]
        ]) . '
                    });
                    $("#list_ajax_menu").on("click", function (t) {
                        var e = $(t.target), a = e.data("action");
                    });
                }
            }
        }();

        UINestable.init();
    });
</script>
');
}

function NesatableUpdateSortData($table, $data)
{
    $jde = json_decode($data, true);
    NesatableUpdateSort($table, 0, $jde);
}

function NesatableUpdateSort($table, $sub, $jde)
{
    global $database;
    $js = 0;
    foreach ($jde as $j) {
        $database->update($table, [
            "parent" => $sub,
            "sort" => $js,
        ], [
            "id" => $j['id']
        ]);
        $js++;
        if (isset($j['children']) && is_array($j['children'])) {
            NesatableUpdateSort($table, $j['id'], $j['children']);
        }

    }
}

function langDefineGet($lang, $table, $column, $var)
{
    global $database;
    $back = '';
    $text = $database->get("jk_lang_defined", ["text"], [
        "AND" => [
            "tableName" => $table,
            "lang" => $lang,
            "varCol" => $column,
            "var" => $var,
        ]
    ]);
    if (isset($text['text'])) {
        $back = $text['text'];
    }
    return $back;
}

function langDefineSet($lang, $table, $column, $var, $text)
{
    global $database;
    $get = $database->get("jk_lang_defined", ["id", "text"], [
        "AND" => [
            "tableName" => $table,
            "lang" => $lang,
            "varCol" => $column,
            "var" => $var,
        ]
    ]);
    if (isset($get['text'])) {
        $database->update('jk_lang_defined', [
            "text" => $text
        ], [
            "id" => $get['id']
        ]);
    } else {
        $database->insert("jk_lang_defined", [
            "tableName" => $table,
            "lang" => $lang,
            "varCol" => $column,
            "var" => $var,
            "text" => $text
        ]);
    }
}
function langDefineSearch($lang, $table, $column, $search)
{
    global $database;
    $searchs = $database->select("jk_lang_defined", "var", [
        "AND" => [
            "tableName" => $table,
            "lang" => $lang,
            "varCol" => $column,
            "text[~]" => $search,
        ]
    ]);
    return $searchs;
}
function tab_menus($menus, $link, $pathCheck = 1)
{

    global $Route;
    global $ACL;
    if (isset($Route->path[$pathCheck])) {
        $active = $Route->path[$pathCheck];
    } else {
        $active = "";
    }
    if ($menus >= 1 && sizeof($menus) >= 1) {
        ?>
        <ul class="nav nav-tabs pr-0 pl-0">
            <?php
            foreach ($menus as $menu) {
                $continue = true;
                if (isset($menu['permissions']) && !$ACL->hasPermission($menu['permissions'])) {
                    $continue = false;
                }
                if ($continue) {
                    ?>
                    <li class="nav-item <?php if ($active == $menu['link']) { ?>active<?php } ?>">
                        <a class="nav-link" href="<?php echo $link . $menu['link']; ?>">
                            <i class="<?php echo $menu['icon']; ?> position-left"></i>
                            <?php echo $menu['title']; ?>
                        </a>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
        <?php
    }

}

function div_start($class = '', $id = '', $close = false)
{
    if ($class != '') {
        $class = ' class="' . $class . '"';
    }
    if ($id != '') {
        $id = ' id="' . $id . '"';
    }
    $append = '';
    if ($close) {
        $append = '</div>';
    }
    return '<div' . $class . $id . '>' . $append;
}

function div_close($after = '')
{
    return '</div>' . $after;
}

function clearfix()
{
    return "<div class='clearfix'></div>";
}

function hr_html()
{
    return "<hr/>";
}

function jk_options_get($name)
{
    global $database;
    return $database->get('jk_options', 'value', [
        "name" => $name
    ]);
}

function jk_options_set($name, $value)
{
    global $database;
    $option = $database->get('jk_options', '*', [
        "name" => $name
    ]);
    if (!isset($option['id'])) {
        $database->insert('jk_options', [
            "name" => $name,
            "value" => $value,
        ]);
        $optionID = $database->id();
        if ($optionID >= 1) {
            $option = $database->get('jk_options', '*', [
                "id" => $optionID
            ]);
        }
    } else {
        $database->update('jk_options', [
            "value" => $value
        ], [
            "name" => $name,
        ]);
        $option = $database->get('jk_options', '*', [
            "name" => $name
        ]);
    }
    return $option['value'];

}

function emailSend($fromEmail,$toMails, $subject, $text, $options = [])
{
    global $database;
    $email=$database->get('jk_emails',"*",[
            "email"=>$fromEmail
    ]);
    if(!isset($email['id'])){
        return 'Email '.$fromEmail.' Not Set';
    }
    $SMTPMailServer = $email['server'];
    $SMTPMailPort = $email['port'];
    $SMTPMailUserName = $email['username'];
    $SMTPMailPassword = $email['password'];
    $SMTPMailFromName = $email['fromName'];
    $SMTPMailSecure = $email['secureType'];
    $SMTPMailDebug = $email['debug'];

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = $SMTPMailDebug;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $SMTPMailServer;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $SMTPMailUserName;                 // SMTP username
        $mail->Password = $SMTPMailPassword;                           // SMTP password
        $mail->SMTPSecure = $SMTPMailSecure;                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $SMTPMailPort;                                    // TCP port to connect to
        $mail->CharSet = 'UTF-8';
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );// Set mailer to use SMTP
        //Recipients
        $mail->setFrom($fromEmail, $SMTPMailFromName);
        if (is_array($toMails)) {
            foreach ($toMails as $em) {
                if (is_array($em) && isset($em['name'])) {
                    $name = $em['name'];
                    $email2 = $em['email'];
                } else {
                    $name = $em;
                    $email2 = $name;
                }
                $mail->addAddress($email2, $name);     // Add a recipient
            }
        } else {
            $mail->addAddress($toMails);     // Add a recipient

        }

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML


        if (isset($options['BCC']) && is_array($options['BCC'])) {
            foreach ($options['BCC'] as $bcc) {
                if ($bcc != '') {
                    $mail->addBCC($bcc);
                }
            }
        }

        if (isset($options['embeded'])) {
            $mail->AddEmbeddedImage(JK_DIR_INCLUDES . 'templates' . DS . $options['embeded'], $options['embeded']);
        }


        if (file_exists(JK_DIR_INCLUDES . 'templates' . DS . 'emails'.DS.'emailTpl-' . JK_DIRECTION . '.html')) {
            $htmlbody = file_get_contents(JK_DIR_INCLUDES . 'templates' . DS . 'emails'.DS.'emailTpl-' . JK_DIRECTION . '.html');
            $htmlbody = str_replace('%{%text%}%', $text, $htmlbody);
            if (isset($options['autoSender']) && $options['autoSender'] != false) {
                $htmlbody = str_replace('%{%autosender%}%', $options['autoSender'], $htmlbody);
            } else {
                $htmlbody = str_replace('%{%autosender%}%', __("Please do not reply to this email; this address is not monitored. Please use our contact page."), $htmlbody);
            }
        } else {
            $htmlbody = $text;
        }


        if (isset($options['attachments']) && is_array($options['attachments'])) {
            $attachs = $options['attachments'];
            if (sizeof($attachs) >= 1) {
                foreach ($attachs as $attach) {
                    if (isset($attach['path']) && isset($attach['name']))
                        $mail->addAttachment($attach['path'], $attach['name']);
                }
            }

        }

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $htmlbody;
        $mail->AltBody = $text;
        $mail->Timeout = 10;

        $mail->AltBody = $text;

        $mail->send();
        return "sent";
    } catch (Exception $e) {
        return 'Message could not be sent. Mailer Error: ' . $e->getMessage();
    }
}

function emailTemplate($templateName, $lang, $arguments = [])
{
    global $database;
    $text = "";
    $gettext = $database->get('jk_emailTemplate', "*", [
        "AND" => [
            "name" => $templateName,
            "lang" => $lang,
        ]
    ]);
    if (isset($gettext['id'])) {
        $text = $gettext['text'];
        if (sizeof($arguments) >= 1) {
            foreach ($arguments as $key => $arg) {
                $text = str_replace('[%' . $key . '%]', $arg, $text);
            }
        }
    }
    return $text;
}

function tokenGenerate($string = "")
{
    if ($string == "") {
        $string = time();
    }
    $string = md5(uniqid($string . time(), true));
    return $string;
}

function tokenGenerateUsers($userID, $source = "forgotLink", $validToSec = 3600)
{
    global $database;
    $has = true;
    while ($has) {
        $string = md5(uniqid($userID . time(), true));
        $has = $database->has("jk_users_token", [
            "token" => $string
        ]);
    }
    $database->insert('jk_users_token', [
        "userID"=>$userID,
        "source"=>$source,
        "token"=>$string,
        "validUntil"=>date("Y/m/d H:i:s",time()+$validToSec),
    ]);
    return $string;
}
function emailsArray(){
    global $database;
    return $database->select('jk_emails','email',[
    ]);
}
function ArrayKeyEqualValue($array){
    $back=[];
    if(sizeof($array)>=1){
        foreach ($array as $arr){
            $back[$arr]=$arr;
        }
    }
    return $back;
}
function statusReturnConfirmedUnconfirmed($status){
    switch ($status) {
        case "confirmed":
            $st = __("confirmed");;
            break;
        case "unconfirmed":
            $st = __("unconfirmed");
            break;
        default:
            $st = __("unknown");
    }
    return $st;
}
function statusReturnYesNoInt($status){
    switch ($status) {
        case "0":
            $st = __("no");;
            break;
        case "1":
            $st = __("yes");
            break;
        default:
            $st = __("unknown");
    }
    return $st;
}
function arrayToKey($array){
    $back=[];
    if(sizeof($array)>=1){
        foreach ($array as $arr){
            $back[$arr]=$arr;
        }
    }
    return $back;
}