<?php

namespace ECE\Bundle\NetagoraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AggboxType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('type', 'choice', array(
                'choices'   => array('dev' => 'developper idea', 'user' => 'user idea'),
                'required'  => true))
            ->add('content', 'textarea', array('label' => 'Explain your idea', 'required'  => true))
        ;
    }

    public function getName()
    {
        return 'aggbox';
    }
}
