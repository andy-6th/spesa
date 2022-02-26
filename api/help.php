<?php
require_once(__DIR__ . "/classes.php");
CookieCheck::Check();
echo '
<pre>
API USAGE

/***********************************************************************/

/api/help                   => display this message

/api/get                    => list all items in cart and in backup list

/api/add?name="item name"   => push item to main shopping list

/api/set?jsonstring=...     => set entire cart list and backup list

     jsonstring is a json formatted array like 
            [{"name":"item1","listed":"booleanValue"},...]
     where each element has a non empty name and a "listed" property set to 
     true to put the item in the cart or false to put it in the backup list.
     Note that some characters like ":" might require a special html format.

/***********************************************************************/
</pre>
';