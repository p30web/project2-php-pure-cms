<?php

namespace Joonika\Modules\Users;

use function Joonika\Upload\getfile;

if (!defined('jk')) die('Access Not Allowed !');

class Users
{
    public $loggedID = 0;
    public $registrationAvailable = true;
    private $is_logged = false;
    private $UserVar = [];

    /**
     * Users constructor.
     */
    public function __construct()
    {
        if (isset($_SESSION[JK_DOMAIN_WOP]['userID'])) {

            global $database;
            $this->is_logged = true;
            $this->loggedID = $_SESSION[JK_DOMAIN_WOP]['userID'];
            $this->UserVar = $database->get('jk_users', '*', [
                "ID" => $_SESSION[JK_DOMAIN_WOP]['userID']
            ]);
        }
        elseif(isset($_COOKIE['loginCredentials'])){
                global $database;
                $databaseCheck=$database->get('jk_users_login_cookies','*',[
                   "AND"=>[
                           "cookie"=>$_COOKIE['loginCredentials'],
                           "status"=>"active",
                           "expireOn[>=]"=>date("Y/m/d H:i:s"),
                   ]
                ]);
                if(isset($databaseCheck['id'])){
                    $_SESSION[JK_DOMAIN_WOP]['userID']=$databaseCheck['userID'];
                    $this->is_logged = true;
                    $this->loggedID = $databaseCheck['userID'];
                    $this->UserVar = $database->get('jk_users', '*', [
                        "id" => $databaseCheck['userID']
                    ]);
                    $database->update('jk_users_login_cookies',[
                            "status"=>"expire",
                    ],[
                            "id[!]"=>$databaseCheck['id'],
                            "userID"=>$databaseCheck['userID'],
                    ]);
                }

        }
    }

    public function user($var)
    {
        if (isset($this->UserVar[$var])) {
            return $this->UserVar[$var];
        }
        return false;
    }

    public function loggedCheck()
    {
        global $View;
        global $Route;
        if (!$this->isLogged()) {
            if ($View->login_page == "") {
                $url = JK_DOMAIN_LANG;
            } else {
                $url = $View->login_page;
            }
            redirect_to($url . '?return=' . $Route->url);
        }
    }

    public function logOutUser()
    {
        global $database;
        $_SESSION = [];
        session_destroy();
        session_unset();
        $database->update("jk_users_login_cookies",[
                "status"=>"expire",
        ],[
                "userID"=>$this->UserVar
        ]);
    }

    public function isLogged()
    {
        return $this->is_logged;
    }

    function loginCheck($options = [])
    {
        global $database;
        $return = [
            "status" => false,
            "message" => __("username or password incorrect")
        ];
        if (isset($options['username']) && isset($options['password'])) {

            $logu = $database->get('jk_users', ['id', 'password', 'status'], [
                "OR" => [
                    "username" => $options['username'],
                    "email" => $options['username'],
                ]
            ]);
            if (isset($logu['id'])) {
                if ($logu['status'] == 'active') {


                    if (password_verify($options['password'], $logu['password'])) {
                        //session_login($logu['ID']);
                        $return = [
                            "status" => true,
                            "message" => __("login successfully"),
                            "id" => $logu['id']
                        ];
                    }
//                    else {
//
//                        try {
//                            $ldap_columns = NULL;
//                            $ldap_connection = NULL;
//                            $ldap_password = $options['password'];
//                            $ldap_username = $options['username'];
//
//                            $ldap_connection = \ldap_connect("185.153.185.242");
//
//                            if (FALSE === $ldap_connection) {
//                                $return = [
//                                    "status" => true,
//                                    "message" => __("Failed to connect to the LDAP server") . "185.153.185.242",
//                                    "id" => $logu['id']
//                                ];
//                            } else {
//                                \ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
//                                \ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0); // We need this for doing an LDAP search.
//
//                                if (TRUE !== \ldap_bind($ldap_connection, $ldap_username, $ldap_password)) {
//                                    $return = [
//                                        "status" => true,
//                                        "message" => __("Failed to bind to LDAP server") . "185.153.185.242",
//                                        "id" => $logu['id']
//                                    ];
//                                }
//                            }
//
//
//                        } catch (\Exception $e) {
//                            $return = [
//                                "status" => false,
//                                "message" => $e->getMessage()
//                            ];
//
//                        }
//                    }

                } else {
                    $return = [
                        "status" => false,
                        "message" => __("username not active")
                    ];
                }
            }
        }
        return $return;
    }

    function logUser($userID)
    {
        global $database;
        $_SESSION[JK_DOMAIN_WOP]['userID'] = $userID;
        $cookie = md5(time() . $userID);
        $timeExpire=time()+86400;
        $database->insert('jk_users_login_cookies', [
            "userID"=>$userID,
            "cookie"=>$cookie,
            "expireOn"=>date("Y/m/d H:i:s",$timeExpire),
        ]);
        setcookie("loginCredentials", $cookie, $timeExpire);
    }


}

function roleTitle($roleID)
{
    return langDefineGet(JK_LANG, 'jk_roles', 'id', $roleID);
}

function groupTitle($groupID)
{
    return langDefineGet(JK_LANG, 'jk_groups', 'id', $groupID);
}

function groupsCheckboxParentHTML($sub = 0, $child = 0)
{
    global $database;

    $navs = $database->select('jk_groups', '*', [
        "AND" => [
            "parent" => $sub,
            "status" => "active",
        ],
        "ORDER" => ["parent" => "ASC", "sort" => "ASC"]
    ]);

    $soo = sizeof($navs);
    if ($soo >= 1) {
        ?>
    <ul class="dd-list dd-list-<?php echo JK_DIRECTION ?>">
        <?php
        foreach ($navs as $nav) {
            ?>
            <li class="dd-item dd3-item" data-id="<?php echo $nav['id'] ?>">
                <div class="dd3-content">
                    <input type="checkbox" name="groups[]" id="group_<?php echo $nav['id'] ?>"
                           value="<?php echo $nav['id']; ?>">
                    <label for="group_<?php echo $nav['id'] ?>"
                           class="no-padding no-margin"><?php echo groupTitle($nav['id']) ?></label>
                </div>
                <?php

                groupsCheckboxParentHTML($nav['id'], $child++);

                ?>
            </li>
            <?php

        }
        ?></ul><?php

    }
}

function groupsSubGroups($parent, &$groups = [])
{
    global $database;
    $groupins = $database->select('jk_groups', '*', [
            "parent" => $parent,
            "ORDER" => ['sort' => 'ASC']
        ]
    );
    if (sizeof($groupins) >= 1) {
        foreach ($groupins as $group) {
            $groups[$group['id']] = $group['id'];
            groupsSubGroups($group['id'], $groups);
        }
    }
    return $groups;
}

function groupsParentGroups($groupid, &$parentgroups = [])
{
    global $database;
    $groupins = $database->get('jk_groups', ['parent'], [
            "id" => $groupid,
        ]
    );
    if (isset($groupins['parent']) && $groupins['parent'] != 0) {
        array_push($parentgroups, $groupins['parent']);
        groupsParentGroups($groupins['parent'], $parentgroups);
    }

    return $parentgroups;
}

function usersRoleGroups($userID = 0)
{
    global $database;
    $getroles = $database->select('jk_users_groups_rel', '*', [
        "AND" => [
            "userID" => $userID,
            "status" => "active"
        ]
    ]);
    $roles = [];
    if (sizeof($getroles) >= 1) {
        foreach ($getroles as $getrole) {
            $roles[] = ["id" => $getrole['id'], "role" => $getrole['roleID'], "group" => $getrole['groupID']];
        }
    }
    return $roles;
}

function usersRoleGroupsHTML($userID = 0)
{
    $roles = '';
    $rolesgroups = usersRoleGroups($userID);
    if (sizeof($rolesgroups) >= 1) {
        foreach ($rolesgroups as $rolesgroup) {
            $roles .= roleTitle($rolesgroup['role']) . ' ' . groupTitle($rolesgroup['group']) . ' - ';
        }
        $roles = rtrim($roles, ' - ');
    }
    if ($roles == "") {
        $roles = "-";
    }
    return $roles;
}

function groupsSubGroupsArray($groups, $parent = 0, $level = '', $withjoin = 0)
{
    global $database;
    global $groups;
    if ($withjoin == 1 && !isset($groups[$parent])) {
        $groups[$parent] = $parent;
    }

    $groupins = $database->select('jk_groups', '*', [
            "AND" => [
                "parent" => $parent,
                "status" => 'active'
            ],
            "ORDER" => ['sort' => 'ASC']
        ]
    );
    if (sizeof($groupins) >= 1) {
        foreach ($groupins as $group) {
            $groups[$group['id']] = $level . groupTitle($group['id']);
            $level2 = $level . groupTitle($group['id']) . '->';
            groupsSubGroupsArray($groups, $group['id'], $level2, $withjoin);
        }
    }
    return $groups;
}

function rolesArray()
{
    global $database;
    $array = [];
    $rolesins = $database->select('jk_roles', '*', [
            "status" => "active",
            "ORDER" => ['sort' => 'ASC']
        ]
    );
    if (sizeof($rolesins) >= 1) {
        foreach ($rolesins as $rolesin) {
            $array[$rolesin['id']] = roleTitle($rolesin['id']);
        }
    }
    return $array;
}

function displacementTypesArray()
{
    global $database;
    $array = [];
    $dtps = $database->select('jk_users_displacements_types', '*', [
            "status" => "active",
            "ORDER" => ['sort' => 'ASC']
        ]
    );
    if (sizeof($dtps) >= 1) {
        foreach ($dtps as $dtp) {
            $array[$dtp['id']] = displacementTitle($dtp['id']);
        }
    }
    return $array;
}

function displacementTitle($roleID)
{
    return langDefineGet(JK_LANG, 'jk_users_displacements_types', 'id', $roleID);
}

function displacementInfo($id)
{
    global $database;
    return $database->get('jk_users_displacements_types', '*', [
        "id" => $id
    ]);
}

function displacementSubmitRoleGroup($displacementID, $userID, $roleID, $groupID, $datetime)
{
    global $database;
    $dis = $database->get('jk_users_displacements_types', '*', [
        "id" => $displacementID
    ]);
    if ($dis['inactiveOldValue'] == "1") {
        $database->update('jk_users_groups_rel', [
            "status" => "inactive"
        ], [
            "userID" => $userID
        ]);
    }
    if ($dis['statusType'] == "0") {
        $database->update('jk_users', [
            "status" => "inactive"
        ], [
            "userID" => $userID
        ]);
    }

    if ($dis['extraRoleGroup'] == "1") {
        $main = 0;
    } else {
        $main = 1;
    }
    $database->insert('jk_users_groups_rel', [
        "userID" => $userID,
        "groupID" => $groupID,
        "roleID" => $roleID,
        "main" => $main,
    ]);

    $database->insert('jk_users_displacements', [
        "userID" => $userID,
        "displacementTypeID" => $displacementID,
        "roleID" => $roleID,
        "groupID" => $groupID,
        "datetime" => $datetime,
        "datetime_s" => date("Y/m/d H:i:s"),
        "creatorID" => JK_LOGINID,
    ]);


}

function userStatus($userID)
{
    global $database;
    $us = $database->get('jk_users', 'status', [
        "id" => $userID
    ]);
    if ($us == 'active') {
        return true;
    } else {
        return false;
    }
}

function sexTitleUser($userid)
{
    global $database;
    $getsex = $database->get('jk_users', 'sex', [
        "id" => $userid
    ]);
    return sexTitle($getsex);
}

function sexTitle($sex)
{
    if ($sex == 'male') {
        $back = __("Mr.");
    } elseif ($sex == "female") {
        $back = __("Ms.");
    } else {
        $back = __("unknown");
    }
    return $back;
}

function profileImage($userID, $type = "original")
{
    global $database;
    $image = $database->get("jk_users", "profileImage", [
        "id" => $userID
    ]);
    if ($image && $image != "") {
        return '/' . getfile($image, false, $type);
    } else {
        return '/files/general/default-avatar-128.png';
    }
}

function usersArray($type = "active")
{
    global $database;
    if ($type != "all") {
        $users = $database->select("jk_users", "id", [
            "status" => "active"
        ]);
    } else {
        $users = $database->select("jk_users", "id", [
        ]);
    }
    $array = [];
    if (sizeof($users) >= 1) {
        foreach ($users as $user) {
            $array[$user] = nickName($user);
        }
    }
    return $array;

}

function groupUsers($groupID, $roleID = 0, $child = 0)
{
    global $database;

    $back = [];
    $groupsIn = [];
    if ($child == 0) {
        $groupsIn = $groupID;
    } else {

        $groups = groupsSubGroupsArray([], $groupID);
        if (sizeof($groups) >= 1) {
            foreach ($groups as $groupsInKey => $groupsInVal) {
                array_push($groupsIn, $groupsInKey);
            }
        }
    }
    if ($roleID == 0) {
        $getUsers = $database->select('jk_users_groups_rel', 'userID', [
            "AND" => [
                "groupID" => $groupsIn,
                "status" => "active"
            ]
        ]);
    } else {
        $getUsers = $database->select('jk_users_groups_rel', 'userID', [
            "AND" => [
                "groupID" => $groupsIn,
                "roleID" => $roleID,
                "status" => "active"
            ]
        ]);
    }
    if (sizeof($getUsers) >= 1) {
        foreach ($getUsers as $user) {
            array_push($back, $user);
        }
    }
    return $back;
}

function confirmationTitle($id)
{
    global $database;
    return langDefineGet(JK_LANG, 'jk_users_confirms', 'id', $id);
}