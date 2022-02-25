<?php

const MYLIST = "list.json";


class Element
{
    public $name = "";
    public $listed = true;

    public function set($data)
    {
        /* this conversion also validates data format */
        if (isset($data->name) && isset($data->listed))
        {
            if($data->name == "")
                die("error one name is empty");
            $this->name = $data->name;
            $this->listed = $data->listed;
        }
        else
            die("error: wrong element format");
        // foreach ($data as $key => $value) $this->{$key} = $value;
    }

    public static function ToElementArray(array $content)
    {
        $retarray = array();
        foreach ($content as $value)
        {
            $el = new Element();
            $el->set($value);
            array_push($retarray, $el);
        }
        return $retarray;
    }
}


class Filer
{
    private static function CheckFile()
    {
        $myfile = fopen(MYLIST, "r");
        if (!$myfile)
        {
            $myfile = fopen(MYLIST, "x") or die("error creating file");
        }
        fclose($myfile);
    }

    public static function ReadJson()
    {
        self::CheckFile();
        $contentJSON = file_get_contents(MYLIST);
        return $contentJSON;
    }

    public static function ReadElements()
    {
        $content = json_decode(self::ReadJson());
        return Element::ToElementArray($content);
    }

    public static function Add(Element $el)
    {
        $content = self::ReadElements();
        array_unshift($content, $el);
        $jsonstring = json_encode($content, JSON_PRETTY_PRINT);
        $myfile = fopen(MYLIST, "w") or die("error opening file");
        if (!fwrite($myfile, $jsonstring))
            die("error writing file");
        fclose($myfile);
    }

    public static function WriteAll(string $jsonstring)
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
