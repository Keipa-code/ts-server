<?php

declare(strict_types=1);

namespace App\Manage\Command\Entity\Subscriber;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Laminas\Stdlib\Exception\DomainException;

class SubscriberType
{

    private string $subscriberType;
    private string $private = 'private';
    private string $juridical = 'juridical';

    public function __construct(string $value)
    {
        if ($value == $this->private) {
            $this->subscriberType = $value;
        } elseif ($value == $this->juridical) {
            $this->subscriberType = $value;
        } else {
            throw new InvalidArgumentException('Invalid subscriber type' . $value);
        }
    }


    public function getSubscriberType(): string
    {
        return $this->subscriberType;
    }

    public function isPrivate(): bool
    {
        if ($this->subscriberType === $this->private) {
            return true;
        }
        return false;
    }

    public function isJuridical(): bool
    {
        if ($this->subscriberType === $this->juridical) {
            return true;
        }
        return false;
    }
}
