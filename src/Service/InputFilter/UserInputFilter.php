<?php

namespace Casino\Service\InputFilter;

use Laminas\InputFilter\Input;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\EmailAddress;

class UserInputFilter extends InputFilter
{
    public function __construct()
    {
        $email  = (new Input('email'))->setRequired(true);
        $password = (new Input('password'))->setRequired(true);
        $email->getValidatorChain()->attach(new EmailAddress());

        $this->add($email);
        $this->add($password);
    }
}
