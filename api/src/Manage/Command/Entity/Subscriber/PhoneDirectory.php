<?php

declare(strict_types=1);

namespace App\Manage\Command\Entity\Subscriber;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="phone_dircetory", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"phonenumber_number"})
 * })
 */
class PhoneDirectory
{
    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     */
    private string $id;
    /**
     * @ORM\Embedded(class="Phonenumber")
     */
    private Phonenumber $phonenumber;
    /**
     * @var ?PrivateSubscriber
     * @ORM\ManyToOne(targetEntity="PrivateSubscriber", inversedBy="phonenumbers")
     * @ORM\JoinColumn(name="private_subscriber_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private ?PrivateSubscriber $privateSubscriber;
    /**
     * @var ?JuridicalSubscriber
     * @ORM\ManyToOne(targetEntity="JuridicalSubscriber", inversedBy="phonenumbers")
     * @ORM\JoinColumn(name="juridical_subscriber_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private ?JuridicalSubscriber $juridicalSubscriber;


    public function __construct(
        ?PrivateSubscriber $privateSubscriber,
        ?JuridicalSubscriber $juridicalSubscriber,
        Phonenumber $number
    ) {
        $this->id = Uuid::uuid4()->toString();
        $this->privateSubscriber = $privateSubscriber;
        $this->juridicalSubscriber = $juridicalSubscriber;
        $this->phonenumber = $number;
    }

    public function getPhonenumber(): Phonenumber
    {
        return $this->phonenumber;
    }
}
