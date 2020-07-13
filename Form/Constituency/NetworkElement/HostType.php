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

use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Host;
use CertUnlp\NgenBundle\Form\EntityType;
use Exception;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HostType extends AbstractType
{


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @throws Exception
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address', null, array(
                'required' => true,
                'attr' => array('help_text', 'placeholder' => 'IPV(4|6)/mask or domain'),
                'label' => 'Address',
            ));
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Host::class,
        ));
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function getParent(): ?string
    {
        return EntityType::class;
    }
}
