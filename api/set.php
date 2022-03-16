<?php
require_once(__DIR__ . "/classes.php");
CookieCheck::Check();

$post = $_GET;

if (!isset($post["jsonstring"])) die("input error");

Filer::WriteAllJson($post["jsonstring"]);
echo "OK";
