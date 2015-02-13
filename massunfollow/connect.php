<?php
ob_start();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Connect To Twitter</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="main.css"/>
	</head>
		<body>
<?php
/* Build an image link to start the redirect process. */
// $content = '<a href="./redirect.php"><img src="./images/lighter.png" alt="Sign in with Twitter"/></a>';
			if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {

			?>
<div id="connect">
<p class="note">By using this tool, you are agree to automatically following <a href='http://twitter.com/WordsNinja'>@WordsNinja</a> and displaying ads on this app! Please send follow back request via mention if you would like to be followed back by @WordsNinja!
</p>
<hr>
<p class="note">
If you want the same script without auto following to @WordsNinja and advertisement, then you can get it for <b>$27</b> by message me through <a href="https://www.facebook.com/IndscriptSolution">this facebook page</a>!
</p>
<input type="checkbox" name="justconnect" id="justconnect"/> <label for="justconnect"><b>I Agree!</b></label>
	<form method="post" action="" id="connecttotwitter">
		<input type="submit" name="gototwitterauth" value="Connect To Twitter?"/>
	</form>
	<p></p>
<iframe src="http://yllix.com/banner_show.php?section=General&amp;pub=917691&amp;format=300x250&amp;ga=g" frameborder="0" scrolling="no" width="300" height="250" marginwidth="0" marginheight="0"></iframe>	
</div>
<?php

	} else {
	header('Location: ./');
}

	if(isset($_POST['gototwitterauth'])) {
		header('Location: ./redirect.php');
		die();
	}

?>

	</body>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script type="text/javascript" src="jqueryajax.js"></script>	
</html>
