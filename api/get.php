<?php
require_once(__DIR__ . "/classes.php");
CookieCheck::Check();
SetRequestHandler::CheckAndReply(null, "get");
