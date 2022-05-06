<?php

const MYLIST = "list.json";
const REQUIRECOOKIES = false;  // Set to true if you want to require registration
const COOKIENAME = "";         // Set cookie name if REQUIRECOOKIES = true
const COOKIEVALUE = "";        // Set cookie value if REQUIRECOOKIES = true



class Filer
{
    public static function ReadJson(): string
    {
        $contentJSON = file_get_contents(MYLIST);
        if (!$contentJSON)
        {
            if (!file_exists(MYLIST))
            {
                $myfile = fopen(MYLIST, "x");
                if (!$myfile) throw new Exception("error creating file");
                self::WriteAll([]);
                fclose($myfile);
                $contentJSON = [];
            }
            else
                throw new Exception("error reading file");
        }
        return $contentJSON;
    }

    public static function ReadElements(): array // of Element
    {
        $content = json_decode(self::ReadJson());
        if (!$content)
            throw new Exception("error malformed json");
        if (!is_array($content))
            throw new Exception("error bad data");
        return $content;
    }

    public static function Add(string $name): string
    {
        $content = self::ReadElements();
        // Duplicate check
        if (Filer::Find($content, $name))
            throw new Exception("warning: item already listed");
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
            throw new Exception("error: item not found");
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
            throw new Exception("error: item not found");
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
            throw new Exception("error: array expected");
        return Filer::WriteAllJson(json_encode($myarray));
    }

    public static function WriteAllJson(string $jsonstring): string
    {
        $myfile = fopen(MYLIST, "w") or die("error opening file");
        if (!fwrite($myfile, $jsonstring))
            throw new Exception("error writing file");
        fclose($myfile);
        return $jsonstring;
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

class Responder
{
    public $error = NULL;
    public $response = NULL;
    public function toJSON()
    {
        return json_encode($this);
    }
}
