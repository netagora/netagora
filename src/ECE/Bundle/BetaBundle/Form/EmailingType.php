<?php

namespace ECE\Bundle\BetaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EmailingType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('email', 'email');
    }

    public function getName()
    {
        return 'emailing';
    }
}
