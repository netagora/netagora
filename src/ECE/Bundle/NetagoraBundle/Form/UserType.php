<?php

namespace ECE\Bundle\NetagoraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username', null, array('required' => true, 'label'=>'Pseudo'))
            ->add('email', 'email')
            ->add('password', null, array('required' => true, 'label'=>'Password'))
            ->add('file', 'file', array('required' => false, 'label'=>'Upload your photo'))
            ->add('location', null, array('required' => false))
            ->add('firstName', null, array('required' => true))
            ->add('lastName', null, array('required' => true))
            ->add('birthdate', 'birthday', array(
                'required' => false, 
                'label' => 'Birthdate', 
                'years' => range(date('Y') - 90, date('Y')),
                'empty_value' => ''
            ))
        ;
    }

    public function getName()
    {
        return 'user';
    }
}
