<?php

namespace ECE\netagoraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FbType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('user')
            ->add('token')
            ->add('fb_id')
        ;
    }

    public function getName()
    {
        return 'ece_netagorabundle_fbtype';
    }
}
