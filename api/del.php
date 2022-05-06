<?php
require_once(__DIR__ . "/classes.php");
CookieCheck::Check();
$post = $_GET;
SetRequestHandler::CheckAndReply($post, "del");
