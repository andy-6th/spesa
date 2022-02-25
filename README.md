# Private shopping cart app #
## Prerequisites ##
This app runs on Apache server with PHP and .htaccess enabled (if you don't know how to enable it, try Googling a bit: an example can be found here https://www.linode.com/docs/guides/how-to-set-up-htaccess-on-apache/).
If you want to use the app with a different server (like Nginx), please substitute .htaccess file with appropriate configuration. URLs are rewritten without the trailing ".php" extension: that's actually the only rule needed to make things work.
## Installation instructions ##
Just copy the repository content in a folder of your choice under your HTTP/HTTPS server root. You'll be able to reach the app at the address 
`http(s)://your.server.address/chosen-folder`.
## Features ##
The app is quite intuitive: you can add new items to the list, mark an item as purchased and restore or delete items from the backup list at the bottom. Have fun sharing your shopping list with your partner!

