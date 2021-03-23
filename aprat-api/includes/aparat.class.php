<?php
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
        public function mostviewedvideos($limit)
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
        public function lastvideos($perPage)
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
        public function vitrinvideos($limit)
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
        public function categories()
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
        public function categoryvideos($cat, $perPage)
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
        public function videohash($id)
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
        public function videoRecom($id, $perPage)
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
        public function videobyuser($username, $perPage)
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
        public function commentByVideo($id, $perPage)
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
        public function videoBySearch($text, $perPage)
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
        public function userBySearch($username, $perPage)
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
        public function profile($username)
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
        /**
         * Aparat::official()
         * Parameters: perpage(6)
         * @return
         */
        public function official()
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
        public function config_xml_to_array($id, $main_heading = '')
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
        public function view($id, $height, $width, $type = 'iframe')
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
    }
?>