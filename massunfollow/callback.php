<?php
/**
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */
session_start();
require("twitteroauth/twitteroauth.php");
require_once('config.php');

if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
  $_SESSION['oauth_status'] = 'oldtoken';
  header('Location: ./destroysessions.php');
}

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

//save new access tocken array in session
$_SESSION['access_token'] = $access_token;

// Remove unnecessary token session
unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);

// If success
if (200 == $connection->http_code) {
  $_SESSION['status'] = 'verified';

		 // Save access token to a file
		$fp=fopen('tokenfile.php','w');
		fwrite($fp, '<?php 
		$accestok = "' . $access_token['oauth_token'] . '";
		$secretacesstok = "' . $access_token['oauth_token_secret'] . '";
		?>');
		fclose($fp);

		$file = "process.php";
		if(file_exists($file)) {
		unlink($file);
		}
		// sleep(5);
		if(!file_exists($file)) {		
			$ff=fopen('process.php','w');
			fwrite($ff, "<?php
			?>
			<div id='wait'>
			<h2>PROCESSING...</h2>
			<img src='img/processing.gif'>
			<span>Please wait while your request is being processed! This block will be automatically closed when the process is finished!</span>
			<h3>MAY BE YOU WANT TO USE THE FASTER AND SMARTER ONE BELOW THAN FEEL BORED</h3>
			<a href='http://manageflitter.com/try/BFU0OtuQ/features' target='_blank'><img src='http://cdn2.manageflitter.com/ad-468x60-v2.png'></a>

			<h3>OR DO ONE OF THE FOLLOWING THINGS: </h3>
			<a href='http://twitter.com/WordsNinja' target='_blank'>Read my tweets here!</a><br/>
			<a href='http://twitter.com/<?php echo \$content->screen_name; ?>' target='_blank'>Check your own twitter account!</a><p></p>
			<iframe src=\"http://yllix.com/banner_show.php?section=General&amp;pub=917691&amp;format=728x90&amp;ga=g\" frameborder=\"0\" scrolling=\"no\" width=\"728\" height=\"90\" marginwidth=\"0\" marginheight=\"0\"></iframe>
			</div>");
			fclose($ff);		  
		}

		  
		  
		header('Location: ./');
} else {
  echo "Please like us <a href='https://www.facebook.com/IndscriptSolution'><b>here</b></a> to get help!";
}

?>