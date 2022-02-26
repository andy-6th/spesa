<?php
require_once(__DIR__ . "/classes.php");

if (REQUIRECOOKIES) {
    if (setcookie(COOKIENAME, COOKIEVALUE, time() + (60 * 60 * 24 * 365 * 10), "/")) // Ten years!
        echo "Registered";
    else
        echo "Something went wrong";
} else {
    setcookie(COOKIENAME, "", time() - 3600, "/");
    echo "Unregistered";
}
