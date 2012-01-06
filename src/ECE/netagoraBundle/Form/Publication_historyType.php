<?php

namespace ECE\netagoraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Publication_historyType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('publication')
            ->add('old_cat')
            ->add('current_cat')
            ->add('change_date')
        ;
    }

    public function getName()
    {
        return 'ece_netagorabundle_publication_historytype';
    }
}
