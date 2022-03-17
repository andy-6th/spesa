<?php

const MYLIST = "list.json";
const REQUIRECOOKIES = false;  // Set to true if you want to require registration
const COOKIENAME = "";         // Set cookie name if REQUIRECOOKIES = true
const COOKIEVALUE = "";        // Set cookie value if REQUIRECOOKIES = true



class Filer
{
    private static function CheckFile(): void
    {
        $myfile = fopen(MYLIST, "r");
        if (!$myfile)
        {
            $myfile = fopen(MYLIST, "x") or die("error creating file");
        }
        fclose($myfile);
    }

    public static function ReadJson(): string
    {
        self::CheckFile();
        $contentJSON = file_get_contents(MYLIST);
        return $contentJSON;
    }

    public static function ReadElements(): array // of Element
    {
        $content = json_decode(self::ReadJson());
        return $content;
    }

    public static function Add(string $name): string
    {
        $content = self::ReadElements();
        // Duplicate check
        if (Filer::Find($content, $name))
            die("warning: item already listed");
        $el = new stdClass;
        $el->name = $name;
        $el->listed = true;
        array_unshift($content, $el);
        return Filer::WriteAll($content);
    }

    /* Buy an item ($buy = true) or resume it from backup list ($buy = false) */
    public static function Shift(string $name, bool $buy): string
    {
        $content = self::ReadElements();
        // Duplicate check
        if ($element = Filer::Find($content, $name, $buy))
        {
            $i = array_search($element, $content);
            array_splice($content, $i, 1);
            $element->listed = !$buy;
            array_unshift($content, $element);
            return Filer::WriteAll($content);
        }
        else
            die("error: item not found");
    }

    public static function Remove(string $name): string
    {
        $content = self::ReadElements();
        // Duplicate check
        if ($element = Filer::Find($content, $name, false))
        {
            $i = array_search($element, $content);
            array_splice($content, $i, 1);
            return Filer::WriteAll($content);
        }
        else
            die("error: item not found");
    }

    public static function Find(array $content, string $name, bool $listed = true): ?Object
    {
        foreach ($content as &$element)
        {
            if (strtolower($name) == strtolower($element->name) && $element->listed == $listed)
                return $element;
        }
        return null;
    }

    public static function WriteAll($myarray): string
    {
        if (!is_array($myarray))
            die("error: array expected");
        return Filer::WriteAllJson(json_encode($myarray));
    }

    public static function WriteAllJson(string $jsonstring): string
    {
        // Content check
        $content = json_decode($jsonstring);
        if (!is_array($content))
            die("error: json content is not an array");
        // Prettify
        $jsonpretty = json_encode($content, JSON_PRETTY_PRINT);
        // Write file
        $myfile = fopen(MYLIST, "w") or die("error opening file");
        if (!fwrite($myfile, $jsonpretty))
            die("error writing file");
        fclose($myfile);
        return $jsonpretty;
    }
}

class CookieCheck
{
    public static function Check(): void
    {
        if (REQUIRECOOKIES && (!isset($_COOKIE[COOKIENAME]) || $_COOKIE[COOKIENAME] != COOKIEVALUE))
            die("Access denied");
    }
}
