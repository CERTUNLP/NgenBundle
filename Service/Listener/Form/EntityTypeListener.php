<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Listener\Form;

use CertUnlp\NgenBundle\Model\EntityInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class EntityTypeListener implements EventSubscriberInterface
{
    /**
     * @var EntityManager
     */
    private $entity_manager;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $entity_manager)
    {
        $this->entity_manager = $entity_manager;
        $this->serializer = $serializer;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            FormEvents::PRE_SET_DATA => 'onPreSetData',
        );
    }

    /**
     * @param FormEvent $event
     */
    public function onPreSetData(FormEvent $event): void
    {
        $entity = $event->getData();
        $form = $event->getForm();
        $this->disableFundamentalFields($form, $entity);


        if ($event->getForm()->getConfig()->getMethod() !== Request::METHOD_PATCH && $event->getForm()->getConfig()->getOption('frontend')) {
            $form->remove('force_edit');
        }
    }

    /**
     * @param $entity
     * @param FormInterface $form
     */
    public function disableFundamentalFields(FormInterface $form, EntityInterface $entity = null): void
    {
        if ($entity) {
            $fields = array_keys(json_decode($this->getSerializer()->serialize($entity, 'json', SerializationContext::create()->setGroups(array('fundamental'))->setSerializeNull(true)), true));
            foreach ($fields as $field) {
                $this->disableField($form->get($field));
            }
        }
    }

    /**
     * @return SerializerInterface
     */
    public function getSerializer(): SerializerInterface
    {
        return $this->serializer;
    }

    /**
     * @param FormInterface $field
     */
    public function disableField(FormInterface $field): void
    {
        $parent = $field->getParent();
        $options = $field->getConfig()->getOptions();
        $name = $field->getName();
        $type = get_class($field->getConfig()->getType()->getInnerType());
//        $parent->remove($name);
//        $parent->add($name, $type, array_merge($options, ['attr' => ['readonly' => true]]));
        $parent->add($name, $type, array_merge($options, ['disabled' => true]));

    }

    /**
     * @return EntityManager
     */
    public function getEntitymanager(): EntityManager
    {
        return $this->entity_manager;
    }
}