<?php
require_once(__DIR__ . "/classes.php");
CookieCheck::Check();

$post = $_GET;

if (!isset($post["jsonstring"])) die("input error");

Filer::WriteAll($post["jsonstring"]);
echo "OK";
