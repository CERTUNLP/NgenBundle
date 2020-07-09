<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Form;

use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Entity\Incident\Taxonomy\Incident\Taxonomy\TaxonomyValue;
use CertUnlp\NgenBundle\Service\Listener\Form\EntityTypeListener;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class IncidentTypeType extends AbstractType
{

    /**
     * @var EntityTypeListener
     */
    private $entity_type_listener;

    public function __construct(EntityTypeListener $entity_type_listener)
    {
        $this->entity_type_listener = $entity_type_listener;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'required' => true,
            ))
            ->add('description', null, array(
                'required' => true,
            ))
            ->add('taxonomyValue', null, array(
                'class' => \CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyValue::class,
                'placeholder' => 'Choose a Tanonomy Reference value',
                'required' => false,
                'attr' => array('help_text' => 'If none is selected null is assigned'),
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.predicate', 'ASC');
                }
            ));

//        if ($builder->getData()) {
//            if (!$builder->getData()->isActive()) {
//                $builder
//                    ->add('reactivate', CheckboxType::class, array('data' => false, 'mapped' => false, 'label_attr' => array('class' => 'alert alert-warning'), 'attr' => array('align_with_widget' => true, 'help_text' => 'If it set to true the network will be reactivated.'), 'required' => false, 'label' => 'Reactivate?'));
//            }
//            $builder
//                ->add('force_edit', CheckboxType::class, array('data' => false, 'mapped' => false, 'label_attr' => array('class' => 'alert alert-warning'), 'attr' => array('align_with_widget' => true, 'help_text' => 'If it set to true the network will be edited and not replaced.(this can harm the network history)'), 'required' => false, 'label' => 'Force edit'));
//        }
        $builder->addEventSubscriber($this->entity_type_listener);

        $builder->add('save', SubmitType::class, array('attr' =>
            array('class' => 'save btn btn-primary btn-block', 'data-style' => 'slide-down'),
        ));
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => IncidentType::class,
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }

    public function getParent()
    {
        return EntityType::class;
    }
}
