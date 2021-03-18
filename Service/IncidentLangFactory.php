<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service;

use CertUnlp\NgenBundle\Entity\Incident\Incident;

class IncidentLangFactory
{

    private string $ngen_lang_external;
    private string $ngen_lang;

    public function __construct(string $ngen_lang, string $ngen_lang_external)
    {
        $this->ngen_lang = $ngen_lang;
        $this->ngen_lang_external = $ngen_lang_external;
    }

    /**
     * @param Incident $incident
     * @return string
     */
    public function getLangByIncident(Incident $incident): string
    {
        return $incident->isInternal() ? $this->getNgenLang() : $this->getNgenLangExternal();
    }

    /**
     * @return string
     */
    public function getNgenLang(): string
    {
        return $this->ngen_lang;
    }

    /**
     * @return string
     */
    public function getNgenLangExternal(): string
    {
        return $this->ngen_lang_external;
    }
}
