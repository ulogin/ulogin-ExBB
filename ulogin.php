<?php

define('IN_EXBB', TRUE);
include('./include/common.php');

$fm->_GetVars();
$fm->_String('action', 'agreement');
$fm->_LoadLang('register');

if ($fm->user['id'] !== 0) {
    header("Location: index.php");
    exit();
}

$sesid = _SESSION_ID;

if ($_POST && isset($_POST['token']))
{

    $allusers = $fm->_Read2Write($fp_allusers,FM_USERS);

    $data = json_decode(file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']),true);

    $data['first_name'] = iconv('utf8','windows-1251',$data['first_name']);
    $data['last_name'] = iconv('utf8','windows-1251',$data['last_name']);

    $oname = $data['first_name'].'_'.$data['last_name'];
    $name = gen_user_name($oname);

    if ($user = find_user($oname,$data['identity']))
    {
        loginUser($user);
    }

    $password = md5(rand(1000000000,10000000000));

    $user				= array();
   	$user['id']			= 0;
   	$user['status']		= 'me';
   	$user['name']		= $name;
   	$user['pass']		= $password;
   	$user['mail']		= $data['email'];
   	$user['title']		= '';
   	$user['posts']		= 0;
   	$user['joined']		= time();
   	$user['ip']			= $fm->_IP;
   	$user['showemail']	= FALSE;
   	$user['www'] 		= '';
   	$user['icq']		= '';
   	$user['aim']		= '';
   	$user['location']	= '';
    $user['identity']   = $data['identity'];
   	$user['interests']	= '';
   	$user['sig']		= '';
   	$user['sig_on']		= FALSE;
   	$user['lang']		= Check_DefLangSkin('language','default_lang',$fm->_String('default_lang'));
   	$user['skin']		= Check_DefLangSkin('templates','default_style',$fm->_String('default_style'));
   	$user['timedif']	= '';
   	$user['avatar']		= '';
   	$user['upload']		= ($fm->exbb['autoup'] === TRUE) ? TRUE : FALSE;
   	$user['visible'] 	= TRUE;
    $user['status'] 	= '';
   	$user['new_pm'] 	= FALSE;
   	$user['sendnewpm'] 	= FALSE;
    $user['posts2page'] = $fm->exbb['posts_per_page'];
   	$user['topics2page']= $fm->exbb['topics_per_page'];
   	$user['last_visit'] = 0;

    $id = array_keys($allusers);
    sort($id);
    $id = array_reverse($id);
    $id = $id[0]+1;

    $fm->_BOARDSTATS();
    $id = ($fm->_Stats['last_id'] === $id) ? $id + 1:$id;

    $allusers[$id]['n'] = $name;
    $allusers[$id]['m'] = $data['email'];
    $allusers[$id]['p'] = 0;
    $fm->_Write($fp_allusers,$allusers);
    unset($allusers);

    $user['id']			= $id;
   	$user['pass']		= md5($user['pass']);
   	$user['last_visit'] = $fm->_Nowtime;

    $fm->_Read2Write($fp_user,'members/'.$id.'.php');
    $fm->_Write($fp_user,$user);

    $fm->_GetVars();
    $fm->_String('action', 'agreement');
    $fm->_LoadLang('register');

    loginUser($user);

}
else
{
        header("Location: index.php");
}


function check_user_exist($username)
{
    global $allusers;
    global $fm;

    foreach ($allusers as $u_id => $info) {
        if ($info['n'] == $username) {
            return true;
        }
    }

    return false;
}

function find_user($username,$identity)
{
    global $fm;
    global $allusers;

    foreach ($allusers as $u_id => $info) {
        if (strpos($info['n'],$username) === 0) {
            $user = $fm->_Read2Write($fp_user,'members/'.$u_id.'.php',FALSE);
            if (isset($user['identity']) && $user['identity']==$identity)
            {
                $fm->_Fclose($fp_user);
                return $user;
            }
            else
            {
                $fm->_Fclose($fp_user);
            }
        }
    }

    return false;
}

function gen_user_name($name)
{
    global $allusers;

    if (!check_user_exist($name)) return $name;

    $id = array_keys($allusers);
    sort($id);
    $id = array_reverse($id);
    $id = $id[0];
    $tname = $name.$id;
    while(check_user_exist($tname))
    {
        $id++;
        $tname = $name.$id;
    }
    return $tname;
}

function loginUser($user)
{
    global $fm;

    if (is_array($user)) {

        $id = $user['id'];

        $fm->user['name'] = $user['name'];
        if ($user['status'] == 'banned') {
            return;
        }
        $now_time = time();

        $_SESSION['mid'] = $user['id'];
        $_SESSION['sts'] = $user['status'];
        $_SESSION['lastposttime'] = isset($user['lastpost']['date']) ? $user['lastpost']['date'] : $now_time - 180;
        $_SESSION['iden'] = md5($user['name'] . $user['pass'] . _SESSION_ID);

        $fm->_setcookie('exbbn', $user['id']);
        $fm->_setcookie('exbbp', md5($user['pass']));
        $fm->_setcookie('lastvisit', $fm->_Nowtime);
        $fm->_WriteLog($fm->LANG['LogedIn']);
        header('Location: index.php?'._SESSION_ID);
        exit;
    }
}