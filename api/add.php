<?php
require_once(__DIR__ . "/classes.php");

$post = $_GET;

$name = isset($post['name']) ? $post['name'] : die("missing name");

$el = new Element();
$el->name = $name;

Filer::Add($el);
echo "OK";