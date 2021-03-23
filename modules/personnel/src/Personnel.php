<?php

namespace Joonika\Modules\Personnel;
if (!defined('jk')) die('Access Not Allowed !');

class Personnel
{
    private $is_logged = false;
    public $loggedID = 0;
    private $UserVar = [];
    public $registrationAvailable = true;

    /**
     * Users constructor.
     */
    public function __construct()
    {

    }

}
function personnelDetails($userID){
    global $database;
    if(is_numeric($userID) && $userID>=1){
        $get=$database->get('personnel_details','*',[
            "userID"=>$userID
        ]);
        if(isset($get['id'])){
            return $get;
        }else{
            $database->insert('personnel_details',[
                "userID"=>$userID,
            ]);
            $get=$database->get('personnel_details','*',[
                "id"=>$database->id()
            ]);
            return $get;
        }
    }else{
        return false;
    }
}
function maritalStatus($statusCode){
    if($statusCode==0){
        return __("single");
    }else{
        return __("married");
    }
}
function militaryStatus($statusCode){
    $arr=[
        "undone"=>__("undone"),
        "done"=>__("done"),
        "exempt"=>__("exempt"),
    ];
    if(isset($arr[$statusCode])){
        return $arr[$statusCode];
    }else{
        return __("unknown");
    }
}
function personnelCardSimple($userid,$class="col-12 col-md-4",$link=false){
    if($link==true){
        $link_open=JK_DOMAIN_LANG.'cp/personnel/profile/'.$userid;
    }else{
        $link_open='javascript:;';
    }
    ?>
    <a href="<?php echo $link_open; ?>" class="<?php echo $class; ?> card-profile">
        <div class="card card-body">
            <div class="media">
                <div class="media-body">
                    <div class="media-title font-weight-semibold"><?php echo nickName($userid); ?></div>
                    <span class="text-muted group-details"><?php echo \Joonika\Modules\Users\usersRoleGroupsHTML($userid) ?></span>
                </div>

                <div class="ml-3">
                        <img src="<?php echo \Joonika\Modules\Users\profileImage($userid) ?>" class="rounded-circle" width="42" height="42" alt="">
                </div>
            </div>
        </div>
    </a>
<?php
}
function fieldTitle($fieldID){
    return langDefineGet(JK_LANG,'personnel_fields','id',$fieldID);
}
function gradeTitle($grade){
    switch ($grade) {
        case "d1":
            $grade = __("Diploma");;
            break;
        case "d":
            $grade = __("PHD");
            break;
        case "m":
            $grade = __("Master's Degree");;
            break;
        case "b":
            $grade = __("Bachelor's degree");;
            break;
        case "a":
            $grade = __("Associate Degree");;
            break;
        default:
            $grade = __("unknown");
    }
    return $grade;
}
function educationStatus($status){
    switch ($status) {
        case "collegian":
            $grade = __("collegian");;
            break;
        case "graduate":
            $grade = __("graduate");
            break;
            default:
            $grade = __("unknown");
    }
    return $grade;
}
function skillType($status){
    switch ($status) {
        case "arts":
            $grade = __("Artistic");;
            break;
        case "sports":
            $grade = __("Sports");
            break;
        case "skillful":
            $grade = __("Skillful");
            break;
        case "org":
            $grade = __("Organizational");
            break;
            default:
            $grade = __("unknown");
    }
    return $grade;
}
function languageSkill($number){
    switch ($number) {
        case "1":
            $grade = __("basics");;
            break;
        case "3":
            $grade = __("intermediate");
            break;
        case "5":
            $grade = __("professional");
            break;
        default:
            $grade = __("unknown");
    }
    return $grade;
}
function timeManagementTypeStatus($id){
    global $database;
    return $database->get('personnel_time_management_types','type',[
          "id"=>$id
    ]);
}
