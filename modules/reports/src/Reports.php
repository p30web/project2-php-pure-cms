<?php

namespace Joonika\Modules\Reports;

if (!defined('jk')) die('Access Not Allowed !');

class Reports
{
    /**
     * Users constructor.
     */
    public function __construct()
    {
    }

	public function panel_data_simple($type="div",$function="",$col="col-md-3 col-12",$title="title",$value="0",$options=[]){
		$option=[
			"bg"=>"info",
			"bg-color"=>"",
			"text-color"=>"",
			"icon"=>"fa fa-wallet",
		];

		foreach ($option as $opK=>$opV){
			if(isset($options[$opK])){
				$option[$opK]=$options[$opK];
			}
		}

		if($option['bg-color']=="" || $option['text-color']==""){
			$classColor="bg-".$option['bg'];
			$style="";
		}else{
			$classColor="";
			$style="background-color:".$option['bg-color'].";color:".$option['text-color'].'!important;';
		}

		$start='';
		$end='';
		if($type=="div"){
			$start='<div class="'.$col.'" onclick="'.$function.'">';
			$end='</div>';
		}elseif($type=="a"){
			$start='<a class="'.$col.'" href="'.$function.'">';
			$end='</a>';
		}
		echo $start;
		?>
        <div class="card text-white <?php echo $classColor; ?> mb-3 report-card has-bg-image" style="<?php echo $style; ?>">
            <div class="card-body">
                <div style="margin-top: -20px;position: absolute;<?php echo JK_DIRECTION_SIDE_R ?>: 10px"><i class="<?php echo $option['icon'] ?> text-light fa-3x"></i></div>
                <h5 class="card-title"><?php echo $title; ?></h5>
                <h3 class="card-text text-center counter"><?php echo $value; ?></h3>
            </div>
        </div>
		<?php
		echo $end;
	}

	public function panel_data_complex($type="div",$function="",$col="col-md-3 col-12",$title="title",$values=[],$options=[]){
		$option=[
			"bg"=>"info",
			"bg-color"=>"",
			"text-color"=>"",
			"icon"=>"fa fa-wallet",
		];

		foreach ($option as $opK=>$opV){
			if(isset($options[$opK])){
				$option[$opK]=$options[$opK];
			}
		}

		if($option['bg-color']==""){
			$classColor="bg-".$option['bg'];
			$style="";
		}else{
			$classColor="";
			$style="background-color:".$option['bg-color'];
		}
		if($option['text-color']!=""){
			$style.=";color:".$option['text-color'].'!important;';
		}

		$start='';
		$end='';
		if($type=="div"){
			$start='<div class="'.$col.'" onclick="'.$function.'">';
			$end='</div>';
		}elseif($type=="a"){
			$start='<a class="'.$col.'" href="'.$function.'">';
			$end='</a>';
		}
		$htmlin='';
		if(sizeof($values)>=1){
		    foreach ($values as $val){
			    $htmlin.='<div class="col-12 col-md-'.$val['col'].'">'.$val['title'].'<h3 class="mb-0 counter">'.$val['value'].'</h3></div>';
            }
        }
		echo $start;
		?>
        <div class="card text-white <?php echo $classColor; ?> mb-3 report-card has-bg-image" style="<?php echo $style; ?>">
            <div class="card-body">
                <div style="margin-top: -20px;position: absolute;<?php echo JK_DIRECTION_SIDE_R ?>: 10px"><i class="<?php echo $option['icon'] ?> text-light fa-3x"></i></div>
                <h5 class="card-title"><?php echo $title; ?></h5>
                <div class="card-text text-center"><div class="container"><div class="row"><?php echo $htmlin; ?></div></div></div>
            </div>
        </div>
		<?php
		echo $end;
	}

}

