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

    public static function Add(string $name): array
    {
        $content = self::ReadElements();
        $exist = Filer::Find($content, $name);
        // Duplicate check
        if ($exist)
        {
            if ($exist->listed)
                throw new Exception("warning: item already listed");
            else
                return self::Shift($name, false);
        }
        $el = new stdClass;
        $el->name = $name;
        $el->listed = true;
        array_unshift($content, $el);
        return Filer::WriteAll($content);
    }

    /* Buy an item ($buy = true) or resume it from backup list ($buy = false) */
    public static function Shift(string $name, bool $buy): array
    {
        $content = self::ReadElements();
        // Duplicate check
        $element = Filer::Find($content, $name);
        if ($element->listed == $buy)
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

    public static function Remove(string $name): array
    {
        $content = self::ReadElements();
        $element = Filer::Find($content, $name);
        if ($element !== null && !$element->listed)
        {
            $i = array_search($element, $content);
            array_splice($content, $i, 1);
            return Filer::WriteAll($content);
        }
        else
            throw new Exception("error: item not found");
    }

    public static function Find(array $content, string $name): ?Object
    {
        foreach ($content as $element)
        {
            if (strtolower($name) == strtolower($element->name))
                return $element;
        }
        return null;
    }

    public static function WriteAll($myarray): array
    {
        if (!is_array($myarray))
            throw new Exception("error: array expected");
        Filer::WriteAllJson(json_encode($myarray));
        return $myarray;
    }

    public static function WriteAllJson(string $jsonstring)
    {
        $myfile = fopen(MYLIST, "w") or die("error opening file");
        if (!fwrite($myfile, $jsonstring))
            throw new Exception("error writing file");
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

class Response
{
    public $error = NULL;
    public $response = NULL;
    public function toJSON()
    {
        return json_encode($this);
    }
}

class SetRequestHandler
{
    public static function CheckAndReply($post, $action)
    {
        $res = new Response;
        header('Content-Type: application/json; charset=utf-8');

        if($post)
        {
            if (isset($post['name']))
            {
                $name = $post['name'];
                if ($name == "")
                    $res->error = "error: empty item name";
            }
            else
                $res->error = "error: missing parameter: name";
        }

        if (!$res->error)
        {
            try
            {
                switch ($action)
                {
                    case 'add':
                        $res->response = Filer::Add(trim($name));
                        break;
                    case 'buy':
                        $res->response = Filer::Shift($name, true);
                        break;
                    case 'del':
                        $res->response = Filer::Remove($name);
                        break;
                    case 'get':
                        $res->response = Filer::ReadElements();
                        break;
                }
            }
            catch (Exception $ex)
            {
                $res->error = $ex->getMessage();
            }
        }

        echo $res->toJSON();
    }
}
