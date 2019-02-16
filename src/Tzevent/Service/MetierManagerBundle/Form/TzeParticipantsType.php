<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 2/16/19
 * Time: 4:00 PM
 */

namespace App\Tzevent\Service\MetierManagerBundle\Form;


use App\Tzevent\Service\MetierManagerBundle\Entity\TzeSlide;
use App\Tzevent\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Tzevent\Service\MetierManagerBundle\Entity\TzeParticipants;

class TzeParticipantsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('actEvent',EntityType::class,array(
                'class'         => TzeSlide::class,
                'choice_label'  =>'sld_event_title',
                'multiple'      => false,
                'expanded'      => false,
                'required'      => true
            ))
            ->add('partTeam',TextType::class,array(
                'label'     => 'Nom team',
                'required'  => true
            ))
            ->add('partDescription',TextType::class,array(
                'label'     => 'Nom team',
                'required'  => true
            ))
            ->add('partImage',FileType::class,array(
                'label'    => 'Image (recommandé 1599 x 816)',
                'mapped'   => false,
                'attr'     => array('accept' => 'image/*'),
                'required' => false
            ))
            ->add('partUniversite',TextType::class,array(
                'label'     => 'Nom team',
                'required'  => true
            ))
            ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => TzeParticipants::class
        ));
    }

    /**
     * @return string|null
     */
    public function getBlockPrefix()
    {
        return 'tze_service_metiermanagerbundle_tze_participants';
    }
}