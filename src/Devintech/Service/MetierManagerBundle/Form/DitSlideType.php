<?php

namespace App\Devintech\Service\MetierManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DitSlideType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sldFirstTitle', TextType::class, array(
                'label'    => "Première titre",
                'required' => true
            ))

            ->add('sldSecondTitle', TextType::class, array(
                'label'    => "Seconde titre",
                'required' => true
            ))

            ->add('sldThirdTitle', TextType::class, array(
                'label'    => "Troisième titre",
                'required' => true
            ))

            ->add('sldImageUrl', FileType::class, array(
                'label'    => 'Image (recommandé 1599 x 816)',
                'mapped'   => false,
                'attr'     => array('accept' => 'image/*'),
                'required' => false
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Devintech\Service\MetierManagerBundle\Entity\DitSlide'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dit_service_metiermanagerbundle_slide';
    }
}
