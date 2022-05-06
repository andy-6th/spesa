<?php
require_once(__DIR__ . "/classes.php");
CookieCheck::Check();
echo '
<pre>
API USAGE

/*********************************************************************************/

/api/help                   => display this message

/api/get                    => list all items in cart and in backup list

/api/add?name="item name"   => either push item to main shopping list, or
                               resume item from backup list to main list

/api/buy?name="item name"   => move item from main shopping list to backup list

/api/del?name="item name"   => permanently remove item from backup list

     In all the above endpoints, the parameter "item name" is case insensitive
     and shoud be url-encoded.

/*********************************************************************************/
</pre>
';