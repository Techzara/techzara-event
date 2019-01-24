<?php

namespace App\Devintech\Service\MetierManagerBundle\Form;

use App\Devintech\Service\MetierManagerBundle\Utils\RoleName;
use App\Devintech\Service\MetierManagerBundle\Utils\ValeurTypeName;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DitServiceClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->type_action = $options['type_action'];

        $builder
            ->add('srvCltPrix', TextType::class, array(
                'label'    => "Total prix (en €)",
                'attr'     => array(
                    'pattern'  => "[0-9]+([,\.][0-9]+)?",
                    'readonly' => true
                ),
                'required' => false
            ))

            ->add('srvCltNbrPage', TextType::class, array(
                'label'    => "Nombre de page à intégrer",
                'attr'     => array('pattern' => "[0-9]+([,\.][0-9]+)?"),
                'required' => true
            ))

            ->add('srvCltNbrPageDecline', TextType::class, array(
                'label'    => "Nombre de pages déclinées",
                'attr'     => array('pattern' => "[0-9]+([,\.][0-9]+)?"),
                'required' => false
            ))

            ->add('srvCltProjectLink', UrlType::class, array(
                'label'    => "Lien projet",
                'required' => false
            ))

            ->add('srvCltDateLivraison', DateTimeType::class, array(
                'label'    => "Date livraison",
                'widget'   => 'single_text',
                'format'   => 'dd/MM/yyyy HH:mm',
                'attr'     => array('class' => $this->type_action == 'create' ? 'datetimepicker-min-now' : 'datetimepicker'),
                'required' => false
            ))

            ->add('srvCltDesc', TextareaType::class, array(
                'label'    => "Description projet",
                'required' => false
            ))

            ->add('ditUser', EntityType::class, array(
                'label'         => 'Client',
                'class'         => 'App\Devintech\Service\UserBundle\Entity\User',
                'query_builder' => function (EntityRepository $_er) {
                    return $_er
                        ->createQueryBuilder('usr')
                        ->where('usr.ditRole = :id_role')
                        ->setParameter('id_role', RoleName::ID_ROLE_CLIENT)
                        ->groupBy('usr.usrNomEntreprise')
                        ->orderBy('usr.email', 'ASC');
                },
                'choice_label'  => 'usrEntreprise',
                'multiple'      => false,
                'expanded'      => false,
                'required'      => true,
                'placeholder'   => '- Séléctionner Client -'
            ))

            ->add('ditService', EntityType::class, array(
                'label'         => 'Service',
                'class'         => 'App\Devintech\Service\MetierManagerBundle\Entity\DitService',
                'query_builder' => function (EntityRepository $_er) {
                    return $_er
                        ->createQueryBuilder('srv')
                        ->orderBy('srv.srvLabel', 'ASC');
                },
                'choice_label'  => 'srvLabelString',
                'multiple'      => false,
                'expanded'      => false,
                'required'      => true,
                'placeholder'   => '- Séléctionner Service -'
            ))

            ->add('ditServiceOptions', EntityType::class, array(
                'label'         => 'Option(s) service',
                'class'         => 'App\Devintech\Service\MetierManagerBundle\Entity\DitServiceOption',
                'query_builder' => function (EntityRepository $_er) {
                    return $_er
                        ->createQueryBuilder('so')
                        ->leftJoin('so.ditServiceOptionValeurType', 'so_val_tp')
                        ->where('so_val_tp.srvOptValTpVal <> :val')
                        ->setParameter('val', ValeurTypeName::ID_GRATUIT)
                        ->orderBy('so.ditServiceOptionType', 'ASC');
                },
                'choice_label'  => 'srvOptLabel',
                'multiple'      => true,
                'required'      => false
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Devintech\Service\MetierManagerBundle\Entity\DitServiceClient',
            'type_action' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dit_service_metiermanagerbundle_service_client';
    }
}
