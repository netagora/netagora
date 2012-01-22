<?php

namespace ECE\Bundle\NetagoraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('password', 'repeated', array(
                'type'         => 'password',
                'first_name'   => 'Password',
                'second_name'  => 'Confirmation',
            ))
        ;
    }

    public function getName()
    {
        return 'reset_password';
    }
}
