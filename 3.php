<?php
namespace Test3;

use Exception;

class newBase
{
    static private $count = 0;
    static private $arSetName = [];
//    /**
//     * @param string $name
//     */
    /**
     * @param int $name
     */
    function __construct(int $name = 0)
    {
        if (empty($name)) {
            while (array_search(self::$count, self::$arSetName) != false) {
                ++self::$count;
            }
            $name = self::$count;
        }
        $this->name = $name;
        self::$arSetName[] = $this->name;
    }
//    private $name;
    protected $name;
    /**
     * @return string
     */
    public function getName(): string
    {
        return '*' . $this->name  . '*';
    }
    protected $value;
    /**
     * @param mixed $value
     * @returne NewBase
     */
    public function setValue($value): newBase
    {
        $this->value = $value;
        return $this;
    }
    /**
     * @return string
//     * @return int
     */
    public function getSize() : string
    {
//        $size = strlen(serialize($this->value));
//        return strlen($size) + $size;
        return strlen(serialize($this->value));
    }
    public function __sleep()
    {
        return ['value'];
    }
    /**
     * @return string
     */
    public function getSave(): string
    {
//        $value = serialize($value);
//        return $this->name . ':' . sizeof($value) . ':' . $value;
        $value = serialize($this->value);
        return $this->name . ':' . strlen($value) . ':' . $value;
    }

    /**
     * @param string $value
     * @return newBase
     */
    static public function load(string $value): newBase
    {
        $arValue = explode(':', $value);
        return (new newBase($arValue[0]))->setValue(unserialize(substr($value, strlen($arValue[0]) + 1
            + strlen($arValue[1]) + 1, $arValue[1])));
    }
}
class newView extends newBase
{
    private $type = null;
    private $size = 0;
    private $property = null;
    /**
     * @param mixed $value
     * @return newBase
     */
    public function setValue($value) : newBase
    {
        parent::setValue($value);
        $this->setType();
        $this->setSize();
        return $this;
    }
    public function setProperty($value): newView
    {
        $this->property = $value;
        return $this;
    }
    private function setType()
    {
        $this->type = gettype($this->value);
    }
    private function setSize()
    {
        if (is_subclass_of($this->value, "Test3\\newView")) {
            $this->size = (int)parent::getSize() + 1 + strlen($this->property);
        } elseif ($this->type == 'test') {
            $this->size = parent::getSize();
        } else {
            $this->size = strlen($this->value);
        }
    }
    /**
     * @return string[]
     */
    public function __sleep()
    {
        return ['property'];
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getName(): string
    {
        if (empty($this->name)) {
            throw new Exception('The object doesn\'t have name');
        }
        return '"' . $this->name  . '": ';
    }
    /**
     * @return string
     */
    public function getType(): string
    {
        return ' type ' . $this->type  . ';';
    }
    /**
     * @return string
     */
    public function getSize(): string
    {
        return ' size ' . $this->size . ';';
    }
    public function getInfo()
    {
        try {
            echo $this->getName()
                . $this->getType()
                . $this->getSize()
                . "\r\n";
        } catch (Exception $exc) {
            echo 'Error: ' . $exc->getMessage();
        }
    }
    /**
     * @return string
     */
    public function getSave(): string
    {
//        if ($this->type == 'test') {
//            $this->value = $this->value->getSave();
//        }
        if ($this->type == 'test' and is_object($this->value)) {
            $this->value = $this->value->getSave();
        }
        return parent::getSave() . serialize($this->property);
    }
    /**
     * @return newView
     */
    static public function load(string $value): newBase
    {
        $arValue = explode(':', $value);
        return (new newView($arValue[0]))
            ->setValue(unserialize(substr($value, strlen($arValue[0]) + 1 + strlen($arValue[1]) + 1, $arValue[1])))
            ->setProperty(unserialize(substr($value, strlen($arValue[0]) + 1
                + strlen($arValue[1]) + 1 + $arValue[1])));
    }
}
function gettype($value): string
{
    if (is_object($value)) {
        $type = get_class($value);
        do {
            if (strpos($type, "Test3\\newBase") !== false) {
                return 'test';
            }
        } while ($type = get_parent_class($type));
    }
    return \gettype($value);
}


$obj = new newBase('12345');
$obj->setValue('text');

$obj2 = new newView('09876');
$obj2->setValue($obj);
$obj2->setProperty('field');
$obj2->getInfo();

$save = $obj2->getSave();

$obj3 = newView::load($save);

$obj4 = newBase::load($obj->getSave());

echo $obj->getSave().PHP_EOL;
echo $obj4->getSave().PHP_EOL;

echo $obj2->getSave().PHP_EOL;
echo $obj3->getSave().PHP_EOL;

var_dump($obj2->getSave() == $obj3->getSave());

