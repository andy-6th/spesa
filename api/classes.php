<?php

const MYLIST = "list.json";
const REQUIRECOOKIES = false;  // Set to true if you want to require registration
const COOKIENAME = "";         // Set cookie name if REQUIRECOOKIES = true
const COOKIEVALUE = "";        // Set cookie value if REQUIRECOOKIES = true


class Element
{
    public $name = "";
    public $listed = true;

    public function set($data)
    {
        /* this conversion also validates data format */
        if (isset($data->name) && isset($data->listed))
        {
            if ($data->name == "")
                die("error: empty item name");
            $this->name = $data->name;
            $this->listed = $data->listed;
        }
        else
            die("error: wrong element format");
    }

    public static function ToElementArray($content)
    {
        $retarray = array();
        if (is_array($content))
        {
            foreach ($content as $value)
            {
                $el = new Element();
                $el->set($value);
                array_push($retarray, $el);
            }
        }
        return $retarray;
    }
}


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
        return Element::ToElementArray($content);
    }

    public static function Add(Element $el): void
    {
        $content = self::ReadElements();
        // Duplicate check
        foreach ($content as $element)
        {
            if (strtolower($el->name) == strtolower($element->name) && $element->listed)
                die("warning: item already listed");
        }
        array_unshift($content, $el);
        $jsonstring = json_encode($content, JSON_PRETTY_PRINT);
        $myfile = fopen(MYLIST, "w") or die("error opening file");
        if (!fwrite($myfile, $jsonstring))
            die("error writing file");
        fclose($myfile);
    }

    public static function WriteAll(string $jsonstring): void
    {
        /* 
        Decoding and re-encoding json string for 2 reasons:
            1 - data validation;
            2 - prettify json.
        */
        $myarray = json_decode($jsonstring);
        if (!is_array($myarray))
            die("error: array expected");
        $content = Element::ToElementArray($myarray);
        $jsonpretty = json_encode($content, JSON_PRETTY_PRINT);
        $myfile = fopen(MYLIST, "w") or die("error opening file");
        if (!fwrite($myfile, $jsonpretty))
            die("error writing file");
        fclose($myfile);
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
