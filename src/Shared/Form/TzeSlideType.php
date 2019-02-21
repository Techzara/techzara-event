<?php

namespace App\Shared\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Shared\Entity\TzeSlide;

class TzeSlideType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sldEventDescription',TextareaType::class,array(
                'label' => 'Event description',
                'required'  => false
            ))

            ->add('sldEventTitle',TextType::class,array(
                'label'=>'Title',
                'required'=>false
            ))

            ->add('sldIntervenant',TextType::class,array(
                'label' => 'Intervenant',
                'required' => false
            ))

            ->add('sldLocation',TextType::class,array(
                'label' => 'Location',
                'required'=> false
            ))

            ->add('sldPlace',TextType::class,array(
                'label' => 'Nombre des participants',
                'required' => false
            ))

            ->add('sldDate',DateTimeType::class,array(
                'label'    => 'Date début du programme',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy H:m',
                'attr'   => array(
                    'class'         => 'datetimepicker',
                    'required'      => true,
                    'autocomplete'  => 'off'
                )
            ))

            ->add('sldDateFin',DateTimeType::class,array(
                'label'    => 'Date fin du programme',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy H:m',
                'attr'   => array(
                    'class'         => 'datetimepicker',
                    'required'      => true,
                    'autocomplete'  => 'off'
                )
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
            'data_class' => TzeSlide::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tze_service_metiermanagerbundle_slide';
    }
}
