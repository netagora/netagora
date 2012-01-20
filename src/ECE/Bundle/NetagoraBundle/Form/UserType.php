<?php

namespace ECE\Bundle\NetagoraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('email', 'email')
            ->add('username', 'text', array('label' => 'Pseudo'))
            ->add('password', 'repeated', array(
                'required'     => true,
                'type'         => 'password',
                'first_name'   => 'Password',
                'second_name'  => 'Confirmation',
            ))
            ->add('firstName', 'text', array(
                'required' => true,
                'label' => 'First name'
            ))
            ->add('lastName', 'text', array(
                'required' => true,
                'label' => 'Last name',
            ))
            ->add('birthdate', 'birthday', array(
                'required' => false, 
                'label' => 'Birthdate', 
                'years' => range(date('Y') - 90, date('Y')),
                'empty_value' => ''
            ))
            ->add('location', 'text', array('required' => false))
            ->add('file', 'file', array(
                'required' => false,
                'label'=>'Photo'
            ))
        ;
    }

    public function getName()
    {
        return 'user';
    }
}
