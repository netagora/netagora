<?php

namespace ECE\netagoraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FavorisType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('publication')
        ;
    }

    public function getName()
    {
        return 'ece_netagorabundle_favoristype';
    }
}
