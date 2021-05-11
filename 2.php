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

    function mySortForKey(&$a, $b)
    {
        foreach ($a as $key => $value)
        {
            if (!key_exists($b,$value)) throw new Exception($key);
        }
        function cmp($key)
        {
            return function ($a, $b) use ($key)
            {
                return ($a[$key] > $b[$key]);
            };
        }
        uasort($a, cmp($b));
    }

    //PDO. Подготовленные запросы, есть входные параметры в скрипт через xml документ
    function importXml($doc, &$db)
    {
        $qProduct    = $db->prepare("insert into a_product (code,name) values (:pcode,:pname)");
        $qPrice      = $db->prepare("insert into a_price (name, tprice, price) values (:pname,:pricet,:price)");
        $qProperty   = $db->prepare("insert into a_property (name, type, property) values (:pname,:type,:property)");
        $qCategory   = $db->prepare("insert into a_category (code, category) values (:code,:category)");
        $qRubricator = $db->prepare("call sel_sp_rubricator(:pcode);");

        $xml = new domDocument('1.0','windows-1251');
        $xml->load($doc);
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

            $qProduct->bindParam(':pcode', $pcode);
            $qProduct->bindParam(':pname', $pname);
            if ($qProduct->execute()) printf('Добавление в a_product успешно');
            else throw new Exception('Ошибка вставки в базу a_product');

            $arrPricet = ['Базовая', 'Москва'];
            $arrPrice = [$basePrice, $mosPrice];
            $jj = 0;
            foreach ($arrPrice as $value)
            {
                $qPrice->bindParam(':pname', $pname);
                $qPrice->bindParam(':pricet', $arrPricet[$jj]);
                $qPrice->bindParam(':price', $value);
                if ($qPrice->execute()) printf('Добавление в a_price успешно');
                else throw new Exception('Ошибка вставки в базу a_price');
                $jj++;
            }

            $nn = 0;
            foreach ($arrProperties as $value)
            {
                $qProperty->bindParam(':pname',$pname);
                $qProperty->bindParam(':type',$arrPropertiesTag[$nn]);
                $qProperty->bindParam(':property', $value);
                if ($qProperty->execute()) printf('Добавление в a_property успешно');
                else throw new Exception('Ошибка вставки в базу a_property');
                $nn++;
            }

            foreach ($arrCategories as $value)
            {
                $qCategory->bindParam(':code',$pcode);
                $qCategory->bindParam(':category',$value);
                if ($qCategory->execute()) printf('Добавление в a_category успешно');
                else throw new Exception('Ошибка вставки в базу a_category');

            }

            $qRubricator->bindParam(':pcode',$pcode);
            if ($qRubricator->execute()) printf('Выполнение рубрикатора успешно');
            else throw new Exception('Ошибка выполнения рубрикатора');
        }

    }

    function exportXML(&$db, $outFileName)
    {
        $qa_product  = $db->prepare('SELECT code,name FROM a_product;');
        $qa_price    = $db->prepare('SELECT price,tprice FROM a_price WHERE name=:name ORDER BY id;');
        $qa_property = $db->prepare('SELECT type,property FROM a_property WHERE name=:name ORDER BY id;');
        $qa_category = $db->prepare('SELECT code, category FROM a_category WHERE code=:code ORDER BY id;');

        $xml = new domDocument("1.0", "windows-1251");
        $xml->formatOutput=true;
        $root = $xml->createElement("Товары");
        $xml->appendChild($root);
        if (!$qa_product->execute()) throw new Exception('Ошибка получения данных из таблицы a_product');
        for ($i = 0; $i < $qa_product->rowCount(); $i++)
        {
            $qa_product_row = $qa_product->fetch();
            $product = $xml->createElement("Товар");
            $product->setAttribute("Код", $qa_product_row[0]);
            $product->setAttribute("Название", $qa_product_row[1]);

            $qa_price->bindParam(':name',$qa_product_row[1]);
            if (!$qa_price->execute()) throw new Exception('Ошибка получения данных из таблицы a_price');
            for ($j = 0; $j < 2; $j++)
            {
                $qa_price_row = $qa_price->fetch();
                $price = $xml->createElement("Цена", $qa_price_row[0]);
                $price->setAttribute("Тип", $qa_price_row[1]);
                $product->appendChild($price);
            }

            $qa_property->bindParam(':name',$qa_product_row[1]);
            if (!$qa_property->execute()) throw new Exception('Ошибка получения данных из таблицы a_property');
            $propertys = $xml->createElement('Свойства');
            for ($j = 0; $j < $qa_property->rowCount(); $j++)
            {
                $qa_property_row = $qa_property->fetch();
                $property = $xml->createElement($qa_property_row[0], $qa_property_row[1]);
                if ($qa_property_row[0] == 'Белизна')
                    $property->setAttribute('ЕдИзм','%');
                $propertys->appendChild($property);
            }

            $qa_category->bindParam(':code',$qa_product_row[0]);
            if (!$qa_category->execute()) throw new Exception('Ошибка получения данных из таблицы a_category');
            $categorys = $xml->createElement('Разделы');
            for ($j = 0; $j < $qa_category->rowCount(); $j++)
            {
                $qa_category_row = $qa_category->fetch();
                $category = $xml->createElement('Раздел',$qa_category_row[1]);
                $categorys->appendChild($category);
            }

            $product->appendChild($propertys);
            $product->appendChild($categorys);
            $root->appendChild($product);
        }
        $xml->save($outFileName);
    }
?>
