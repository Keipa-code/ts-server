<?php

declare(strict_types=1);


namespace App\Manage\Command\Entity\Subscriber;


use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="phone_dircetory", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"phone_number_phone_number", "phone_number_subscriber_type"})
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
     * @ORM\Embedded(class="PhoneNumber")
     */
    private PhoneNumber $phoneNumber;
    /**
     * @var ?PrivateSubscriber
     * @ORM\ManyToOne(targetEntity="PrivateSubscriber", inversedBy="phoneNumbers")
     * @ORM\JoinColumn(name="private_subscriber_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private ?PrivateSubscriber $privateSubscriber;
    /**
     * @var ?JuridicalSubscriber
     * @ORM\ManyToOne(targetEntity="JuridicalSubscriber", inversedBy="phoneNumbers")
     * @ORM\JoinColumn(name="juridical_subscriber_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private ?JuridicalSubscriber $juridicalSubscriber;

    public function __construct(?PrivateSubscriber $privateSubscriber, ?JuridicalSubscriber $juridicalSubscriber, PhoneNumber $phoneNumber)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->privateSubscriber = $privateSubscriber;
        $this->juridicalSubscriber = $juridicalSubscriber;
        $this->phoneNumber = $phoneNumber;
    }

    public function getPhoneNumber(): PhoneNumber
    {
        return $this->phoneNumber;
    }
}