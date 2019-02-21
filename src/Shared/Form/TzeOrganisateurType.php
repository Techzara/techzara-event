<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 2/17/19
 * Time: 12:11 AM
 */

namespace App\Shared\Form;


use App\Shared\Entity\TzeOrganisateur;
use App\Shared\Entity\TzeSlide;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TzeOrganisateurType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orgName',TextType::class,array(
                'label' => 'Name',
                'required' => false
            ))

            ->add('orgResponsabilite',TextType::class,array(
                'label' => 'Responsabilite',
                'required' => false
            ))

            ->add('orgDecription',TextareaType::class,array(
                'label' => 'Description',
                'required' => false
            ))

            ->add('actEvent',EntityType::class,array(
                'class'         => TzeSlide::class,
                'choice_label'  =>'sld_event_title',
                'multiple'      => false,
                'expanded'      => false,
                'required'      => true
            ))

            ->add('orgImage', FileType::class, array(
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
            'data_class' => TzeOrganisateur::class
        ));
    }

    /**
     * @return string|null
     */
    public function getBlockPrefix()
    {
        return 'tze_service_metiermanagerbundle_tze_organisateur';
    }
}