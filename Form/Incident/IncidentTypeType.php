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

namespace CertUnlp\NgenBundle\Form\Incident;

use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyValue;
use CertUnlp\NgenBundle\Form\EntityType as EntityForm;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class IncidentTypeType extends EntityForm
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, array(
                'required' => true,
            ))
            ->add('description', TextType::class, array(
                'required' => true,
            ))
            ->add('taxonomyValue', EntityType::class, array(
                'class' => TaxonomyValue::class,
                'placeholder' => 'Choose a Tanonomy Reference value',
                'required' => false,
                'attr' => array('help_text' => 'If none is selected null is assigned'),
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.predicate', 'ASC');
                }
            ));
        parent::buildForm($builder, $options);
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => IncidentType::class,
        ));
    }
}
