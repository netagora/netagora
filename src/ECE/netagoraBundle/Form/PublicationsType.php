<?php

namespace ECE\netagoraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PublicationsType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('user')
            ->add('known_link')
            ->add('network')
            ->add('author')
            ->add('date_published')
            ->add('publication_ref')
            ->add('content')
            ->add('link_url')
        ;
    }

    public function getName()
    {
        return 'ece_netagorabundle_publicationstype';
    }
}
