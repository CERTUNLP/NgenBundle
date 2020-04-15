<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Command;

use CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyPredicate;
use CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyValue;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class GetReferenceTaxonomyFromEnisaCommand extends ContainerAwareCommand
{

    public function configure()
    {
        $this
            ->setName('cert_unlp:taxonomy:update')
            ->setDescription('Upgrade Referencial Taxonomy from WorkingGroup.')
            ->addOption('url', '-u', InputOption::VALUE_OPTIONAL, 'Es la url para obtener el json RAW', 'https://raw.githubusercontent.com/enisaeu/Reference-Security-Incident-Taxonomy-Task-Force/master/working_copy/machinev1');

    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('[Updating Taxonomy Reference]: Starting.');
        $output->writeln('[Updating Taxonomy Reference]: Getting from ' . $input->getOption('url'));
        $json = file_get_contents($input->getOption('url'));
        $obj = json_decode($json);
        foreach ($obj->predicates as $predicate) {
            $existing_predicate = $this->getContainer()->get('doctrine')->getRepository(TaxonomyPredicate::class)->findOneBy(['value' => $predicate->value]);
            if ($existing_predicate) {
                if (($existing_predicate->getValue() !== $predicate->value) || ($existing_predicate->getExpanded() !== $predicate->expanded) || ($existing_predicate->getDescription() !== $predicate->description)) {
                    $output->writeln('Actualizando el predicado ' . $predicate->value);
                    $existing_predicate->setValue($predicate->value);
                    $existing_predicate->setExpanded($predicate->expanded);
                    $existing_predicate->setVersion($obj->version);
                    $existing_predicate->setVersion($predicate->description);
                    $existing_predicate->setUpdatedAt(new DateTime('now'));
                    $this->getContainer()->get('doctrine')->getManager()->persist($existing_predicate);
                } else {
                    $output->writeln('Sin cambios ' . $predicate->value);
                }
            } else {
                $output->writeln('No existía el predicado ' . $predicate->value);
                $new_predicate = new TaxonomyPredicate();
                $new_predicate->setValue($predicate->value);
                $new_predicate->setExpanded($predicate->expanded);
                $new_predicate->setVersion($obj->version);
                $new_predicate->setDescription($predicate->description);
                $new_predicate->setUpdatedAt(new DateTime('now'));
                $new_predicate->setIsActive(true);
                $this->getContainer()->get('doctrine')->getManager()->persist($new_predicate);
            }
        }
        $this->getContainer()->get('doctrine')->getManager()->flush();
        foreach ($obj->values as $predicate_value) {
            foreach ($predicate_value->entry as $value) {
                $existing_value = $this->getContainer()->get('doctrine')->getRepository(TaxonomyValue::class)->findOneBy(
                    ['value' => $value->value]
                );
                if ($existing_value) {
                    if (($existing_value->getValue() !== $value->value) || ($existing_value->getExpanded() !== $value->expanded) || ($existing_value->getDescription() !== $value->description) || ($existing_value->getPredicate()->getValue() !== $predicate_value->predicate)) {
                        $output->writeln('Actualizando el value ' . $value->value);
                        $existing_value->setValue($value->value);
                        $existing_value->setExpanded($value->expanded);
                        $existing_value->setVersion($obj->version);
                        $existing_value->setPredicate(
                            $this->getContainer()->get('doctrine')->getRepository(TaxonomyPredicate::class)->findBy(
                                ['value' => ($predicate_value->predicate)]
                            )[0]
                        );
                        $existing_value->setDescription($value->description);
                        $existing_value->setUpdatedAt(new DateTime('now'));
                        $this->getContainer()->get('doctrine')->getManager()->persist($existing_value);

                    } else {
                        $output->writeln('Sin cambios ' . $value->value);
                    }
                } else {
                    $output->writeln('No existía el value ' . $value->value);
                    $new_value = new TaxonomyValue();
                    $new_value->setValue($value->value);
                    $new_value->setExpanded($value->expanded);
                    $new_value->setVersion($obj->version);
                    $new_value->setIsActive(true);
                    $new_value->setPredicate($this->getContainer()->get('doctrine')->getRepository(TaxonomyPredicate::class)->findBy(
                        ['value' => $predicate_value->predicate])[0]);
                    $new_value->setDescription($value->description);
                    $new_value->setUpdatedAt(new DateTime('now'));
                    $this->getContainer()->get('doctrine')->getManager()->persist($new_value);
                }
            }
        }
        $this->getContainer()->get('doctrine')->getManager()->flush();
        $output->writeln('[Taxonomy Update]: Done.');
    }

}
