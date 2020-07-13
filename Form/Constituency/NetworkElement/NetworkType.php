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
;

use CertUnlp\NgenBundle\Entity\Constituency\NetworkAdmin;
use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Network\Network;
use CertUnlp\NgenBundle\Entity\Constituency\NetworkEntity;
use CertUnlp\NgenBundle\Form\EntityType;
use CertUnlp\NgenBundle\Service\Listener\Form\NetworkTypeListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class NetworkType extends AbstractType
{
    /**
     * @var NetworkTypeListener
     */
    private $network_type_listener;

    public function __construct(NetworkTypeListener $network_type_listener)
    {
        $this->network_type_listener = $network_type_listener;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address', null, array(
                'required' => true,
                'attr' => array('help_text', 'placeholder' => 'IPV(4|6)/mask or domain'),
                'label' => 'Address',
            ))
            ->add('type', ChoiceType::class, array(
                'mapped' => false,
                'required' => true,
                'choices' => array(
                    'Internal' => 'internal',
                    'External' => 'external',
                ),
                'choices_as_values' => true,
            ))
            ->add('networkEntity', Select2EntityType::class, [
                'remote_route' => 'cert_unlp_ngen_network_entity_search_autocomplete',
                'class' => NetworkEntity::class,
                'minimum_input_length' => 3,
                'page_limit' => 10,
                'placeholder' => 'Select an entity',
            ])
            ->add('networkAdmin', Select2EntityType::class, array(
                'remote_route' => 'cert_unlp_ngen_network_admin_search_autocomplete',
                'class' => NetworkAdmin::class,
                'minimum_input_length' => 3,
                'page_limit' => 10,
                'placeholder' => 'Select an admin',
            ));
        $builder->addEventSubscriber($this->getNetworkTypeListener());

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
        $resolver->setDefaults(array(
            'data_class' => Network::class,
            'error_mapping' => [
                'domain' => 'address',
                'ip' => 'address',
            ],
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getParent(): ?string
    {
        return EntityType::class;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return '';
    }

}
