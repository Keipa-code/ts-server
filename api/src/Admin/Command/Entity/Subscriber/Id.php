<?php

declare(strict_types=1);


namespace App\Admin\Command\Entity\Subscriber;


use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

class Id
{
    private $value;

    public function __construct(string $value)
    {
        Assert::uuid($value);
        $this->value = mb_strtolower($value);
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function getValue()
    {
        return $this->value;
    }
}