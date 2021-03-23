<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

interface Baur
{
    public function __construct($value);

    public function getValue();
}

class Fooka implements Baur
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue(){
        return $this->value;
    }

    public function setLower($value)
    {
        return mb_strtolower($value);
    }
}

$fooka = new Fooka('priva');
/** @return string
 * @var Baur $baur
 */
$value2 = function (Baur $baur){
    return $baur->getValue();
};

echo $value2($fooka);