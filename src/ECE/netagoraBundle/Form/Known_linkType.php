<?php

namespace ECE\netagoraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Known_linkType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('category')
            ->add('title_head')
            ->add('h1')
            ->add('h2')
            ->add('tags')
            ->add('main_url')
            ->add('keywords')
        ;
    }

    public function getName()
    {
        return 'ece_netagorabundle_known_linktype';
    }
}
