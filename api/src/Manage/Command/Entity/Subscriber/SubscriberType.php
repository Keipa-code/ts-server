<?php

declare(strict_types=1);


namespace App\Manage\Command\Entity\Subscriber;


class SubscriberType
{


    private string $value;
    private string $private = 'private';
    private string $juridical = 'juridical';

    public function __construct(string $value)
    {
        if ($value == $this->private) {
            $this->value = $value;
        }elseif ($value == $this->juridical) {
            $this->value = $value;
        }else{
            throw new \InvalidArgumentException('Invalid subscriber type');
        }
    }


    public function getValue(): string
    {
        return $this->value;
    }

    public function isPrivate(): bool
    {
        if($this->value === $this->private){
            return true;
        }
        return false;
    }

    public function isJuridical(): bool
    {
        if($this->value === $this->juridical){
            return true;
        }
        return false;
    }
}