<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Form\Constituency\NetworkElement;

use CertUnlp\NgenBundle\Entity\Constituency\NetworkAdmin;
use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Network;
use CertUnlp\NgenBundle\Entity\Constituency\NetworkEntity;
use CertUnlp\NgenBundle\Form\EntityType as EntityForm;
use CertUnlp\NgenBundle\Service\Listener\Form\EntityTypeListener;
use CertUnlp\NgenBundle\Service\Listener\Form\NetworkTypeListener;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class NetworkType extends EntityForm
{
    /**
     * @var NetworkTypeListener
     */
    private $network_type_listener;

    public function __construct(EntityTypeListener $entity_type_listener, NetworkTypeListener $network_type_listener)
    {
        $this->network_type_listener = $network_type_listener;
        parent::__construct($entity_type_listener);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address', TextType::class, array(
                'required' => true,
                'attr' => array('help_text', 'placeholder' => 'IPV(4|6)/mask or domain'),
                'label' => 'Address',
            ))
            ->add('type', ChoiceType::class, array(
                'required' => true,
                'choices' => array(
                    'Internal' => 'internal',
                    'External' => 'external',
                    'Rdap' => 'rdap',
                ),
                'choices_as_values' => true,
            ))
            ->add('networkEntity', Select2EntityType::class, [
                'required' => true,
                'remote_route' => 'cert_unlp_ngen_network_entity_search_autocomplete',
                'class' => NetworkEntity::class,
                'minimum_input_length' => 3,
                'page_limit' => 10,
                'placeholder' => 'Select an entity',
            ])
            ->add('networkAdmin', Select2EntityType::class, array(
                'required' => true,
                'remote_route' => 'cert_unlp_ngen_network_admin_search_autocomplete',
                'class' => NetworkAdmin::class,
                'minimum_input_length' => 3,
                'page_limit' => 10,
                'placeholder' => 'Select an admin',
            ));
        $builder->addEventSubscriber($this->getNetworkTypeListener());
        $options['add_event_subscriber'] = false;
        parent::buildForm($builder, $options);

    }

    /**
     * @return NetworkTypeListener
     */
    public function getNetworkTypeListener(): NetworkTypeListener
    {
        return $this->network_type_listener;
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'data_class' => Network::class,
            'error_mapping' => [
                'domain' => 'address',
                'ip' => 'address',
            ],
        ));
    }


}
