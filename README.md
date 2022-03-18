# SPESA&copy; - Shopping cart manager #
## Description ##
SPESA&copy; is a very Simple Planner Engine for Shopping Assistance. It offers a web interface to share a shopping list with your partner, family or flatmates. Upload the app to your server and share the link with your shopping mates to get an easy-to-use shared shopping list that updates in real time.
## Features ##
The app is quite intuitive. It provides a main shopping list (the top one) and a backup list (the dark, bottom one). You can:
* add new items to the shopping list
* mark an item as purchased (the item will be stored in the backup list for future needs)
* restore an item from the backup list to the main list
* permanently delete items from the backup list

Note that you can't have duplicates in the main list, while duplicate entries could be saved in the backup list. Any change made by a user is immediatly reflected on any other device, with a maximum delay of 10s.
## Installation instructions ##
### Prerequisites ###
This app runs on Apache server with PHP version 7.2 or above, and .htaccess file enabled. If you're not familiar with how to enable .htaccess, try a Google search. If you're lazy, you can find an example here https://www.linode.com/docs/guides/how-to-set-up-htaccess-on-apache/.
If you want to run the app on a different server (i.e. Nginx), please substitute the .htaccess file with appropriate configuration. Basically, the provided .htaccess file rewrites URLs without the trailing ".php" extension: that's actually the only rule needed to make things work. Other rules were added for completeness sake, but they are not fundamental.
### Install SPESA&copy; ###
Just copy the repository content in a folder of your choice under your HTTP/HTTPS server root. Please remember to chown the whole directory to the http server user (usually www-data:www-data). You'll be able to reach the app at the address 
`http(s)://your.server.address/chosen-folder`.
## Registration mode ##
If you think your app URL is too "public" and easily reachable by unwanted users, a very simple _registration_ mode can be set. It's just a silly expedient that sets a minumum level of access filtering using cookies. 
### Instructions ###
1. Open `api/classes.php` and set `REQUIRECOOKIES` to true;
2. In the same file, set a non empty value for `COOKIENAME` and `COOKIEVALUE`;
3. Save and close `api/classes.php`;
4. Notice that now, if you try to access the app, you get an "access denied" message;
5. In order to "register", go to `http(s)://your-server/app-path/api/register`
6. Ensure you get a short confirmation message: a long term cookie is now set to your device and will grant access to the app.

Now you can access your app with the usual URL. Notice that, from now on, you should register any device you want to connect to the app (steps 5 and 6). Unregistered devices will get an "access denied" message. If you want to unset registration mode, open `api/classes.php` and set `REQUIRECOOKIES` to false again. No further action is needed. 

