<?php

// src/Form/Extension/ImageTypeExtension.php
namespace CertUnlp\NgenBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class DateTimeTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['widget'] = $options['widget'];

        // Change the input to a HTML5 datetime input if
        //  * the widget is set to "single_text"
        //  * the format matches the one expected by HTML5
        //  * the html5 is set to true
        if ($options['html5'] && 'single_text' === $options['widget'] ) {
            $view->vars['type'] = 'datetime-local';
        }
    }

    public function getExtendedType()
    {
        return DateTimeType::class;
    }
}