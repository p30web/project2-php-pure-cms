<?php

namespace Joonika;
if(!defined('jk')) die('Access Not Allowed !');

    /**
     * Aparat Class
     *
     * @tools of this package :
     * function::mostviewedvideos()
     * function::lastvideos()
     * function::vitrinvideos()
     * function::categories()
     * function::categoryvideos()
     * function::videohash()
     * function::videoRecom()
     * function::videobyuser()
     * function::commentByVideo()
     * function::videoBySearch()
     * function::userBySearch()
     * function::profile()
     * function::official()
     *
     * @author seyed amirhoosein tavousi.
     * @copyright 2015
     * @last update : 11/01/2015
     */
    class Aparat
    {
        const api_adress = 'http://www.aparat.com/etc/api/';
        const xml_config = 'http://www.aparat.com/video/video/config/videohash/[ID]/watchtype/site';
        public function getDataInArray($JSON_ADRESS)
        {
            $json = json_decode(file_get_contents(self::api_adress . $JSON_ADRESS), true);
            return ($json != NULL) ? $json : die(NULL);
        }
        /**
         * Aparat::mostviewedvideos()
         * Parameters: none
         * @return
         */
        function mostviewedvideos($limit)
        {
            /**
             * Output::id => numeric
             * Output::title => *
             * Output::username	=> username
             * Output::visit_cnt => numeric	 
             * Output::uid => video code in aparat server
             * Output::process => -
             * Output::big_poster => link of image	 
             * Output::small_poster => link of image		 
             * Output::profilePhoto => link of image
             * Output::duration => in secend / numeric
             * Output::sdate => Shamsi date with persian numbers
             */
            $i    = 0;
            $json = $this->getDataInArray('mostviewedvideos');
            foreach ($json as $objects => $single):
                foreach ($single as $key => $value):
                    if ($i == $limit)
                        break;
                    if (!empty($value['id'])):
                        $Data[$key] = $value;
                    endif;
                    $i++;
                endforeach;
            endforeach;
            return $Data;
        }
        /**
         * Aparat::lastvideos()
         * Parameters: perpage(6)
         * @return
         */
        function lastvideos($perPage)
        {
            /**
             * Output::id => numeric
             * Output::title => *
             * Output::username	=> username
             * Output::visit_cnt => numeric	 
             * Output::uid => video code in aparat server
             * Output::process => -
             * Output::big_poster => link of image	 
             * Output::small_poster => link of image		 
             * Output::profilePhoto => link of image
             * Output::duration => in secend / numeric
             * Output::sdate => Shamsi date with persian numbers
             */
            $perPage = (!empty($perPage)) ? '/perpage/' . $perPage : '';
            $json    = $this->getDataInArray('lastvideos' . $perPage);
            foreach ($json as $objects => $single):
                foreach ($single as $key => $value):
                    if (!empty($value['id'])):
                        $Data[$key] = $value;
                    endif;
                endforeach;
            endforeach;
            return $Data;
        }
        /**
         * Aparat::vitrinvideos()
         * Parameters: none
         * @return
         */
       function vitrinvideos($limit)
        {
            /**
             * Output::id => numeric
             * Output::title => *
             * Output::username	=> username
             * Output::visit_cnt => numeric	 
             * Output::uid => video code in aparat server
             * Output::process => -
             * Output::big_poster => link of image	 
             * Output::small_poster => link of image		 
             * Output::profilePhoto => link of image
             * Output::duration => in secend / numeric
             * Output::sdate => Shamsi date with persian numbers
             */
            $i    = 0;
            $json = $this->getDataInArray('vitrinvideos');
            foreach ($json as $objects => $single):
                foreach ($single as $key => $value):
                    if ($i == $limit)
                        break;
                    if (!empty($value['id'])):
                        $Data[$key] = $value;
                    endif;
                endforeach;
            endforeach;
            return $Data;
        }
        /**
         * Aparat::categories()
         * Parameters: none
         * @return
         */
        function categories()
        {
            /**
             * Output::id => numeric
             * Output::name => *
             * Output::videoCnt	=> numeric
             */
            $json = $this->getDataInArray('categories');
            foreach ($json as $objects => $single):
                foreach ($single as $key => $value):
                    $Data[$key] = $value;
                endforeach;
            endforeach;
            return $Data;
        }
        /**
         * Aparat::categoryvideos()
         * Parameters: cat(all) - perpage(6)
         * @return
         */
        function categoryvideos($cat, $perPage)
        {
            /**
             * Output::id => numeric
             * Output::title => *
             * Output::username	=> username
             * Output::visit_cnt => numeric	 
             * Output::uid => video code in aparat server
             * Output::process => -
             * Output::big_poster => link of image	 
             * Output::small_poster => link of image		 
             * Output::profilePhoto => link of image
             * Output::duration => in secend / numeric
             * Output::sdate => Shamsi date with persian numbers
             */
            $perPage = (!empty($perPage)) ? '/perpage/' . $perPage : '';
            $cat     = (!empty($cat)) ? $cat : 'all';
            $json    = $this->getDataInArray('categoryvideos/cat/' . $cat . $perPage);
            foreach ($json as $objects => $single):
                foreach ($single as $key => $value):
                    if (!empty($value['id'])):
                        $Data[$key] = $value;
                    endif;
                endforeach;
            endforeach;
            return $Data;
        }
        /**
         * Aparat::videohash()
         * Parameters: videohash - visittype
         * @return
         */
        function videohash($id)
        {
            /**
             * Output::id => numeric
             * Output::title => *
             * Output::username	=> username
             * Output::visit_cnt => numeric	 
             * Output::uid => video code in aparat server
             * Output::process => -
             * Output::process => Name of user *
             * Output::big_poster => link of image	 
             * Output::small_poster => link of image		 
             * Output::profilePhoto => link of image
             * Output::duration => in secend / numeric
             * Output::sdate => Shamsi date with persian numbers
             * Output::frame => link of video iframe		 
             * Output::tags => Array
             * Output::tag_str => tags with "-"
             * Output::description => *		 
             * Output::owner_official => if owner is official
             * Output::cat_id => Category id	 
             * Output::cat_name => Persian category name
             * Output::size => in byte / numeric
             * Output::tag_str_formal => tags with ","					 
             */
            $json = $this->getDataInArray('video/videohash/' . $id);
            if (empty($json['video']['id'])):
                return NULL;
            endif;
            foreach ($json as $objects => $single):
                foreach ($single as $key => $value):
                    $Data[$key] = $value;
                endforeach;
            endforeach;
            $tags = '';
            foreach ($Data['tags'] as $k => $v) {
                $tags .= $v['name'] . ',';
            }
            $Data['tag_str_formal'] = rtrim($tags, ",");
            return $Data;
        }
        /**
         * Aparat::videoRecom()
         * Parameters: videohash - perpage(6)
         * @return
         */
        function videoRecom($id, $perPage)
        {
            /**
             * Output::id => numeric
             * Output::title => *
             * Output::username	=> username
             * Output::visit_cnt => numeric	 
             * Output::uid => video code in aparat server
             * Output::process => -
             * Output::big_poster => link of image	 
             * Output::small_poster => link of image		 
             * Output::profilePhoto => link of image
             * Output::duration => in secend / numeric
             * Output::sdate => Shamsi date with persian numbers
             */
            $perPage = (!empty($perPage)) ? '/perpage/' . $perPage : '';
            $json    = $this->getDataInArray('videoRecom/videohash/' . $id . $perPage);
            foreach ($json as $objects => $single):
                foreach ($single as $key => $value):
                    if (!empty($value['id'])):
                        $Data[$key] = $value;
                    endif;
                endforeach;
            endforeach;
            return $Data;
        }
        /**
         * Aparat::videobyuser()
         * Parameters: username - perpage(6)
         * @return
         */
        function videobyuser($username, $perPage)
        {
            /**
             * Output::id => numeric
             * Output::title => *
             * Output::username	=> username
             * Output::visit_cnt => numeric	 
             * Output::uid => video code in aparat server
             * Output::process => -
             * Output::big_poster => link of image	 
             * Output::small_poster => link of image		 
             * Output::profilePhoto => link of image
             * Output::duration => in secend / numeric
             * Output::sdate => Shamsi date with persian numbers
             */
            $perPage = (!empty($perPage)) ? '/perpage/' . $perPage : '';
            $json    = $this->getDataInArray('videobyuser/username/' . $username . $perPage);
            foreach ($json as $objects => $single):
                foreach ($single as $key => $value):
                    if (!empty($value['id'])):
                        $Data[$key] = $value;
                    endif;
                endforeach;
            endforeach;
            return $Data;
        }
        /**
         * Aparat::commentByVideo()
         * Parameters: videohash - perpage(6)
         * @return
         */
        function commentByVideo($id, $perPage)
        {
            /**
             * Output::id => numeric
             * Output::title => *
             * Output::username	=> username
             * Output::visit_cnt => numeric	 
             * Output::uid => video code in aparat server
             * Output::process => -
             * Output::big_poster => link of image	 
             * Output::small_poster => link of image		 
             * Output::profilePhoto => link of image
             * Output::duration => in secend / numeric
             * Output::sdate => Shamsi date with persian numbers
             */
            $perPage = (!empty($perPage)) ? '/perpage/' . $perPage : '';
            $json    = $this->getDataInArray('commentByVideo/videohash/' . $id . $perPage);
			if (empty($json['commentbyvideo'])):
                return NULL;
            endif;
            foreach ($json as $objects => $single):
                foreach ($single as $key => $value):
                    if (!empty($value['username'])):
                        $Data[$key] = $value;
                    endif;
                endforeach;
            endforeach;
            return $Data;
        }
        /**
         * Aparat::videoBySearch()
         * Parameters: text - perpage(6)
         * @return
         */
        function videoBySearch($text, $perPage)
        {
            /**
             * Output::id => numeric
             * Output::title => *
             * Output::username	=> username
             * Output::visit_cnt => numeric	 
             * Output::uid => video code in aparat server
             * Output::process => -
             * Output::big_poster => link of image	 
             * Output::small_poster => link of image		 
             * Output::profilePhoto => link of image
             * Output::duration => in secend / numeric
             * Output::sdate => Shamsi date with persian numbers
             */
            $perPage = (!empty($perPage)) ? '/perpage/' . $perPage : '';
            $json    = $this->getDataInArray('videoBySearch/text/' . $text . $perPage);
            foreach ($json as $objects => $single):
                foreach ($single as $key => $value):
                    if (!empty($value['id'])):
                        $Data[$key] = $value;
                    endif;
                endforeach;
            endforeach;
            return $Data;
        }
        /**
         * Aparat::userBySearch()
         * Parameters: text - perpage(6)
         * @return
         */
        function userBySearch($username, $perPage)
        {
            /**
             * Output::pic_s => link of image
             * Output::pic_m => link of image
             * Output::pic_b	=> link of image
             * Output::username => *
             * Output::name => *
             * Output::video_cnt => numeric
             * Output::url => url of user 
             * Output::follower_cnt => numeric		 
             * Output::descr => *
             * Output::official => yes/no
             */
            $perPage = (!empty($perPage)) ? '/perpage/' . $perPage : '';
            $json    = $this->getDataInArray('userBySearch/text/' . $username . $perPage);
            foreach ($json as $objects => $single):
                foreach ($single as $key => $value):
                    if (!empty($value['username'])):
                        $Data[$key] = $value;
                    endif;
                endforeach;
            endforeach;
            return $Data;
        }
        /**
         * Aparat::profile()
         * Parameters: username
         * @return
         */
        function profile($username)
        {
            /**
             * Output::pic_s => link of image
             * Output::pic_m => link of image
             * Output::pic_b	=> link of image
             * Output::username => *
             * Output::name => *
             * Output::video_cnt => numeric
             * Output::url => url of user 
             * Output::follower_cnt => numeric		 
             * Output::descr => *
             * Output::official => yes/no
             */
            $json = $this->getDataInArray('profile/username/' . $username);
            if ($json['profile'] != NULL):
                foreach ($json as $objects => $single):
                    foreach ($single as $key => $value):
                        $Data[$key] = $value;
                    endforeach;
                endforeach;
            endif;
            return $Data;
        }


        Function profilecategories ($username){
            $json = $this->getDataInArray('profilecategories/username/' . $username);
            $Data = '';
            if ($json['profilecategories'] != NULL):
                foreach ($json as $objects => $single):
                    foreach ($single as $key => $value):
                        $Data[$key] = $value;
                    endforeach;
                endforeach;
            endif;
            return $Data;
        }
        /**
         * Aparat::official()
         * Parameters: perpage(6)
         * @return
         */
        function official()
        {
            /**
             * Output::pic_s => link of image
             * Output::pic_m => link of image
             * Output::pic_b	=> link of image
             * Output::username => *
             * Output::name => *
             * Output::video_cnt => numeric
             * Output::url => url of user 
             * Output::follower_cnt => numeric		 
             * Output::descr => *
             * Output::official => yes/no
             */
            $perPage = (!empty($perPage)) ? '/perpage/' . $perPage : '';
            $json    = $this->getDataInArray('official' . $perPage);
            foreach ($json as $objects => $single):
                foreach ($single as $key => $value):
                    if (!empty($value['username'])):
                        $Data[$key] = $value;
                    endif;
                endforeach;
            endforeach;
            return $Data;
        }
        /**
         * Aparat::config_xml_to_array()
         * Parameters: -
         * @return
         */
        function config_xml_to_array($id, $main_heading = '')
        {
            $deXml     = simplexml_load_string(file_get_contents(str_replace('[ID]', $id, self::xml_config)));
            $deJson    = json_encode($deXml);
            $xml_array = json_decode($deJson, TRUE);
            if (!empty($main_heading)) {
                $returned = $xml_array[$main_heading];
                return $returned;
            } else {
                return $xml_array;
            }
        }
        /**
         * Aparat::view()
         * Parameters: videohash - height - width - type(iframe / javascript)
         * @return
         */
        function view($id, $height, $width, $type = 'iframe')
        {
            switch ($type) {
                case "iframe":
                    return '<iframe 
				src="http://www.aparat.com/video/video/embed/videohash/' . $id . '/vt/frame" 
				frameborder="0" 
				allowFullScreen="true" 
				webkitallowfullscreen="true" 
				mozallowfullscreen="true" 
				height="' . $height . '" 
				width="' . $width . '"
				></iframe>';
                    break;
                case "javascript":
                    return '<div id="14211406981889247"><script type="text/JavaScript" src="http://www.aparat.com/embed/' . $id . '?data[rnddiv]=' . time() . rand(15, 5) . '&data[w]=' . $width . '"></script></div>';
                    break;
            }
        }

        function truncate($string,$del,$limit="...") {
            $len = strlen($string);
            if ($len > $del) {
                $new = substr($string,0,$del).$limit;
                return preg_replace('/[\x00-\x08\x10\x0B\x0C\x0E-\x19\x7F]'.
                    '|[\x00-\x7F][\x80-\xBF]+'.
                    '|([\xC0\xC1]|[\xF0-\xFF])[\x80-\xBF]*'.
                    '|[\xC2-\xDF]((?![\x80-\xBF])|[\x80-\xBF]{2,})'.
                    '|[\xE0-\xEF](([\x80-\xBF](?![\x80-\xBF]))|(?![\x80-\xBF]{2})|[\x80-\xBF]{3,})/S',
                    '', $new );
            }
            return $string;
        }
        function duration($seconds){
            $hours = floor($seconds / 3600);
            $mins = floor(($seconds - $hours*3600) / 60);
            $s = $seconds - ($hours*3600 + $mins*60);
            $mins = ($mins<10?"0".$mins:"".$mins);
            $s = ($s<10?"0".$s:"".$s);
            $time = ($hours>0?$hours.":":"").$mins.":".$s;
            return $time;
        }



        function sanitizeStringForUrl($string){
            $string = str_replace(' ', '_', $string);
            return $string;
        }


        function protect($string) {
            $protection = htmlspecialchars(trim($string), ENT_QUOTES);
            return $protection;
        }

        function success($text) {
            return '<div class="alert alert-success">'.$text.'</div>';
        }

        function info($text) {
            return '<div class="alert alert-info">'.$text.'</div>';
        }

        function error($text) {
            return '<div class="alert alert-danger">'.$text.'</div>';
        }

        function isValidUsername($str) {
            return preg_match('/^[a-zA-Z0-9-_]+$/',$str);
        }

        function isValidEmail($str) {
            return filter_var($str, FILTER_VALIDATE_EMAIL);
        }

        function decode_currency($currency) {
            if($currency == "USD") {
                return '$';
            } elseif($currency == "EUR") {
                return '&euro;';
            } else {
                return '$';
            }
        }

        function isValidURL($url) {
            return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
        }

        function pagination($murl,$idd = NULL,$query,$ver,$per_page = 10,$page = 1, $url = '?') {
            if($idd) { $ver = $ver."/".$idd; }
            $query = "SELECT COUNT(*) as `num` FROM {$query}";
            $row = mysql_fetch_array(mysql_query($query));
            $total = $row['num'];
            $adjacents = "2";

            $page = ($page == 0 ? 1 : $page);
            $start = ($page - 1) * $per_page;

            $prev = $page - 1;
            $next = $page + 1;
            $lastpage = ceil($total/$per_page);
            $lpm1 = $lastpage - 1;

            $pagination = "";
            if($lastpage > 1)
            {
                $pagination .= "<ul class='pagination'>";

                if ($lastpage < 7 + ($adjacents * 2))
                {
                    for ($counter = 1; $counter <= $lastpage; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<li><a class='active'>$counter</a></li>";
                        else
                            $pagination.= "<li><a href='$murl$ver/$counter'>$counter</a></li>";
                    }
                }
                elseif($lastpage > 5 + ($adjacents * 2))
                {
                    if($page < 1 + ($adjacents * 2))
                    {
                        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<li><a class='active'>$counter</a></li>";
                            else
                                $pagination.= "<li><a href='$murl$ver/$counter'>$counter</a></li>";
                        }
                        $pagination.= "<li class='disabled'>...</li>";
                        $pagination.= "<li><a href='$murl$ver/$lpm1'>$lpm1</a></li>";
                        $pagination.= "<li><a href='$murl$ver/$lastpage'>$lastpage</a></li>";
                    }
                    elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                    {
                        $pagination.= "<li><a href='$murl$ver/1'>1</a></li>";
                        $pagination.= "<li><a href='$murl$ver/2'>2</a></li>";
                        $pagination.= "<li class='disabled'><a>...</a></li>";
                        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<li><a class='active'>$counter</a></li>";
                            else
                                $pagination.= "<li><a href='$murl$ver/$counter'>$counter</a></li>";
                        }
                        $pagination.= "<li class='disabled'><a>..</a></li>";
                        $pagination.= "<li><a href='$murl$ver/$lpm1'>$lpm1</a></li>";
                        $pagination.= "<li><a href='$murl$ver/$lastpage'>$lastpage</a></li>";
                    }
                    else
                    {
                        $pagination.= "<li><a href='$murl$ver/1'>1</a></li>";
                        $pagination.= "<li><a href='$murl$ver/2'>2</a></li>";
                        $pagination.= "<li class='disabled'><a>..</a></li>";
                        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<li><a class='active'>$counter</a></li>";
                            else
                                $pagination.= "<li><a href='$murl$ver/$counter'>$counter</a></li>";
                        }
                    }
                }

                if ($page < $counter - 1){
                    $pagination.= "<li><a href='$murl$ver/$next'>Next</a></li>";
                    $pagination.= "<li><a href='$murl$ver/$lastpage'>Last</a></li>";
                }else{
                    $pagination.= "<li><a class='disabled'>Next</a></li>";
                    $pagination.= "<li><a class='disabled'>Last</a></li>";
                }
                $pagination.= "</ul>\n";
            }


            return $pagination;
        }

        function ViewFormat($View){
            number_format($View);
            if($View > 10000) {
                $views_count=$View *1/10000;
                $views_k=round($views_count,PHP_ROUND_HALF_UP);
                echo "$views_k K";}
            else{
                echo number_format($View);
            }
        }
    }
?>