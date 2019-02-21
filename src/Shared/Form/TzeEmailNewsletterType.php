<?php

namespace App\Shared\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Shared\Entity\TzeEmailNewsletter;


class TzeEmailNewsletterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nwsEmail', TextType::class, array(
                'label'    => "Email",
                'attr'     => array('pattern' => "[^@]+@[^@]+\.[a-zA-Z]{2,}"),
                'required' => true
            ))

            ->add('nwsSubscribed', CheckboxType::class, array(
                'label'    => "Abonné",
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
            'data_class' => TzeEmailNewsletter::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tze_service_metiermanagerbundle_email_newsletter';
    }
}
