<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 2/16/19
 * Time: 9:19 PM
 */

namespace App\Tzevent\Service\MetierManagerBundle\Form;


use App\Tzevent\Service\MetierManagerBundle\Entity\TzePartenaires;
use App\Tzevent\Service\MetierManagerBundle\Entity\TzeSlide;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TzePartenairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parteEntite',TextType::class,array(
                'label' => 'Title of etities',
                'required' => false
            ))

            ->add('parteLocation',TextType::class,array(
                'label' => 'Adresse',
                'required' => false
            ))

            ->add('parteContribution',TextType::class,array(
                'label' => 'Contribution de partenaires',
                'required' => false
            ))

            ->add('parteFacebook',TextType::class,array(
                'label' => 'Lien facebook',
                'required' => false
            ))

            ->add('partewebSite',TextType::class,array(
                'label' => 'Website',
                'required' => false
            ))

            ->add('parteDescription',TextareaType::class,array(
                'label' => 'Partenaire activities',
                'required' => false
            ))

            ->add('actEvent',EntityType::class,array(
                'class'         => TzeSlide::class,
                'choice_label'  =>'sld_event_title',
                'multiple'      => false,
                'expanded'      => false,
                'required'      => true
            ))

            ->add('parteImage', FileType::class, array(
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
            'data_class' => TzePartenaires::class
        ));
    }

    /**
     * @return string|null
     */
    public function getBlockPrefix()
    {
        return 'tze_service_metiermanagerbundle_tze_partenaires';
    }
}