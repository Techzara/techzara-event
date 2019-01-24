<?php

namespace App\Devintech\Service\MetierManagerBundle\Form;

use App\Devintech\Service\MetierManagerBundle\Utils\ValeurTypeName;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DitServiceOptionValeurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('srvOptValTpVal', ChoiceType::class, array(
                'label'       => 'Type valeur',
                'placeholder' => false,
                'required'    => true,
                'choices'     => ValeurTypeName::$TYPE_VALEUR,
                'expanded'    => true
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Devintech\Service\MetierManagerBundle\Entity\DitServiceOptionValeurType'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dit_service_metiermanagerbundle_service_option_valeur_type';
    }
}
