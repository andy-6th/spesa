<?php
require_once(__DIR__ . "/classes.php");
CookieCheck::Check();

$post = $_GET;

$res = new Responder;

if (isset($post['name']))
{
    $name = $post['name'];
    if ($name == "")
        $res->error = "error: empty item name";
}
else
    $res->error = "error: missing parameter: name";

if (!$res->error)
{
    try
    {
        Filer::Add($name);
        $res->response = "OK";
    }
    catch (Exception $ex)
    {
        $res->error = $ex->getMessage();
    }
}

echo $res->toJSON();