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

    function importXml($doc, &$db)
    {
        $xml = new domDocument('1.0','windows-1251');
        $xml->load('2.xml');
        $root = $xml->documentElement;
        $products = $root->childNodes;
        for ($i=1; $i < $products->length; $i+=2)
        {
            $product = $products->item($i);
            $pcode = $product->getAttribute('Код'); //for base
            $pname = $product->getAttribute('Название'); //for base
            $params = $product->childNodes;
            if ($params->item(1)->getAttribute('Тип') == 'Базовая')
                $basePrice = $params->item(1)->nodeValue; //for base
            else
                throw new Exception('Неправильная структура документа в узле: Товар->Цена, код: '.$pcode);
            if ($params->item(3)->getAttribute('Тип') == 'Москва')
                $mosPrice = $params->item(3)->nodeValue; //for base
            else
                throw new Exception('Неправильная структура документа в узле: Товар->Цена, код: '.$pcode);

            if ($params->item(5)->tagName == 'Свойства')
                $properties = $params->item(5)->childNodes;
            else
                throw new Exception('Неправильная структура документа в узле: Товар->Свойства, код: '.$pcode);
            $arrPropertiesTag = array();
            $arrProperties = array();
            for ($ii = 1; $ii < $properties->length; $ii+=2)
            {
                $property = $properties->item($ii);
                $arrPropertiesTag[] = $property->tagName;
                $arrProperties[] = $property->nodeValue; //for base
                //$arrProperties[] = [$property->attributes->item(0)->name => $property->attributes->item(0)->value];
            }
            if ($params->item(7)->tagName == 'Разделы')
                $categories = $params->item(7)->childNodes;
            else
                throw new Exception('Неправильная структура документа в узле: Товар->Разделы, код: '.$pcode);
            $arrCategories = array();
            for ($j = 1; $j < $categories->length; $j+=2)
            {
                $category = $categories->item($j);
                $arrCategories[] = $category->nodeValue; //for base
            }

            $qProduct = 'insert into a_product (code,name) '.
                         'values ('.$pcode.', \''.$pname.'\');';
            //запрос в базу
            $result = mysqli_query($db,$qProduct) or die ('Ошибка '. mysqli_error($db));
            if ($result) printf('Добавление в a_product успешно');

            $arrPricet = ['Базовая', 'Москва'];
            $arrPrice = [$basePrice, $mosPrice];
            $jj = 0;
            foreach ($arrPrice as $value)
            {
                $qPrice = 'insert into a_price (name, tprice, price) '.
                            'values (\''.$pname.'\', \''.$arrPricet[$jj].'\', '.$value.');';
                //запрос в базу
                $result = mysqli_query($db,$qPrice) or die ('Ошибка '. mysqli_error($db));
                if ($result) printf('Добавление в a_price успешно');
                $jj++;
            }

            $nn = 0;
            foreach ($arrProperties as $value)
            {
                $qProperty = 'insert into a_property (name, type, property) '.
                                'values (\''.$pname.'\', \''.$arrPropertiesTag[$nn].'\', \''.$value.'\');';
                //запрос в базу
                $result = mysqli_query($db,$qProperty) or die ('Ошибка '. mysqli_error($db));
                if ($result) printf('Добавление в a_property успешно');
                $nn++;
            }

            foreach ($arrCategories as $value)
            {
                $qCategory = 'insert into a_category (code, category) '.
                                'values ('.$pcode.', \''.$value.'\');';
                //запрос в базу
                $result = mysqli_query($db,$qCategory) or die ('Ошибка '. mysqli_error($db));
                if ($result) printf('Добавление в a_category успешно');
            }
            $qRubricator = 'call sel_sp_rubricator('.$pcode.');';
            $result = mysqli_query($db,$qRubricator) or die ('Ошибка '. mysqli_error($db));
            if ($result) printf('Работа рубрикатора успешна.');

        }

    }
?>
