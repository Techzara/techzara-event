<?php

namespace App\Devintech\Service\MetierManagerBundle\Form;

use App\Devintech\Service\MetierManagerBundle\Utils\EtatFactureName;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DitFactureType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fctStatus', ChoiceType::class, array(
                'label'       => 'Statut',
                'placeholder' => false,
                'required'    => true,
                'choices'     => EtatFactureName::$TYPE_VALEUR,
                'expanded'    => true
            ))

            ->add('ditServiceClient', EntityType::class, array(
                'label'         => 'Service client',
                'class'         => 'App\Devintech\Service\MetierManagerBundle\Entity\DitServiceClient',
                'query_builder' => function (EntityRepository $_er) {
                    return $_er
                        ->createQueryBuilder('srv_clt')
                        ->orderBy('srv_clt.srvCltDate', 'DESC');
                },
                'choice_label'  => 'serviceValidationString',
                'multiple'      => false,
                'expanded'      => false,
                'required'      => true,
                'placeholder'   => '- Séléctionner Service client -'
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Devintech\Service\MetierManagerBundle\Entity\DitFacture'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dit_service_metiermanagerbundle_facture';
    }
}
