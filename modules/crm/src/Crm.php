<?php

namespace Joonika\Modules\Crm;

use function Joonika\Idate\date_int;
use function Joonika\Modules\Users\groupTitle;
use function Joonika\Modules\Users\groupUsers;

if (!defined('jk')) die('Access Not Allowed !');

class Crm
{
    /**
     * Users constructor.
     */
    public function __construct()
    {
    }

}

function ticketsDepartments()
{
    global $database;
    $back = [];
    $deps = $database->select('crm_tickets_departments', 'id', [
        "status" => "active",
        "ORDER" => ["sort" => "ASC"]
    ]);
    if (sizeof($deps) >= 1) {
        foreach ($deps as $dep) {
            $back[$dep] = langDefineGet(JK_LANG, 'crm_tickets_departments', 'id', $dep);
        }
    }
    return $back;
}

function ticketDepartmentName($depID)
{
    return langDefineGet(JK_LANG, 'crm_tickets_departments', 'id', $depID);
}

function ticketDepartmentFollowers($depID)
{
	global $database;
	$back = [];
	$gets = $database->select('crm_tickets_departments_followers', '*', [
		"AND" => [
			"status" => "active",
			"groupID" => $depID,
		]
	]);
	if (sizeof($gets) >= 1) {
		foreach ($gets as $get) {
			$title = "";
			$hidden = 0;
			if ($get['followerType'] == "user") {
				$title = __("user") . ': ' . nickName($get['followerId']);
			} elseif ($get['followerType'] == "group") {
				$title = __("group") . ': ' . groupTitle($get['followerId']);
			}
			if ($get['hidden'] == 1) {
				$hidden = 1;
			}
			$type = [
				"followerType" => $get['followerType'],
				"followerId" => $get['followerId'],
				"title" => $title,
				"hidden" => $hidden,
			];
			array_push($back, $type);
		}
	}
	return $back;
}

function ticketDepartmentFollowersUsers($depID, $child = 0)
{
	$back0 = [];
	$back1 = [];
	$followers = ticketDepartmentFollowers($depID);
	if (sizeof($followers) >= 1) {
		foreach ($followers as $follower) {
			if ($follower['followerType'] == 'user') {
				if ($follower['hidden'] == 1) {
					array_push($back1, $follower['followerId']);
				} else {
					array_push($back0, $follower['followerId']);
				}
			} elseif ($follower['followerType'] == 'group') {
				$users = groupUsers($follower['followerId'], 0, $child);
				if (sizeof($users) >= 1) {
					foreach ($users as $user) {
						if ($follower['hidden'] == 1) {
							array_push($back1, $user);
						} else {
							array_push($back0, $user);
						}
					}
				}

			}
		}
	}
	return [0 => $back0, 1 => $back1];
}


function ticketDepartmentReporters($depID)
{
	global $database;
	$back = [];
	$gets = $database->select('crm_tickets_departments_reporters', '*', [
		"AND" => [
			"status" => "active",
			"groupID" => $depID,
		]
	]);
	if (sizeof($gets) >= 1) {
		foreach ($gets as $get) {
			$title = "";
			$hidden = 0;
			if ($get['reporterType'] == "user") {
				$title = __("user") . ': ' . nickName($get['reporterId']);
			} elseif ($get['reporterType'] == "group") {
				$title = __("group") . ': ' . groupTitle($get['reporterId']);
			}
			$type = [
				"reporterType" => $get['reporterType'],
				"reporterId" => $get['reporterId'],
				"title" => $title,
			];
			array_push($back, $type);
		}
	}
	return $back;
}
function ticketDepartmentReportersUsers($depID, $child = 0)
{
	$back = [];
	$followers = ticketDepartmentReporters($depID);
	if (sizeof($followers) >= 1) {
		foreach ($followers as $follower) {
			if ($follower['reporterType'] == 'user') {
				array_push($back, $follower['reporterId']);
			} elseif ($follower['reporterType'] == 'group') {
				$users = groupUsers($follower['reporterId'], 0, $child);
				if (sizeof($users) >= 1) {
					foreach ($users as $user) {
						array_push($back, $user);
					}
				}

			}
		}
	}
	return $back;
}
function ticketDepartmentReporterMy($userID="")
{
	global $database;
	global $ACL;
	if($userID==""){
		$userID=JK_LOGINID;
	}
	$depIn=[];
	$deps=$database->select('crm_tickets_departments','id',[
		"status"=>"active"
	]);
	if(sizeof($deps)>=1){
		foreach ($deps as $dep){
			if($ACL->hasPermission("reports_crm_tickets_departments_all")){
				array_push($depIn,$dep);
			}else{
			$thisDepReps=ticketDepartmentReportersUsers($dep);
			if(sizeof($thisDepReps)>=1){
					if(in_array($userID,$thisDepReps)){
						array_push($depIn,$dep);
					}
			}
			}
		}
	}
	return $depIn;
}


function ticketDepartmentChange($ticketID, $departmentID)
{
    global $database;
    $ticket = $database->get("crm_tickets", "*", [
        "id" => $ticketID
    ]);
    if (isset($ticket['id'])) {
        $oldDep = $ticket['department'];
        if ($oldDep != $departmentID) {
            $database->update('crm_tickets', [
                "department" => $departmentID
            ], [
                "id" => $ticketID
            ]);
            ticketLogAdd($ticketID, 'changeDepartment', $departmentID, $oldDep, $departmentID);
        }
    }
}

function ticketDepartmentFollowersAddToTicket($ticketID, $followers, $type = "simple", $hidden = 0)
{
    global $database;
    if ($type == "simple") {
        if (sizeof($followers) >= 1) {
            foreach ($followers as $follower) {
                $has = $database->get("crm_tickets_followers",['id'], [
                    "AND" => [
                        "ticketID" => $ticketID,
                        "userID" => $follower,
                    ]
                ]);
                if (!isset($has['id'])) {
                    $database->insert('crm_tickets_followers', [
                        "ticketID" => $ticketID,
                        "userID" => $follower,
                        "hidden" => $hidden,
                        "joinedDate" => date("Y/m/d H:i:s"),
                    ]);
                }else{
                    $database->update('crm_tickets_followers', [
                        "status" => "active",
                    ],[
                        "id"=>$has['id']
                    ]);
                }
                ticketLogAdd($ticketID, 'addFollower', $follower);
            }
        }
    } elseif ($type == "complex") {
        if (sizeof($followers) >= 1) {
            if (sizeof($followers[0]) >= 1) {
                foreach ($followers[0] as $follower) {
                    $has = $database->has("crm_tickets_followers", [
                        "AND" => [
                            "ticketID" => $ticketID,
                            "userID" => $follower,
                        ]
                    ]);
                    if (!$has) {
                        $database->insert('crm_tickets_followers', [
                            "ticketID" => $ticketID,
                            "userID" => $follower,
                            "hidden" => 0,
                            "joinedDate" => date("Y/m/d H:i:s"),
                        ]);
                    }
                }
            }
            if (sizeof($followers[1]) >= 1) {
                foreach ($followers[1] as $follower) {
                    $has = $database->has("crm_tickets_followers", [
                        "AND" => [
                            "ticketID" => $ticketID,
                            "userID" => $follower,
                        ]
                    ]);
                    if (!$has) {
                        $database->insert('crm_tickets_followers', [
                            "ticketID" => $ticketID,
                            "userID" => $follower,
                            "hidden" => 0,
                            "joinedDate" => date("Y/m/d H:i:s"),
                        ]);
                    }
                }
            }
        }
    }
}

function ticketParentSubjects()
{
    global $database;
    $back = [];
    $datas = $database->select('crm_tickets_parent_subjects', 'id', [
        "status" => "active"
    ]);
    if (sizeof($datas) >= 1) {
        foreach ($datas as $data) {
            $back[$data] = langDefineGet(JK_LANG, 'crm_tickets_parent_subjects', 'id', $data);
        }
    }
    return $back;
}

function ticketSubjects($parent = null, $parentTitleAdd = false)
{
    global $database;
    $back = [];
    if ($parent == null) {
        $datas = $database->select('crm_tickets_subjects', ['id', 'module'], [
            "status" => "active",
        ]);
    } else {
        $datas = $database->select('crm_tickets_subjects', ['id', 'module'], [
            "AND" => [
                "status" => "active",
                "module" => $parent,
            ]
        ]);
    }
    if (sizeof($datas) >= 1) {
        foreach ($datas as $data) {
            $back[$data['id']] = '';
            if ($parentTitleAdd) {
                $back[$data['id']] .= ticketsParentSubjectTitle($data['module']) . ' - ';
            }
            $back[$data['id']] .= langDefineGet(JK_LANG, 'crm_tickets_subjects', 'id', $data['id']);
        }
    }
    return $back;
}

function ticketsGetParentSubject($subjectID)
{
    global $database;
    $parent = $database->get('crm_tickets_subjects', 'module', [
        "id" => $subjectID,
    ]);
    return $parent;
}

function ticketsSubjectTitle($subjectID)
{
    return langDefineGet(JK_LANG, 'crm_tickets_subjects', 'id', $subjectID);
}

function ticketsParentSubjectTitle($subjectID)
{
    return langDefineGet(JK_LANG, 'crm_tickets_parent_subjects', 'id', $subjectID);
}

function ticketLogAdd($ticketID, $type, $typeID = null, $from = null, $to = null, $datetime = null, $userID = null, $userType = null, $description = null)
{
    global $database;
    if ($datetime == null) {
        $datetime = date("Y/m/d H:i:s");
    }
    if ($userType == null) {
        $userType = "jk_users";
    }
    if ($userID == null) {
        $userID = JK_LOGINID;
    }
    $database->insert('crm_tickets_logs', [
        "ticketID" => $ticketID,
        "type" => $type,
        "typeID" => $typeID,
        "from" => $from,
        "to" => $to,
        "datetime" => $datetime,
        "description" => $description,
        "userType" => $userType,
        "userID" => $userID,
    ]);
    \Joonika\Modules\Crm\ticketFollowerUnReadAll($ticketID);
}

function ticketChangeStatus($ticketID, $newStatus, $datetime = null, $userID = null, $userType = null, $description = null)
{
    global $database;
    if ($datetime == null) {
        $datetime = date("Y/m/d H:i:s");
    }
    $ticket = $database->get('crm_tickets', '*', [
        "id" => $ticketID
    ]);

    if (isset($ticket['id'])) {
        $oldStatus = $ticket['status'];
        if ($newStatus != $oldStatus) {
            $ticket = $database->update('crm_tickets', [
                "status" => $newStatus
            ], [
                "id" => $ticketID
            ]);
            ticketLogAdd($ticketID, "changeStatus", $newStatus, $oldStatus, $newStatus, $datetime, $userID, $userType, $description);
        }
    }
}

function ticketOwn($ticketID, $userID = null, $datetime = null, $userType = null, $description = null)
{
    global $database;
    if ($datetime == null) {
        $datetime = date("Y/m/d H:i:s");
    }
    $ticket = $database->get('crm_tickets', '*', [
        "id" => $ticketID
    ]);
    if (isset($ticket['id'])) {
        $oldOwner = $ticket['owner'];
        $database->update('crm_tickets', [
            "owner" => $userID
        ], [
            "id" => $ticketID
        ]);
        if ($userID == null) {
            $type = "removeOwn";
        } else {
            $type = "owner";
        }
        ticketLogAdd($ticketID, $type, $userID, $oldOwner, $userID, $datetime, $userID, $userType, $description);
    }
}

function ticketNoteAdd($ticketID, $type = "note", $note = null, $datetime = null, $log = true)
{
    global $database;
    $noteID = null;
    if ($datetime == null) {
        $datetime = date("Y/m/d H:i:s");
    }
    $ticket = $database->get('crm_tickets', ['id'], [
        "id" => $ticketID
    ]);
    if (isset($ticket['id'])) {
        $database->insert('crm_tickets_notes', [
            "ticketID" => $ticketID,
            "type" => $type,
            "userID" => JK_LOGINID,
            "note" => $note,
            "datetime" => $datetime,
        ]);
        $noteID = $database->id();
        if ($log) {
            ticketLogAdd($ticketID, "addNote", $noteID, null, $note, $datetime);
        }
    }
    return $noteID;
}

function ticketNoteAttachAdd($ticketID, $noteID, $filesID, $datetime = null, $log = false)
{
    global $database;
    if ($datetime == null) {
        $datetime = date("Y/m/d H:i:s");
    }
    $ticket = $database->get('crm_tickets', ['id'], [
        "id" => $ticketID
    ]);
    if (isset($ticket['id'])) {
        $files = [];
        if ($filesID != "") {
            $explodes = explode(',', $filesID);
            if (sizeof($explodes) >= 1) {
                foreach ($explodes as $explode) {
                    array_push($files, $explode);
                }
            }
        }
        if (sizeof($files) >= 1) {
            foreach ($files as $file) {
                $database->insert('crm_tickets_attachments', [
                    "ticketID" => $ticketID,
                    "noteID" => $noteID,
                    "userID" => JK_LOGINID,
                    "fileID" => $file,
                    "datetime" => $datetime,
                    "hash" => md5(time()),
                ]);
                $fileDB = $database->id();
                if ($log) {
                    ticketLogAdd($ticketID, "addAttach", $noteID, null, $fileDB, $datetime);
                }
            }

        }


    }
}

function ticketHistoryShow($historyID)
{
    global $database;
    $history = $database->get('crm_tickets_logs', '*', [
        "id" => $historyID
    ]);
    $txt = "";
    if (isset($history['id'])) {
        switch ($history['type']) {
            case "openTicket":
                $txt = __("open ticket by") . ' ' . '<span class="text-info">' . nickName($history['userID']) . '</span>';
                break;
            case "addNote":
                $txt = __("add note by") . ' ' . '<span class="text-info">' . nickName($history['userID']) . '</span>';
                break;
            case "changeStatus":
                $txt = '<span class="text-info">' . nickName($history['userID']) . '</span> ' . __("change ticket status from") . ' ' . ticketStatus($history['from'], true) . ' ' . __("to") . ' ' . ticketStatus($history['to'], true);
                if ($history['description'] != "") {
                    if ($history['description'] == "confirmed") {
                        $txt .= ' <span class="badge badge-pill badge-success">' . __("confirmed") . '</span>';
                    } elseif ($history['description'] == "disapproval") {
                        $txt .= ' <span class="badge badge-pill badge-danger">' . __("disapproval") . '</span>';
                    } else {
                        $txt .= ' <span class="badge badge-pill badge-info">' . __($history['description']) . '</span>';
                    }
                }
                break;
                case "changeDepartment":
                    if($history['from']==null){
                        $history['from']="-";
                    }
                $txt = '<span class="text-info">' . nickName($history['userID']) . '</span> ' . __("change ticket department from") . ' ' . ticketDepartmentName($history['from']) . ' ' . __("to") . ' ' . ticketDepartmentName($history['to']);
                break;
            case "addFollower":
                $txt = '<span class="text-info">' . nickName($history['userID']) . '</span> ' . __("add follower") . ' ' . nickName($history['typeID']);
                break;
            case "owner":
                if ($history['from'] == null) {
                    $txt = '<span class="text-info">' . nickName($history['userID']) . '</span> ' . __("accepted review");
                } else {
                    $txt = '<span class="text-info">' . nickName($history['userID']) . '</span> ' . __("forward ticket from") . ' ' . nickName($history['from']) . ' ' . __("to") . ' ' . nickName($history['to']);
                }
                break;
            case "removeOwn":
                if($history['from']==null){
                    $history['from']="-";
                }else{
                    $history['from']=nickName($history['from']);
                }
                if($history['to']==null){
                    $history['to']="-";
                }else{
                    $history['to']=nickName($history['to']);
                }
                    $txt = '<span class="text-info">' . nickName($history['userID']) . '</span> ' . __("change owner from") . ' ' . $history['from'] . ' ' . __("to") . ' ' . $history['to'];
                break;
            default:
                $txt = $history['type'] . '-';
                break;
        }
        $txt .= ' <span class="ltr">' . date_int("Y/m/d " . __("hour") . " H:i:s", $history['datetime']) . '</span>';
    }
    return $txt;
}

function ticketStatus($status, $color = false)
{
    $back = __("unknown");
    $tickets = [
        "new" => [
            "color" => "#FA8072",
            "title" => __("new")
        ], "open" => [
            "color" => "#191970",
            "title" => __("open")
        ], "hold" => [
            "color" => "#5F9EA0",
            "title" => __("hold")
        ], "confirm" => [
            "color" => "#FF6347",
            "title" => __("waiting for confirm")
        ], "closed" => [
            "color" => "#A9A9A9",
            "title" => __("closed")
        ]
    ];
    if (isset($tickets[$status])) {
        if ($color) {
            $back = '<span class="badge badge-info" style="background-color:' . $tickets[$status]['color'] . '">' . $tickets[$status]['title'] . '</span>';
        } else {
            $back = $tickets[$status]['title'];
        }
    }
    return $back;
}

function ticketPriority($priority, $color = false)
{
    $back = __("unknown");
    $priorities = [
        "low" => [
            "color" => "#fddf64",
            "title" => __("low")
        ], "medium" => [
            "color" => "#9370DB",
            "title" => __("medium")
        ], "high" => [
            "color" => "#00008B",
            "title" => __("high")
        ], "urgent" => [
            "color" => "#FF0000",
            "title" => __("urgent")
        ]
    ];
    if (isset($priorities[$priority])) {
        if ($color) {
            $back = '<span style="color:' . $priorities[$priority]['color'] . '">' . $priorities[$priority]['title'] . '</span>';
        } else {
            $back = $priorities[$priority]['title'];
        }
    }
    return $back;
}

function ticketFollowerChange($followerID, $type = "read")
{
    global $database;
    if ($type == "read") {
        $database->update('crm_tickets_followers', [
            "read" => 1
        ], [
            "id" => $followerID
        ]);
    } elseif ($type == 'unreadOther') {
        $getTicket = $database->get('crm_tickets_followers', 'ticketID', [
            "id" => $followerID
        ]);
        $database->update('crm_tickets_followers', [
            "read" => 2
        ], [
            "AND" => [
                "ticketID" => $getTicket,
                "read" => 1,
                "id[!]" => $followerID,
            ]
        ]);
    }
}

function ticketFollowerReadFind($ticketID, $userID = null)
{
    if ($userID == null) {
        $userID = JK_LOGINID;
    }
    global $database;
    $followerID = $database->get('crm_tickets_followers', ['id'], [
        "AND" => [
            "ticketID" => $ticketID,
            "userID" => $userID,
        ]
    ]);
    if (isset($followerID['id'])) {
        ticketFollowerChange($followerID['id'], 'read');
    }
}

function ticketFollowerUnReadAll($ticketID, $userID = null)
{
    if ($userID == null) {
        $userID = JK_LOGINID;
    }
    global $database;
    $followerID = $database->get('crm_tickets_followers', ['id'], [
        "AND" => [
            "ticketID" => $ticketID,
            "userID" => $userID,
        ]
    ]);
    if (isset($followerID['id'])) {
        ticketFollowerChange($followerID['id'], 'unreadOther');
    }
}

function ticketsConfirmationsList()
{
    global $database;
    $cs = $database->select('jk_users_confirms', 'id', [
        "status" => "active"
    ]);
    $back = [];
    if (sizeof($cs) >= 1) {
        foreach ($cs as $c) {
            $back[$c] = langDefineGet(JK_LANG, 'jk_users_confirms', 'id', $c);
        }
    }
    return $back;
}

function ticketAddOrigin($ticketID, $origin, $originValue)
{
    global $database;
    $has = $database->has("crm_tickets_origins", [
        "AND" => [
            "ticketID" => $ticketID,
            "origin" => $origin,
            "originValue" => $originValue,
        ]
    ]);
    if (!$has) {
        $database->insert('crm_tickets_origins', [
            "ticketID" => $ticketID,
            "origin" => $origin,
            "originValue" => $originValue,
        ]);
        $originDBID = $database->id();
        ticketLogAdd($ticketID, 'addOrigin', $originDBID, $origin, $originValue, null, JK_LOGINID, null, null);
    }
}

function ticketOrigins($ticketID)
{
    global $database;
    $back = [];
    $origins = $database->select('crm_tickets_origins', '*', [
        "AND" => [
            "ticketID" => $ticketID,
            "status" => "active",
        ]
    ]);
    if (sizeof($origins) >= 1) {
        foreach ($origins as $or) {
            $back[$or['id']] = [
                "name"=>$or['origin'],
                "value"=>$or['originValue']
            ];
        }
    }
    return $back;
}
function ticketOriginsTitle()
{
    global $database;
    $origins = $database->select('crm_tickets_origins_title', 'name', [
            "status" => "active",
    ]);
    $origins=arrayToKey($origins);
    return $origins;
}
function noteData($noteID,$col="*"){
    global $database;
    return $database->get('crm_tickets_notes',$col,[
        "id"=>$noteID
    ]);
}