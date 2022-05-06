<?php
require_once(__DIR__ . "/classes.php");
CookieCheck::Check();

$res = new Responder;

try
{
    $str = Filer::ReadJson();
    $res->response = json_decode($str);
}
catch (Exception $ex)
{
    $res->error = $ex->getMessage();
}
header('Content-Type: application/json; charset=utf-8');
echo $res->toJSON();
