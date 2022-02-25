<?php
require_once(__DIR__ . "/classes.php");

$post = $_GET;

$name = isset($post['name']) ? $post['name'] : die("error missing name");
if ($name == "")
    die("error empty item name");

$el = new Element();
$el->name = $name;

Filer::Add($el);
echo "OK";
