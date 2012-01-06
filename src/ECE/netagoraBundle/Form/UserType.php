<?php

namespace ECE\netagoraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password')
            ->add('mail')
            ->add('inscription_date')
            ->add('img')
            ->add('age')
            ->add('location')
            ->add('last_connection')
        ;
    }

    public function getName()
    {
        return 'ece_netagorabundle_usertype';
    }
}
