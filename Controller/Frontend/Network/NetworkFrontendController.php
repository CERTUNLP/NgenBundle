<?php

/*
 * This file is part of the Ngen - CSIRT Network Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller\Frontend\Network;

use CertUnlp\NgenBundle\Entity\Network\Network;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NetworkFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_network_frontend_home")
     * @param Request $request
     * @return array
     */
    public function homeAction(Request $request)
    {
        return $this->getFrontendController()->homeEntity($request);
    }

    public function getFrontendController()
    {
        return $this->get('cert_unlp.ngen.network.frontend.controller');
    }

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_network_search_network")
     * @param Request $request
     * @return array
     */
    public function searchNetworkAction(Request $request)
    {
        return $this->getFrontendController()->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/networkForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_network_new_network")
     * @param Request $request
     * @return array
     */
    public function newNetworkAction(Request $request)
    {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/networkForm.html.twig")
     * @Route("{ip}/{ip_mask}/edit", name="cert_unlp_ngen_network_edit_network_ip_v4",  requirements={"ip"="^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$","ip_mask"="^[1-3]?[0-9]$"} )
     * @Route("{ip}/{ip_mask}/edit", name="cert_unlp_ngen_network_edit_network_ip_v6",  requirements={"ip"="^(::|(([a-fA-F0-9]{1,4}):){7}(([a-fA-F0-9]{1,4}))|(:(:([a-fA-F0-9]{1,4})){1,6})|((([a-fA-F0-9]{1,4}):){1,6}:)|((([a-fA-F0-9]{1,4}):)(:([a-fA-F0-9]{1,4})){1,6})|((([a-fA-F0-9]{1,4}):){2}(:([a-fA-F0-9]{1,4})){1,5})|((([a-fA-F0-9]{1,4}):){3}(:([a-fA-F0-9]{1,4})){1,4})|((([a-fA-F0-9]{1,4}):){4}(:([a-fA-F0-9]{1,4})){1,3})|((([a-fA-F0-9]{1,4}):){5}(:([a-fA-F0-9]{1,4})){1,2}))$","ip_mask"="^(([0-9]|[1-9][0-9]|1[0-1][0-9]|12[0-8]))$"} )
     * @ParamConverter("network", class="CertUnlp\NgenBundle\Entity\Network\Network", options={"repository_method" = "findOneByIpAndMask","map_method_signature"=true})
     * @param Network $network
     * @return array
     */
    public function editIpNetworkAction(Network $network)
    {
        return $this->getFrontendController()->editEntity($network);
    }

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/networkForm.html.twig")
     * @Route("{domain}/edit", name="cert_unlp_ngen_network_edit_network_domain",requirements={"domain"="^(?:[-A-Za-z0-9]+\.)+[A-Za-z0-9]{2,6}$"} )
     * @ParamConverter("network", class="CertUnlp\NgenBundle\Entity\Network\Network", options={"repository_method" = "findOneByDomain","map_method_signature"=true})
     * @param Network $network
     * @return array
     */
    public function editDomainNetworkAction(Network $network)
    {
        return $this->getFrontendController()->editEntity($network);
    }

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/networkDetail.html.twig")
     * @Route("{ip}/{ip_mask}/detail", name="cert_unlp_ngen_network_detail_network_ip_v4",  requirements={"ip"="^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$","ip_mask"="^[1-3]?[0-9]$"} )
     * @Route("{ip}/{ip_mask}/detail", name="cert_unlp_ngen_network_detail_network_ip_v6",  requirements={"ip"="^(::|(([a-fA-F0-9]{1,4}):){7}(([a-fA-F0-9]{1,4}))|(:(:([a-fA-F0-9]{1,4})){1,6})|((([a-fA-F0-9]{1,4}):){1,6}:)|((([a-fA-F0-9]{1,4}):)(:([a-fA-F0-9]{1,4})){1,6})|((([a-fA-F0-9]{1,4}):){2}(:([a-fA-F0-9]{1,4})){1,5})|((([a-fA-F0-9]{1,4}):){3}(:([a-fA-F0-9]{1,4})){1,4})|((([a-fA-F0-9]{1,4}):){4}(:([a-fA-F0-9]{1,4})){1,3})|((([a-fA-F0-9]{1,4}):){5}(:([a-fA-F0-9]{1,4})){1,2}))$","ip_mask"="^(([0-9]|[1-9][0-9]|1[0-1][0-9]|12[0-8]))$"} )
     * @ParamConverter("network", class="CertUnlp\NgenBundle\Entity\Network\Network", options={"repository_method" = "findOneByIpAndMask","map_method_signature"=true})
     * @param Network $network
     * @return array
     */
    public function datailIpNetworkAction(Network $network)
    {
        return $this->getFrontendController()->detailEntity($network);
    }

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/networkDetail.html.twig")
     * @Route("{domain}/detail", name="cert_unlp_ngen_network_detail_network_domain",requirements={"domain"="^(?:[-A-Za-z0-9]+\.)+[A-Za-z0-9]{2,6}$"} )
     * @ParamConverter("network", class="CertUnlp\NgenBundle\Entity\Network\Network", options={"repository_method" = "findOneByDomain","map_method_signature"=true})
     * @param Network $network
     * @return array
     */
    public function datailDomainNetworkAction(Network $network)
    {
        return $this->getFrontendController()->detailEntity($network);
    }

}
