<?php
$unread			= ($fm->user['unread'] === 0) ? '':' ( '.$fm->user['unread'].' )';
$admincenter	= (defined('IS_ADMIN')) ? '&nbsp;&middot; <a href="announcements.php" title="'.$fm->LANG['Announ'].'">'.$fm->LANG['Announ'].'</a>&nbsp;&middot; <a href="admincenter.php" title="'.$fm->LANG['Admincenter'].'"><font color=red>'.$fm->LANG['Admincenter'].'</font></a>' : '';
$loginout		= ($fm->user['id'] !== 0) ? '( <a href="loginout.php?action=logout" title="'.$fm->LANG['Exit'].'">'.$fm->LANG['Exit'].'</a>'.$admincenter .'&nbsp;&middot; <a href="tools.php?action=rules" title="'.$fm->LANG['ForumRules'].'"><font color="red">'.$fm->LANG['ForumRules'].'</font></a> )':'( <a href="loginout.php" title="'.$fm->LANG['Login'].'">'.$fm->LANG['Login'].'</a> &middot; <a href="register.php" title="'.$fm->LANG['Registration'].'">'.$fm->LANG['Registration'].'</a>&nbsp;&middot; <a href="tools.php?action=rules" title="'.$fm->LANG['ForumRules'].'"><font color="red">'.$fm->LANG['ForumRules'].'</font></a>  )';
$loginact		= ($fm->user['id'] !== 0) ? '<b><a href="profile.php" title="'.$fm->LANG['YourProfile'].'">'.$fm->LANG['YourProfile'].'</a></b>&nbsp;&middot; <a href="messenger.php" target="_blank" title="'.$fm->LANG['PMTitle'].'">'.$fm->LANG['PM'].''.$unread.'</a>&nbsp;&middot; <a href="search.php?action=newposts" title="'.$fm->LANG['NewPosts'].'">'.$fm->LANG['NewPosts'].'</a>'  : ' <a href="profile.php?action=lostpassword" title="'.$fm->LANG['ForgottenPass'].'">'.$fm->LANG['ForgottenPass'].'</a> ';
echo <<<DATA
{$GLOBALS['fm']->_NewEmail}
			<table width="100%" id='logostrip' cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php" title="{$fm->exbb['boardname']}"><img src="./templates/InvisionExBB/im/logo.gif" alt="{$fm->exbb['boardname']}" width="207" height="52" border="0" /></a></td>
					<td valign="bottom" align="right"><a href="index.php" style="margin-right:20px;color:#ffffff">{$fm->exbb['boardname']}</a></td>
				</tr>
			</table>
			<table width="100%" cellspacing="6" id="logomenu" border="0">
				<tr>
					<td width="468" align="center" rowspan="2">{$fm->_Banner}</td>
					<td valign="top" align="right"><span style="margin-right:15px;">{$fm->exbb['boarddesc']}</span></td>
				</tr>
				<tr>
					<td align="right" valign="bottom" nowrap>
						<img src="./templates/InvisionExBB/im/help.gif" border="0" alt="" />&nbsp;<a href="tools.php?action=help" title="{$fm->LANG['Help']}"><b>{$fm->LANG['Help']}</b></a>&nbsp; &nbsp;&nbsp;
						<img src="./templates/InvisionExBB/im/search.gif" border="0" alt="" />&nbsp;<a href="search.php" title="{$fm->LANG['Search']}"><b>{$fm->LANG['Search']}</b></a>&nbsp; &nbsp;&nbsp;
						<img src="./templates/InvisionExBB/im/members.gif" border="0" alt="" />&nbsp;<a href="tools.php?action=members" title="{$fm->LANG['Users']}"><b>{$fm->LANG['Users']}</b></a>
					</td>
				</tr>
			</table>
			<table width="100%" id="userlinks" cellspacing="6">
				<tr>
					<td>{$fm->LANG['Hello']} {$fm->user['name']} {$loginout}
DATA;

if ($fm->user['id'] == 0)
echo '<div id="uLogin" x-ulogin-params="display=small;fields=first_name,last_name,email;providers=vkontakte,odnoklassniki,mailru,facebook;hidden=other;redirect_uri='.urlencode('http://'.$_SERVER['HTTP_HOST'].'/ulogin.php').'"></div>';

echo <<<DATA
                    </td>
					<td align='right'>$loginact</td>
				</tr>
			</table>
DATA;
?>
