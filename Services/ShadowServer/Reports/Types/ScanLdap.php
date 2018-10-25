<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\ShadowServer\Reports\Types;

/**
 * Description of ScanNetbios
 *
 * @author demyen
 */
class ScanLdap extends ShadowServerReport
{

    public function getType()
    {
        return "open_ldap";
    }

}
