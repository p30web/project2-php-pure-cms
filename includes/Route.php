<?php
namespace Joonika;
if(!defined('jk')) die('Access Not Allowed !');

class Route
{
    public $protocol = []; //http or https
    public $domainFull; //$protocol + $domain + '/' : example http://ipinbar.net/
    public $domain; // store website domain name from database
    public $websiteID;
    public $uri;   //uri without '/' start
    public $url;    //url without query string
    public $path = [];
    public $lang;
    public $direction;
    public $subFolder = 'pages';
    public $query_string; // query string
    public $forceNotRoute=false;
    public $themeRoute = true;
    public $langLocale = "en";
    public $theme = "one";

    public function __construct()
    {
        global $database;
        //specific http or https
        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
        ) {
            $this->protocol = 'https://';
        } else {
            $this->protocol = 'http://';
        }
        // get domain name + '/'
        $this->domainFull=$this->protocol.$_SERVER['HTTP_HOST'].'/';
        $this->domain=$_SERVER['HTTP_HOST'].'/';

        //get uri without start '/'
        $this->uri=ltrim($_SERVER['REQUEST_URI'],'/');

    $this->url=$this->domainFull.$this->uri;

        //ignore www. from url
        if(JK_APP_NON_WWW){
            if (substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: ' . $this->protocol . substr($_SERVER['HTTP_HOST'],4) . $_SERVER['REQUEST_URI']);
                exit;
            }
        }
        // divided url to 2 pieces $exp = url / query string
        $exp=explode('?',$this->url);
        //  parse url and get query string variable and put that in $_get array
        if(isset($exp[1])){
            parse_str($exp[1], $this->query_string);
            global $_GET;
            foreach ($this->query_string as $g=>$v){
                $_GET[$g]=$v;
            }
        }
        //remove '/' from end of uri
        if(substr($this->uri,-1)=='/'){
            header("HTTP/1.1 301 Moved Permanently");
            redirect_to(rtrim($this->url,"/"));
        }
        //redirect to url without http or https
        if($this->protocol=="http://" && JK_APP_FORCE_SSL){
            header("HTTP/1.1 301 Moved Permanently");
            redirect_to("https://".ltrim($this->url,$this->protocol));
        }
        // get domain from database and put that into website variable
        $website=$database->get('jk_websites','*',[
            "domain"=>$this->domain
        ]);

        if(!isset($website['id'])){
            Errors::errorHandler(0,"website not found" , __FILE__ , __LINE__);
        }

        $this->uri=$this->removeVariblesOfQueryString($this->uri);

        $path = array_values(array_filter(explode('/', $this->uri)));

        if(sizeof($path)==0){
            redirect_to($this->url.$website['defaultLang']);
        }

        $tempLang=$path[0];

        $getLang=$database->get('jk_languages','*',[
            "AND"=>[
                "websiteID"=>$website['id'],
                "slug"=>$tempLang
                ]
        ]);
        if(!isset($getLang['id'])){
            redirect_to($this->domainFull.$website['defaultLang'].'/'.$this->uri);
        }
        $this->websiteID=$website['id'];
        $this->lang=$getLang['slug'];
        $this->langLocale=$getLang['locale'];
        $this->direction=$getLang['direction'];


        $this->lang=$tempLang;
        $this->theme=$getLang['theme'];

        unset($tempLang);
        unset($path[0]);
        $path=array_values(array_filter($path));
        $this->path=$path;
    }


    public function findRoute($dir,$module,$path){
        $found_page=false;
        if($module!=""){
            if (is_readable($dir .$module.DS . 'router.php') && !$this->forceNotRoute) {
                $found_page = $dir .$module .DS. 'router.php';
                return $found_page;
            }
        $module.=DS.$this->subFolder.DS;
        }
        $pathsize=sizeof($path);
        for ($i = $pathsize - 1; $i >= 0; $i--) {
            $tmp1 = implode(DS, $path);
//            echo $dir .$module. $tmp1 . '.php'.'<br/>';
            if (is_readable($dir .$module. $tmp1 . '.php')) {
                $found_page = $dir .$module. $tmp1 . '.php';
                return $found_page;
            } else {
                $path=array_values($path);
                unset($path[sizeof($path)-1]);
                $path=array_values($path);
            }
        }
    }


    public function dispatch()
    {
        global $View;
        $fileDIR = JK_DIR_THEMES  . $this->theme . DS;
        $path_t = $this->path;
        $found_page = false;

        if (is_array($path_t) && sizeof($path_t) >= 1) {
//            $path_t=array_reverse($path_t);
            if($this->themeRoute){
                $found_page=$this->findRoute($fileDIR,'',$path_t);
            }
            if(!$found_page){
                $mod_temp=$path_t[0];
                unset($path_t[0]);
                array_values($path_t);
                $found_page=$this->findRoute(JK_DIR_MODULES,$mod_temp,$path_t);
            }

        }else{
            if (is_readable($fileDIR . 'index.php')) {
                $found_page = $fileDIR.'index.php';
            }
        }
        if(!$found_page && isset($this->path[0])){
            global $database;
            $data=$database->get('jk_data','*',[
                "slug"=>rawurldecode($this->path[0])
            ]);
            if($data['id'] && is_readable(JK_DIR_THEMES.$this->theme.DS.$data['module'].'.php')){
                $found_page=JK_DIR_THEMES.$this->theme.DS.$data['module'].'.php';
            }

        }

        if ($found_page) {
            $View->setFile($found_page);
        }else{
            $View->setFile($fileDIR.'404.php');
        }
    }

    protected function removeVariblesOfQueryString($url)
    {
        if ($url != '') {
            $parts = explode("?", $url, 2);
                $url = $parts[0];
        }
        return $url;
    }

    /**
     * @param bool $forceNotRoute
     */
    public function setForceNotRoute($forceNotRoute)
    {
        $this->forceNotRoute = $forceNotRoute;
    }


}