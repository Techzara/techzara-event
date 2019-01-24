<?php

namespace App\Devintech\Service\MetierManagerBundle\Form;

use App\Devintech\Service\MetierManagerBundle\Utils\EtatServiceProject;
use App\Devintech\Service\MetierManagerBundle\Utils\EtatServiceValidation;
use App\Devintech\Service\MetierManagerBundle\Utils\RoleName;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DitUserServiceClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->type_action = $options['type_action'];

        $builder
            ->add('usrSrvCltDateDebut', DateTimeType::class, array(
                'label'    => "Date de début",
                'widget'   => 'single_text',
                'format'   => 'dd/MM/yyyy HH:mm',
                'attr'     => array('class' => 'datetimepicker_date_debut'),
                'required' => true
            ))

            ->add('usrSrvCltDateFinalisation', DateTimeType::class, array(
                'label'    => "Date de finalisation",
                'widget'   => 'single_text',
                'format'   => 'dd/MM/yyyy HH:mm',
                'attr'     => array('class' => 'datetimepicker_date_fin'),
                'required' => true
            ))

            ->add('usrSrvCltEstimation', TextType::class, array(
                'label'    => "Estimation (en jour)",
                'attr'     => array('pattern' => "[0-9]+([,\.][0-9]+)?"),
                'required' => false
            ))

            ->add('ditUsers', EntityType::class, array(
                'label'         => 'Attribuer aux intégrateurs',
                'class'         => 'App\Devintech\Service\UserBundle\Entity\User',
                'query_builder' => function (EntityRepository $_er) {
                    return $_er
                        ->createQueryBuilder('usr')
                        ->where('usr.ditRole = :id_role')
                        ->setParameter('id_role', RoleName::ID_ROLE_INTEGRATEUR);
                },
                'choice_label'  => 'usrFullname',
                'multiple'      => true,
                'required'      => true,
                'placeholder'   => '- Séléctionner Utilisateur -'
            ))

            ->add('ditTesters', EntityType::class, array(
                'label'         => 'Attribuer aux testeurs',
                'class'         => 'App\Devintech\Service\UserBundle\Entity\User',
                'query_builder' => function (EntityRepository $_er) {
                    return $_er
                        ->createQueryBuilder('usr')
                        ->where('usr.ditRole = :id_role')
                        ->setParameter('id_role', RoleName::ID_ROLE_TESTEUR);
                },
                'choice_label'  => 'usrFullname',
                'multiple'      => true,
                'required'      => true,
                'placeholder'   => '- Séléctionner Utilisateur -'
            ))

            ->add('ditServiceClient', EntityType::class, array(
                'label'         => 'Service client',
                'class'         => 'App\Devintech\Service\MetierManagerBundle\Entity\DitServiceClient',
                'query_builder' => function (EntityRepository $_er) {
                    if ($this->type_action == 'create') {
                        return $_er
                            ->createQueryBuilder('srv_clt')
                            ->where('srv_clt.srvCltStatusValidation IN (:array_id_status_validation)')
                            ->andWhere('srv_clt.srvCltStatusProject = :id_status_project')
                            ->setParameter('array_id_status_validation', array(
                                EtatServiceValidation::ID_DEVELOPPEMENT,
                                EtatServiceValidation::ID_LIEN_LIVRE,
                                EtatServiceValidation::ID_TEST,
                                EtatServiceValidation::ID_FINALISE,
                            ))
                            ->setParameter('id_status_project', EtatServiceProject::ID_EN_ATTENTE)
                            ->orderBy('srv_clt.srvCltDate', 'DESC');
                    } else {
                        return $_er
                            ->createQueryBuilder('srv_clt')
                            ->orderBy('srv_clt.srvCltDate', 'DESC');
                    }
                },
                'choice_label'  => 'serviceProjectString',
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
            'data_class'  => 'App\Devintech\Service\MetierManagerBundle\Entity\DitUserServiceClient',
            'type_action' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dit_service_metiermanagerbundle_user_service_client';
    }
}
