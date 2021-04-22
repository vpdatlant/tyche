<?php
    function convertString (&$a, $b)
    {
        $lenght = strlen($b);
        $var = 0;
        $i = 0;
        while (!is_bool($var))
        {
            $var = strpos($a, $b, $i);
            if (!is_bool($var)) $positionArray[] = $var;
            $i = $var + $lenght;
        }
        //echo var_dump($positionArray);
        if (count($positionArray) >= 2) {
            $a = substr_replace($a, strrev($b),$positionArray[1],$lenght);
        }
    }

    $skey = ''; //Глобальная переменная только для функции mySortForKey
    function mySortForKey(&$a, $b)
    {
        function cmp_function($a, $b){
            return ($a[$GLOBALS['skey']] > $b[$GLOBALS['skey']]);
        }
        $GLOBALS['skey'] = $b;
        foreach ($a as $key => $value)
        {
            if (!key_exists($b,$value)) throw new Exception($key);
        }
        uasort($a, 'cmp_function');
    }
?>
