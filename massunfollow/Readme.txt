/*
TWITTER MASS FOLLOW UNFOLLOW
Simple and ugly but powerful tool! Get to know how to use it wisely!
*/

***INSTALLATION INSTRUCTION***



Step by step installation:

1. Create twitter app account here https://apps.twitter.com/app/new. You will need phone verified twitter account in order to make an app. Fill in your app detail in the form on that page.
	- Name: Give name to your app.
	
	- Description: Give your app a description.
	
	- Website: The home page url you are going to use for the app. For example: "http://example.com/yourapp", where "yourapp" on that url is the name of directory where you upload this script. /*If you have no hosting account and want to use your computer to run this app, then use this domain instead: "http://127.0.0.1/yourapp/"*/
	
	- Callback url: This is the url where the user of your app (you) will be redirected back after successfully login/ authorize app to twitter. Make sure it contains "callback.php" at the end of the url. Example: "http://example.com/yourapp/callback.php". Or "http://127.0.0.1/yourapp/callback.php" if you are going to use your computer.

2. Editing the config file
Extract the zip file of this script on your computer. Find a file named "config.php" inside, open it up using text editor such as notepad and find the following lines:

			define('CONSUMER_KEY', 'YOUR_APP_CONSUMER_KEY');
			define('CONSUMER_SECRET', 'YOUR_APP_SECRET_KEY');
			define('OAUTH_CALLBACK', 'YOUR_APP_CALLBACK_URL');
			
Change the followings:
"YOUR_APP_CONSUMER_KEY" with your app Consumer Key (API Key).
"YOUR_APP_SECRET_KEY" with your app Consumer Secret (API Secret).
and
"YOUR_APP_CALLBACK_URL" with callback URL you previously set when creating the app.

You can find your app Consumer Key (API Key) and Consumer Secret (API Secret) on "Keys and Access Tokens" section on your app managament panel.

Save it and upload the entire script to your server.

3. Uploading to server
If you are using xampp, then create a folder in a directory called "htdocs" and locate the script inside the directory you created. You can download xampp here https://www.apachefriends.org/index.html. 

If you are using live server, then you can upload the script anywhere inside your site main directory/ root folder.

Make sure that you chmod the directory where you put this script to "755".

If you still need help or support for installation, then you can contact me here: https://www.fiverr.com/satria1/php-wordpress-fb-app-programming-service


***HOW TO USE?***

This tool is simple and self explanatory. But here is the guide if you still doubt about how to use it.

I. Initialize The App

1. Open the main app url, it is where you uploaded this script.
If you upload your this app script inside a folder called "yourapp", then the main app url would be like this: "http://yoursite.com/yourapp", where "http://yoursite.com/" will be your site domain and "yourapp" is the folder name inside your site where you uploaded the script.
If you are using local server, then the url will be , example: http://127.0.0.1/yourapp.

2. Check "I Agree" and click the showed "Connect To Twitter?" button.

3. Click "Sign In" button after you are being prompted to the twitter app authentication page. You will then being redirected back to your app home page.
If the authentication is failed and bring you back to connect confirmation page, then just repeat the point 2 above until you are being redirected back to your app home page.

II. Mass Follow
This feature is used to follow any user's followers.
Fields value:
1. Followers of: User's account screen name/ you want their follower accounts to be followed by your account. 
Example: "@username" or "username".

2. Max Following: The maximum number of accounts you want to follow. It can't be more than 5000.

Click the "Follow" button to start and wait until the process is finished. You can check your account to see that the number of your followings is increased.


III. Mass Unfollow
This feature is used to mass unfollow your followings who are not following you back.
Type the number of users you want to unfollow in the text field. It's value should be number. And then click the "Unfollow" button to start. Wait until the process is finished.

While processing, either you are doing mass following or mass unfollowing, the app page will be blocked by black cover to prevent process interference.

IV. Change Twitter Account
You can change twitter account you want to manage by logout from your current twitter account and then login to another account you want to use with this app. Next, logout from your app by clicking the logout button located on the upright corner and then do the authentication like you did with your previous account.

That's it!