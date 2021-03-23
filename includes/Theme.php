<?php namespace Joonika;
if(!defined('jk')) die('Access Not Allowed !');

class Theme
{
    public $siteTitle="";
    public $siteDescription="";
    public $siteKeywords=[];
    public $option=[];

    /**
     * Theme constructor.
     */
    public function __construct()
    {
        global $database;
        $set=$database->get('jk_languages','*',[
            "websiteID"=>JK_WEBSITE_ID,
            "slug"=>JK_LANG,
        ]);
        if(isset($set['id'])){
            $this->siteTitle=$set['siteTitle'];
            $this->siteDescription=$set['siteDescription'];
            $this->siteKeywords=$set['siteKeywords'];
        }
    }


}