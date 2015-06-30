<?php

namespace Devspark\VentureJuiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmailMessageType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject')
            ->add('body', 'textarea', array(
                'attr' => array(
                    'class' => 'tinymce',
                    'data-theme' => 'personalized' // Skip it if you want to use default theme
                )))
            ->add('company', 'entity', array(
                'empty_value' => 'All',
                'class' => 'DevsparkVentureJuiceBundle:Company',
                'property' => 'name',
                'required' => false,
            ))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Devspark\VentureJuiceBundle\Entity\EmailMessage'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'devspark_venturejuicebundle_emailmessage';
    }
}
