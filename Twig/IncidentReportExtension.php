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
use Twig_SimpleFunction;

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

    public function getFunctions()
{
    $options = array('pre_escape' => 'html', 'is_safe' => array('html'));

    return array(
        new Twig_SimpleFunction('label', array($this, 'labelFunction'), $options),
        new Twig_SimpleFunction('label_primary', array($this, 'labelPrimaryFunction'), $options),
        new Twig_SimpleFunction('label_success', array($this, 'labelSuccessFunction'), $options),
        new Twig_SimpleFunction('label_info', array($this, 'labelInfoFunction'), $options),
        new Twig_SimpleFunction('label_warning', array($this, 'labelWarningFunction'), $options),
        new Twig_SimpleFunction('label_danger', array($this, 'labelDangerFunction'), $options)
    );
}

/**
 * Returns the HTML code for a label.
 *
 * @param string $text The text of the label
 * @param string $type The type of label
 *
 * @return string The HTML code of the label
 */
public function labelFunction($text, $type = 'default')
{
    return sprintf('<span class="badge%s">%s</span>', ($type ? ' badge-' . $type : ''), $text);
}

/**
 * @param string $text
 *
 * @return string
 */
public function labelPrimaryFunction($text)
{
    return $this->labelFunction($text, 'primary');
}

/**
 * Returns the HTML code for a success label.
 *
 * @param string $text The text of the label
 *
 * @return string The HTML code of the label
 */
public function labelSuccessFunction($text)
{
    return $this->labelFunction($text, 'success');
}

/**
 * Returns the HTML code for a warning label.
 *
 * @param string $text The text of the label
 *
 * @return string The HTML code of the label
 */
public function labelWarningFunction($text)
{
    return $this->labelFunction($text, 'warning');
}

/**
 * Returns the HTML code for a important label.
 *
 * @param string $text The text of the label
 *
 * @return string The HTML code of the label
 */
public function labelDangerFunction($text)
{
    return $this->labelFunction($text, 'danger');
}

/**
 * Returns the HTML code for a info label.
 *
 * @param string $text The text of the label
 *
 * @return string The HTML code of the label
 */
public function labelInfoFunction($text)
{
    return $this->labelFunction($text, 'info');
}

}
