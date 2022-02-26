<?php
require_once(__DIR__ . "/classes.php");
CookieCheck::Check();

$obj = Filer::ReadJson();
echo $obj;
