<?php
    function findSimple($a, $b) : array
    {
        $arrSimple = array();
            if ($a > $b) {
                throw new Exception('The value "a" must be less than "b". ');
            }
            if ($a <= 0 or $b <= 0)
                throw new Exception('Input parameters must be greater than zero.');
        for ($i=$a; $i<=$b; $i++){
            if ($i == 2) $arrSimple[] = $i;
            if ($i % 2 == 0) continue;
            $ii = 3;
            $sqrtNum = (int)sqrt($i);
            $isNotPrime = true;
            while ($ii <= $sqrtNum){
                if (($i % $ii) == 0) {
                    $isNotPrime = false;
                    break;
                }
                $ii+=2;
            }
            if ($isNotPrime) {
                $arrSimple[] = $i;
            }
        }
        //var_dump($arrSimple);
        return $arrSimple; //array[]
    }

    function createTrapeze($a) : array
    {
        if (count($a) % 3 != 0)
            throw new Exception("The number of array elements must be a multiple of three ");

        $trapezeArr = array_chunk($a, 3);
        $abc = ['a', 'b', 'c'];
        foreach ($trapezeArr as $key => $value){
            unset($trapezeArr[$key]);
            $trapezeArr[$key] = array_combine($abc,$value);
        }

        //var_dump($trapezeArr);
        return $trapezeArr; //array[][]
    }

    function squareTrapeze(&$a)
    {
        foreach ($a as $key => $value){
            $a[strval(($value['a'] + $value['b'])*.5*$value['c'])] = $value;
            unset($a[$key]);

            //var_dump($value);
            //echo '<br>';
        }
        //var_dump($squareTrapezeArr);
    }

    function getSizeForLimit($a, $b)
    {
        $tempKey = 0;
        ksort($a);
        foreach ($a as $key => $value){
            if ($key <= $b) $tempKey = $key; else break;
        }
        //var_dump($maxSquareSizes);
        // echo '<br>';
        // var_dump($a);
        return $a[$tempKey]; //array[]
    }

    function getMin($a)
    {
        $minValue = current($a);
        foreach ($a as $value){
            if ($value < $minValue) $minValue = $value;
        }
        return $minValue; //float or int
    }

    function printTrapeze($a)
    {
        $ink = 1;
        foreach ($a as $key => $value)
        {
            if ((round($key) % 2) != 0) echo '<tr bgcolor="gray">', PHP_EOL; else echo '<tr>', PHP_EOL;
            echo '<td>', $ink, '</td>', PHP_EOL,
                 '<td>', $value['a'], '</td>', PHP_EOL,
                 '<td>', $value['b'], '</td>', PHP_EOL,
                 '<td>', $value['c'], '</td>', PHP_EOL,
                 '<td>', $key, '</td>', PHP_EOL,
                 '</tr>', PHP_EOL;
            $ink++;
        }
    }

    abstract class BaseMath 
    {
        public function exp1($a, $b, $c) : float
        {
            return $a * (pow($b, $c));
        }
        public function exp2($a, $b, $c) : float
        {
            return pow(($a / $b), $c);
        }
        abstract public function getValue();
    }

    class F1 extends BaseMath 
    {
        private float $a;
        private float $b;
        private float $c;
        private float $result;
        
        function __construct(float $a = 0, float $b = 0, float $c = 0)
        {
            $this->a = $a;
            $this->b = $b;
            $this->c = $c;
        }

        private function computResult () {
            $this->result = ($this->exp1($this->a, $this->b, $this->c) +
                            pow((($this->exp2($this->a, $this->b, $this->c)) % 3),
                            min($this->a, $this->b, $this->c)));
        }

        public function getValue() : float
        {
            $this->computResult();
            return $this->result;
        }

        public function getValueA() : float
        {
            return $this->a;
        }

        public function getValueB() :float
        {
            return $this->b;
        }

        public function getValueC() : float
        {
            return $this->c;
        }

        public function setValueA($temp)
        {
            $this->a = $temp;
        }

        public function setValueB($temp)
        {
            $this->b = $temp;
        }

        public function setValueC($temp)
        {
            $this->c = $temp;
        }
    }
?>

