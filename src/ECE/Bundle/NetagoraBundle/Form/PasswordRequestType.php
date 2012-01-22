<?php

namespace ECE\Bundle\NetagoraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PasswordRequestType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username', 'text', array('label' => 'Your username'))
            ->add('email', 'email', array('label' => 'Your email'))
        ;
    }

    public function getName()
    {
        return 'password_request';
    }
}
