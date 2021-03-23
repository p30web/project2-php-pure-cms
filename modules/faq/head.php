<?php
if (!defined('jk')) die('Access Not Allowed !');
function textCode_faq_list($stringVar = [])
{
    $html = '';
    if (is_array($stringVar) && isset($stringVar['id'])) {
        $id = $stringVar['id'];
        global $database;
        $faqs = $database->select('faq_list', '*', [
            "AND" => [
                "status" => "active",
                "module" => $id,
            ]
        ]);
        if (sizeof($faqs) >= 1) {
            $ulClass = "accordion";
            $liClassTitle = "accordion-item-title";
            $liClassContent = "accordion-item-content";
            $liClassActiveTitle = "active";
            $liClassActiveContent = "";
            $liClassInActiveTitle = "";
            $liClassInActiveContent = "accordion-hide";


            if (isset($stringVar['ul-class'])) {
                $ulClass = $stringVar['ul-class'];
            }
            if (isset($stringVar['li-class-title'])) {
                $liClassTitle = $stringVar['li-class-title'];
            }
            if (isset($stringVar['li-class-content'])) {
                $liClassContent = $stringVar['li-class-content'];
            }

            if (isset($stringVar['li-class-active-title'])) {
                $liClassActiveTitle = $stringVar['li-class-active-title'];
            }
            if (isset($stringVar['li-class-active-content'])) {
                $liClassActiveContent = $stringVar['li-class-active-content'];
            }
            if (isset($stringVar['li-class-inactive-title'])) {
                $liClassInActiveTitle = $stringVar['li-class-inactive-title'];
            }
            if (isset($stringVar['li-class-inactive-content'])) {
                $liClassInActiveContent = $stringVar['li-class-inactive-content'];
            }


            $html .= '<div class="' . $ulClass . '" id="accordion_faq_' . $id . '">';

            $iac = 1;
            $activeac = 1;
            foreach ($faqs as $faq) {
                $Class = $liClassInActiveTitle;
                $ClassSub = $liClassInActiveContent;
                if ($activeac == $iac) {
                    $Class = $liClassActiveTitle;
                    $ClassSub = $liClassActiveContent;
                }
                $html .= '<h2 class="'.$liClassTitle.' ' . $Class . '">' . $iac . ' - ' . $faq['title'] . '</h2>';
                $html .= '<div class="'.$liClassContent.' ' . $Class . ' ' . $ClassSub . '">' . $faq['answer'] . '</div>';
                $iac += 1;
            }
            $html .= '</div>';
            global $View;
            $View->header_styles_files('/modules/faq/files/smoothAccording.min.css');
            $View->footer_js_files('/modules/faq/files/smoothAccording.min.js');
            $View->footer_js('<script>$("#accordion_faq_'.$id.'").smoothAccordion();</script>');
        }
    }
    return $html;
}