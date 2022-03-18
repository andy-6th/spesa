<?php
require_once(__DIR__ . "/classes.php");
CookieCheck::Check();

$res = new Responder;

try
{
    $str = Filer::ReadJson();
    $res->response = $str;
}
catch (Exception $ex)
{
    $res->error = $ex->getMessage();
}
echo $res->toJSON();
