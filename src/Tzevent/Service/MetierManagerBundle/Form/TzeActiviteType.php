<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 2/15/19
 * Time: 4:41 PM
 */

namespace App\Tzevent\Service\MetierManagerBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TzeActiviteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('actTitle',TextType::class,array(
                'label' => 'Title of activities',
                'required' => false
            ))

            ->add('actDescription',TextareaType::class,array(
                'label' => 'Title of activities',
                'required' => false
            ))

            ->add('actEvent',EntityType::class,array(
                'class'         =>'App\Tzevent\Service\MetierManagerBundle\Entity\TzeSlide',
                'choice_label'  =>'sld_event_title',
                'multiple'      => false,
                'expanded'      => false,
                'required'      => true
            ))

            ->add('actDebut',DateTimeType::class,array(
                'label'    => 'Date début du programme',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy H:m',
                'attr'   => array(
                    'class'         => 'datetimepicker',
                    'required'      => true,
                    'autocomplete'  => 'off'
                )
            ))

            ->add('actFin',DateTimeType::class,array(
                'label'    => 'Date fin du programme',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy H:m',
                'attr'   => array(
                    'class'         => 'datetimepicker',
                    'required'      => true,
                    'autocomplete'  => 'off'
                )
            ))

            ->add('actImage', FileType::class, array(
                'label'    => 'Image (recommandé 1599 x 816)',
                'mapped'   => false,
                'attr'     => array('accept' => 'image/*'),
                'required' => false
            ))

        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Tzevent\Service\MetierManagerBundle\Entity\TzeEvenementActivite'
        ));
    }

    /**
     * @return string|null
     */
    public function getBlockPrefix()
    {
        return 'tze_service_metiermanagerbundle_tze_activite';
    }
}