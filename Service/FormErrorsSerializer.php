<?php

namespace CertUnlp\NgenBundle\Service;

use Symfony\Component\Form\Form;

/**
 * Class FormErrorsSerializer
 * @package OpenObjects\Bundle\CoreBundle\Service
 */
class FormErrorsSerializer
{

    /**
     * @param Form $form
     * @param bool $flat_array
     * @param bool $add_form_name
     * @param string $glue_keys
     * @return array
     */
    public function serializeFormErrors(Form $form, bool $flat_array = false, bool $add_form_name = false, string $glue_keys = '_'): array
    {
        $errors = array();
        $errors['global'] = array();
        $errors['fields'] = array();

        foreach ($form->getErrors() as $error) {
            $errors['global'][] = $error->getMessage();
        }

        $errors['fields'] = $this->serialize($form);

        if ($flat_array) {
            $errors['fields'] = $this->arrayFlatten($errors['fields'],
                $glue_keys, ($add_form_name ? $form->getName() : ''));
        }


        return $errors;
    }

    /**
     * @param Form $form
     * @return array
     */
    private function serialize(Form $form): array
    {
        $local_errors = array();
        foreach ($form->getIterator() as $key => $child) {

            foreach ($child->getErrors(true) as $error) {
                $local_errors[$key] = $error->getMessage();
            }

            if ($child->getErrors(true)->hasChildren()) {
                $local_errors[$key] = $this->serialize($child);
            }
        }

        return $local_errors;
    }

    /**
     * @param $array
     * @param string $separator
     * @param string $flattened_key
     * @return array
     */
    private function arrayFlatten(array $array, string $separator = "_", string $flattened_key = ''): array
    {
        $flattenedArray = array();
        foreach ($array as $key => $value) {

            if (is_array($value)) {

                $flattenedArray = array_merge($flattenedArray,
                    $this->arrayFlatten($value, $separator,
                        (strlen($flattened_key) > 0 ? $flattened_key . $separator : "") . $key)
                );

            } else {
                $flattenedArray[(strlen($flattened_key) > 0 ? $flattened_key . $separator : "") . $key] = $value;
            }
        }
        return $flattenedArray;
    }

}