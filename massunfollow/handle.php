<?php
require("twitteroauth/twitteroauth.php");
require_once('config.php');
date_default_timezone_set('America/New_York');
if(file_exists('tokenfile.php')) {
require_once('tokenfile.php');
}

set_time_limit(15000);
$twitapi = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $accestok, $secretacesstok);
$me = $twitapi->get('account/verify_credentials');
$myname = $me->screen_name;
$myid = $me->id;
$filetime = 'time' . $me->id . '.php';
$var = 'time' . $me->id ;

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


if(file_exists($filetime)) {
require($filetime);
if(isset($_POST['nohelper']) && $_POST['nohelper'] == "") {
		$lasttime = strtotime(${$var}[1]);
		$timenext = date('Y/m/d H:i:s', strtotime("+24 hours", $lasttime));
		$time_now = date('Y/m/d H:i:s');
		$diffinhour = strtotime($timenext) - strtotime($time_now);
		if($diffinhour > 0){
			if(${$var}[0] == 0) {
					$stop = date( 'H:i:s', $diffinhour);
					$stop = explode(':', $stop);
				?>
				<script>
					jQuery(document).ready(function($){
					$("#wait").hide();
						alert("You have reach maximum 1000 follows allowed today! Please follow again after " + <?php echo $stop[0]; ?> + " Hours - " + <?php echo $stop[1]; ?> + " Minutes and " + <?php echo $stop[2]; ?> + " Seconds");
						$("#mydata").remove();
						$('#all_results').remove();
						location.reload();
					});
				</script>
					<?php
						die();
			}
		} else {
			$fp=fopen($filetime,'w');
			fwrite($fp, '<?php 
				$time' . $me->id . ' = array(1000, 0 , 0,' . ${$var}[3] . ');
			?>');
			fclose($fp);
		} 
	}
$prevfollow = ${$var}[2];
} else {
$prevfollow = 0;
}
		


// Followers
$e = 0;
$cursor = -1;
$followers = array();
do {
$mefollowers = $twitapi->get('followers/ids', array('screen_name' => $myname));
$foll_array = $mefollowers->ids;

  foreach ($foll_array as $key => $val) {

        $followers[$e] = $val;
        $e++; 
  }	
	
	$cursor = $mefollowers->next_cursor;
	
} while ($cursor > 0);

// echo $e;


if(isset($me->errors[0]->message)) {
	$errors = $me->errors[0]->message;
	echo "<p><b>". $errors . " Please Try Again Later Or Try <a href='http://manageflitter.com/try/bcrxJoaL'>This Tool</a> To Manage Your Following!</b><p>";
} else {



// FOLLOW HANDLER
		if(isset($_POST['init_follow'])) {
			$master_user = $_POST['user'] != "" ? stripslashes($_POST['user']) : "";
			$maxnumb = $_POST['maxnum'] != "" ? stripslashes($_POST['maxnum']) : 5000;

				// Followers
				$h = 0;
				$cursor = -1;
				$followersof = array();
				// do {
				$theirfollowers = $twitapi->get('followers/ids', array('screen_name' => $master_user, 'count' => 5000, 'cursor'=> $cursor));
				$follarray = $theirfollowers->ids;

				  foreach ($follarray as $key => $val) {
						$followersof[$h] = $val;
						$h++; 
				  }
					
					// $cursor = $theirfollowers->next_cursor;
					
				// } while ($cursor > 0);				
				
				
					
					?>
					<div style="clear:both;"></div>
						<div id="all_results">
							<input id="next_cursor" type="hidden" name="next_cursor" value="<?php echo $nc; ?>"/>
							<?php
								$tofollow = array();
									foreach($followersof as $uid) {
										if(!in_array($uid, $following)){
											$tofollow[] = $uid;
										}
										if(count($tofollow) == $maxnumb) {
											break;
										}

									}
			
								foreach($tofollow as $id) {
										// Follow
									$twitapi->post('friendships/create', array('user_id' => $id));
									usleep(rand(500000, 1000000));						
								}
				/* if(file_exists($filetime)) {
					$lasttime = strtotime($time[1]);
					$lasttime = date('Y/m/d', $lasttime);
					$time_now = date('Y/m/d');
					if(strtotime($lasttime) == strtotime($time_now)) {
						$date = $time[1];
					}
				} */			
			$currentfollow = count($tofollow) + $prevfollow;
			$remaintoday = 1000 - $currentfollow;
			$date = date('Y/m/d H:i:s');
			if(file_exists($filetime)) {
			$totaldofollowing = ${$var}[3] + $currentfollow;
			} else {
			$totaldofollowing = $a + $currentfollow;
			}			
			
				$fp=fopen($filetime,'w');
				fwrite($fp, '<?php 
					$time' . $me->id . ' = array(' . $remaintoday  .', "' . $date . '"' .', ' . $currentfollow . ',' . $totaldofollowing . ');
				?>');
				fclose($fp);
								echo '<p><b>'. count($tofollow) . ' Users Has Been Followed!</b></p>';		
						?>
						</div>		
						<?php
			} 
		
		

//UNFOLLOW
		if(isset($_POST['req']) && $_POST['limit'] != "") {
		$limit = isset($_POST['limit']) ? $_POST['limit'] : 25;

		?>
				<div id="mydata">
		<?php
					$unfollowed = array();
					foreach($following as $key => $uid) {
						// if($key < $limit) {
							if(!in_array($uid, $followers)) {
								if( $uid != 2387646145) {
									$unfollowed[] = $uid;
								}
							}
						// }
						
						if(count($unfollowed) == $limit) {
							break;
						}
					}
					
					foreach($unfollowed as $id){
						$twitapi->post('friendships/destroy', array('user_id' => $id));
						usleep(rand(500000, 1000000));
					}
					
					
					echo '<p><b>'. count($unfollowed) . ' Users has been successfully unfollowed!</b></p>';	
		?>
				</div>
		<?php

				
		}


// Follow back
		if(isset($_POST['followback']) && $_POST['follback'] != "") {
		$limit = isset($_POST['follback']) ? $_POST['follback'] : 25;

		?>
				<div id="mydata">
		<?php
					$followedback = array();
					foreach($followers as $key => $uid) {
						// if($key < $limit) {
							if(!in_array($uid, $following)) {
								// if( $uid != 2387646145) {
									$followedback[] = $uid;
								// }
							}
						// }
						
						if(count($followedback) == $limit) {
							break;
						}
					}
					
					foreach($followedback as $id){
						$twitapi->post('friendships/create', array('user_id' => $id));
						usleep(rand(500000, 1000000));
					}
					
			
			$currentfollow = count($followedback) + $prevfollow;
			$remaintoday = 1000 - $currentfollow;
			$date = date('Y/m/d H:i:s');
			if(file_exists($filetime)) {
			$totaldofollowing = ${$var}[3] + $currentfollow;
			} else {
			$totaldofollowing = $a + $currentfollow;
			}			
			
				$fp=fopen($filetime,'w');
				fwrite($fp, '<?php 
					$time' . $me->id . ' = array(' . $remaintoday  .', "' . $date . '"' .', ' . $currentfollow . ',' . $totaldofollowing . ');
				?>');
				fclose($fp);
				
		echo '<p><b>'. count($followedback) . ' Users has been successfully followed back!</b></p>';
				?>
				</div>
		<?php
		}
		
		
$myinfo = $twitapi->get('statuses/user_timeline', array('screen_name' => $myname, 'count' => 2));
$e = $myinfo[0]->user->followers_count;
$a = $myinfo[0]->user->friends_count;

	if(file_exists($filetime)) {
	require($filetime);
	}

	$limitPerDay = 1000; 
	if($e >= 2000) {
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
		$note = "You can follow maximum <b>" . $maxFollowNow . "</b> accounts today!";
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
	
	echo "<span id='follows'>Following: <b>" . $a . "</b> | Followers: <b>" . $e . "</b></span>" ;
	?>
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

						if(isset($remaintoday )) {
						echo '<li>Your remaining following quota is: <b>' . $remaintoday . '</b> times for today!</li>';
						echo "<input type='hidden' name='remainquota' id='remainquota' value='" . $remaintoday . "'/>";
						}
				?>
				</ul>
				</div>
	<?php		
	
}
?>
