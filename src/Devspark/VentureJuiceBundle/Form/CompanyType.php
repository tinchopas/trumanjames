<?php

namespace Devspark\VentureJuiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompanyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active')
            ->add('name')
            ->add('displayOrder')
            ->add('link')
            ->add('title')
            ->add('text', 'textarea', array(
                'attr' => array(
                    'class' => 'tinymce',
                    'data-theme' => 'personalized' // Skip it if you want to use default theme
                )))
            ->add('email')
            ->add('file', 'file', array(
                'label' => 'Logo','required' => false))
            ->add('logo', 'hidden')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Devspark\VentureJuiceBundle\Entity\Company'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'devspark_venturejuicebundle_company';
    }
}
