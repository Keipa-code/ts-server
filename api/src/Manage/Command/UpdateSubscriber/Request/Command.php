<?php

declare(strict_types=1);

namespace App\Manage\Command\UpdateSubscriber\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=20, max=40)
     */
    public string $id = '';
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=8, max=20, allowEmptyString=true)
     * @Assert\Regex(pattern="/[0-9\s\-()]{8,20}/")
     */
    public string $phoneNumber = '';
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=11, allowEmptyString=true)
     * @Assert\Choice({"private", "juridical"}, message="Wrong value in type.")
     */
    public string $subscriberType = '';
    /**
     * @Assert\All({@Assert\NotBlank(), @Assert\Length(max=50, allowEmptyString=true)})
     */
    public array $subData = [];

    public function writeData($data): void
    {
        $this->id = ($data['id'] ?? '');
        $this->phoneNumber = ($data['phonenumber'] ?? '');
        $this->subscriberType = ($data['type'] ?? '');
        // Частное лицо
        /**
         * @psalm-var array $this->subData
         */
        if ($this->subscriberType == 'private') {
            $this->subData['firstname'] = ($data['firstname'] ?? '');
            $this->subData['surname'] = ($data['surname'] ?? '');
            $this->subData['patronymic'] = ($data['patronymic'] ?? '');
        } elseif ($this->subscriberType == 'juridical') {
            $this->subData['organizationName'] = ($data['organizationName'] ?? '');
            $this->subData['departmentName'] = ($data['departmentName'] ?? '');
            $this->subData['country'] = ($data['country'] ?? '');
            $this->subData['city'] = ($data['city'] ?? '');
            $this->subData['street'] = ($data['street'] ?? '');
            $this->subData['houseNumber'] = ($data['houseNumber'] ?? '');
            if (($data['floatNumber'])) {
                $this->subData['floatNumber'] = ($data['floatNumber'] ?? '');
            }
        }
    }
}
