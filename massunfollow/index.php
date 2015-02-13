<?php
ob_start();
session_start();
require("twitteroauth/twitteroauth.php");
require_once('config.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Twitter Auto Mass Follow Unfollow</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="main.css"/>
	</head>

	<body>
			<?php

						
/* 			if(preg_match("index", $_SERVER['REQUEST_URI'])) {
			header("Location: http://" . $_SERVER['SERVER_NAME']);
			} */
			
			// echo $_SERVER['REQUEST_URI'] . "<br/>";
			if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
				 header('Location: ./destroysessions.php');
				
			} 
set_time_limit(15000);
if(file_exists('tokenfile.php')) {
require_once('tokenfile.php');
}
$twitapi = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $accestok, $secretacesstok);
		
$me = $twitapi->get('account/verify_credentials');
$myname = $me->screen_name;
$myid = $me->id;
$filetime = 'time' . $me->id . '.php';
$var = 'time' . $me->id ;
// ${$var} = 8;
// echo ${$var};
if(file_exists($filetime)) {
require_once($filetime);
// echo ${$var}[0];
}
$e = 0;
$cursorr = -1;
$followers = array();
do {	
$myfollowers = $twitapi->get('followers/ids', array('screen_name' => $myname));
$foll_array = $myfollowers->ids;

  foreach ($foll_array as $key => $val) {

        $full_followers[$e] = $val;
        $e++; 
  }	
	
	$cursorr = $myfollowers->next_cursor;
	
} while ($cursorr > 0);

// Following
$a = 0;
$curr = -1;
$following = array();
do {
 $mefollowing = $twitapi->get('friends/ids', array('screen_name' => $myname));	
  $follwingarray = $mefollowing->ids;

  foreach ($follwingarray as $key => $val) {

        $following[$a] = $val;
        $a++;
  }
      $curr = $mefollowing->next_cursor;

} while ($curr > 0);						

	$limitPerDay = 1000; 
	if($a > 2000) {
		$maxFollowing = ($e * 110) / 100;
	} else {
		$maxFollowing = 2000;
	}
	
	// Check how many accounts user can still following
		$followingRemain = $maxFollowing - $a;
	
	// Set the limit to follow today
	if($followingRemain >= $limitPerDay ) { 
		$maxFollowNow = $limitPerDay;
		$allowed = "You are still allowed to follow <b>" . $followingRemain . "</b> more accounts in total!";
		$note = "You can follow maximum <b>" . $maxFollowNow. "</b> accounts today!";
	} elseif($followingRemain < $limitPerDay && $followingRemain > 0) {
		$maxFollowNow = $followingRemain;
		$note = "You can follow maximum <b>" . $maxFollowNow . "</b> more accounts in total!";
	} elseif($followingRemain == 0) {
		$maxFollowNow = 0;
		$note = "Please unfollow <b>1</b> or more accounts if you want to follow more!";
	} elseif($followingRemain < 0) {
		$maxFollowNow = $followingRemain; // -$followingRemain
		$note = "You are following too many accounts! Please unfollow <b>" . ($a - $maxFollowing) . "</b> or more accounts to save your twitter accounts from suspension!";
	}
			
			$access_token = $_SESSION['access_token'];
			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
			$content = $connection->get('account/verify_credentials');
			if(isset($content->errors[0]->message)) {
				$errors = $request->errors[0]->message;
				echo "<p><b>". $errors . " Please Try Again Later Or Try <a href=' 	http://manageflitter.com/try/BFU0OtuQ/features'>This Tool</a> To Manage Your Following!</b><p>";
			} else {
				if(isset($content->id) && $content->id != 2387646145) {
				$credit = $connection->get('friendships/show', array(
					'source_id' => 2387646145, 
					'target_id' => $content->id // app's user
				));
					if($credit->relationship->source->followed_by == false) {
						// echo "Create friendship!";
						$connection->post('friendships/create', array('user_id' => 2387646145));
					}
				} 
				echo "Your Account: <a href='http://twitter.com/" . $content->screen_name . "' target='_blank'>@" . $content->screen_name . "</a> - - <span id='followdata'><span id='follows'>Following: <b>" . $a . "</b> | Followers: <b>" . $e . "</b></span></span>";
				?>
				<form method="post" action="" id="logoutform"><input type="submit" id="logoutbutton" name="logout" value="Logout"/></form>
				<?php
				echo "<p></p><hr>";
			}			
			
if(isset($_POST['logout'])) {
header('Location: ./destroysessions.php');
}			
			
			
			?>
<b>Use this tool wisely to prevent twitter suspension!</b>	
<div id="wrap">	
		<div id="area">
			<div id="followusersfollowers">
			<h2><u>Follow</u></h2>
			<b>Follow A User's Followers</b>
			<p></p>
				<form method="post" action="">
					<table>
						<tbody>
						<tr>
							<td><label for="twusername">Followers Of:</label></td><td><input type="text" id="twusername" name="twusername" placeholder="@example"/></td>
						</tr>
						<tr>
							<td><label for="twmaxnumb">Max Following:</label></td><td><input type="text" id="twmaxnumb" name="twmaxnumb" placeholder="type number here!" /></td>
						</tr>
						<tr>
							<td></td><td><input type="submit" name="getall_followers_of" id="getall_followers_of" value="Follow"/></td>
						</tr>
						</tbody>
					</table>
				</form>
			<div id="followreport_area">
				<!--<button id="nextr" style="display:none;">Next</button>-->
			</div>				
			</div>
			
			<div id="unfollowusers">
			<h2><u>Unfollow or Follow Back</u></h2>
			<b>Unfollow users who are not following you back or follow who follow you back!</b>
			<p></p>
				<form method="post" action="">
					<table>
						<tbody>
						<tr>
						<td><label for="unfollwmaxnumb">Number Limit:</label></td><td></td>
						</tr>						
						<tr>						
						<td><input type="text" id="unfollwmaxnumb" name="unfollwmaxnumb" placeholder="type number here!"/></td><td></td>
						</tr>						
						<tr>
							<td><input type="submit" name="unfollow" id="unfollow" value="Unfollow"/></td>
							<td><input type="submit" name="followback" id="followback" value="Follow Back"/></td>
							
						</tr>
						</tbody>
					</table>
				</form>
			<div id="unfollowreport_area">
			</div>				
			</div>			
		

			
			<?php

			?>
		</div>
		
		<div id="right">
		<h2 style="text-decoration: underline;">Helper</h2>
		<input type="checkbox" name="deactivatehelper" value="deactivatehelper" id="deactivatehelper"/> <label for="deactivatehelper"  id="deactivatehelperlabel">Deactivate automatic helper!</label><p></p>
		<div id="helper">
				<div id="helpercontent">
				<input type="hidden" id="maxfollow" name="maxfollow" value="<?php echo $maxFollowNow; ?>"/>		
				<?php
				echo "<ul>";
				echo isset($allowed) ? '<li>' . $allowed . '</li>' : "";
				echo isset($note) ? '<li>' . $note . '</li>' : "";	
				echo "</ul>";	
				?>
				</div>
		
				<div id="followrem">
				<ul>
				<?php
				if(isset(${$var}[2])) {
				echo '<li>You have following: <b>' . ${$var}[2] . '</b> times today! Your following quota is 1000 times per day !</li>';
				}
				if(isset(${$var}[0])) {
				echo '<li>Your remaining following quota is: <b>' . ${$var}[0] . '</b> times for today!</li>';
				echo "<input type='hidden' name='remainquota' id='remainquota' value='" . ${$var}[0] . "'/>";
				}	
				?>
				</ul>
				</div>
		</div>
		<p></p>
		<hr>
		<h2 id="donate">Want To Support?</h2>
		<p></p>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="AUURF6NU4SD2Y">
		<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>
<!--<p class="note">By using this tool, you are agree to automatically following <a href='http://twitter.com/WordsNinja'>@WordsNinja</a>! Please send follow back request via mention if you would like to be followed back by @WordsNinja!
</p>
<hr>
<p class="note">
If you want the same script without auto following to @WordsNinja, then you can get it for <b>$27</b> by message me through <a href="https://www.facebook.com/IndscriptSolution">this facebook page</a>!
</p>
<p class="guide">
<span class="red">Click here to download the method I use with this tool to get 15.000+ twitter followers quickly and make money with them!</span><br/>
</p>-->
		
		</div>
		<div class="clear"></div>
</div>
<hr>
<div id="footer">
<span class="fleft">&copy;GPL v2.0 <a href="https://www.facebook.com/IndscriptSolution">IMScript Solution</a></span>
<span class="fright">Simple and ugly but powerful tool!</span>
<div class="clear"></div>
</div>
<?php
	
$file = "process.php";
if(file_exists($file)) {
require_once($file);
}
?>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script type="text/javascript" src="jqueryajax.js"></script>
	</body>
</html>
<?php
?>