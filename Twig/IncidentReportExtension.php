<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Twig;

use Twig_Extension;

class IncidentReportExtension extends Twig_Extension
{

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('subtitle', array($this, 'subtitleFilter'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('paragraph', array($this, 'paragraphFilter'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('code', array($this, 'codeFilter'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('destacated', array($this, 'destacatedFilter'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('emphasized', array($this, 'emphasizedFilter'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('urlLink', array($this, 'urlLinkFilter'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('list', array($this, 'listFilter'), array('is_safe' => array('html'))),
        );
    }

    public function paragraphFilter($text)
    {
        $text = '<p>' . $text . '</p>';

        return $text;
    }

    public function codeFilter($text)
    {
        $text = '<pre><code>' . $text . '</code></pre>';

        return $text;
    }

    public function subtitleFilter($text)
    {
        $text = '<p class="lead">' . $text . '</p>';

        return $text;
    }

    public function destacatedFilter($text)
    {
        $text = '<div class="destacated">' . $text . '</div>';

        return $text;
    }

    public function emphasizedFilter($text)
    {
        $text = '<em>' . $text . '</em>';

        return $text;
    }

    public function listFilter($text, $function = null)
    {
        $elements = explode(',', $text);
        $list = '<ul>';
        $function = $function ? $function . "Filter" : $function;
        foreach ($elements as $element) {
            $element = $function ? $this->$function($element) : $element;
            $list .= '<li>' . $element . '</li>';
        }
        $list .= '</ul>';

        return $list;
    }

    public function urlLinkFilter($url, $text = null)
    {
        if (!$text) {
            $text = $url;
        }
        $text = '<a href="' . $url . '">' . $text . '</a>';
        return $text;
    }

    public function getName()
    {
        return 'incident_report_extension';
    }

}
