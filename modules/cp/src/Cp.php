<?php
namespace Joonika\Modules\Cp;
if(!defined('jk')) die('Access Not Allowed !');


class Cp {
    public $configs=[];
    private $sidebar=[];
    private $sidebarActive="";
    public $sidebarCollapsed=false;
    public $topHeader=true;
    public $activities=[];
    public $messages=[];
    public $sheets=[];
    public $topIconsUsers=[];
    /**
     * Users constructor.
     */
    public function __construct()
    {


    }
    public function addSidebar($sidebar){
        array_push($this->sidebar,$sidebar);
    }

    public function sidebar(){
        $foundedModules=[];
        $scanned_directory = array_diff(scandir(JK_DIR_MODULES), array('..', '.'));
        if(sizeof($scanned_directory)>=1){
            foreach ($scanned_directory as $elem){
                if(is_dir(JK_DIR_MODULES.$elem)){
                    array_push($foundedModules,$elem);
                }
            }
        }
        foreach ($foundedModules as $foundedModule){
            if(is_readable(JK_DIR_MODULES.$foundedModule.DS.'config.php')){
                include (JK_DIR_MODULES.$foundedModule.DS.'config.php');
            }
        }
        return $this->sidebar;
    }

    /**
     * @return string
     */
    public function getSidebarActive()
    {
        return $this->sidebarActive;
    }

    /**
     * @param string $sidebarActive
     */
    public function setSidebarActive($sidebarActive)
    {
        $this->sidebarActive = $sidebarActive;
    }


}