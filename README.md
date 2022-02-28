# SPESA&copy; - Private shopping cart app #
## Description ##
SPESA&copy; is a very Simple Planner Engine for Shopping Assistance. It offers a web interface to share a shopping list with your partner, family or flatmates. Upload the app to your server and share the link with your shopping mates to get an easy-to-use shared shopping list that updates in real time.
## Prerequisites ##
This app runs on Apache server with PHP and .htaccess enabled. If you're not familiar with how to enable .htaccess, try a Google search; an example can be found here https://www.linode.com/docs/guides/how-to-set-up-htaccess-on-apache/.
If you want to run the app on a different server (i.e. Nginx), please substitute the .htaccess file with appropriate configuration. Basically, the provided .htaccess file rewrites URLs without the trailing ".php" extension: that's actually the only rule needed to make things work. Other rules were added for completeness sake, but they are not fundamental.
## Installation instructions ##
Just copy the repository content in a folder of your choice under your HTTP/HTTPS server root. You'll be able to reach the app at the address 
`http(s)://your.server.address/chosen-folder`.
## Features ##
The app is quite intuitive: you can add new items to the list, mark an item as purchased and restore or delete items from the backup list at the bottom. Have fun sharing your shopping list with your partner!
## Registration mode ##
If you think your app URL is too "public" and easily reachable by unwanted users, a very simple _registration_ mode can be set. It's just a silly expedient that sets a minumum level of access filtering using cookies. Instructions:
* Open `api/classes.php` and set `REQUIRECOOKIES` to true;
* In the same file, set a non empty value for `COOKIENAME` and `COOKIEVALUE`;
* Save and close `api/classes.php`;
* Notice that now, if you try to access the app, you get an "access denied" message;
* In order to "register", go to
  - `http(s)://your-server/app-path/api/register`
* Ensure you get a confirmation message. A long term cookie is set to your device and will grant access to the app.

Now you can access your app with the usual URL. Notice that from now on you should register any device you want to connect to the app. Unregistered devices will get an "access denied" message. If you want to unset registration mode, open `api/classes.php` and set `REQUIRECOOKIES` to false again. No further action is needed. 

