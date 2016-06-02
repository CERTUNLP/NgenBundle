<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Michelf\MarkdownExtra;

class IncidentMarkdowReportParser extends MarkdownExtra implements MarkdownParserInterface {

    public function __construct() {
        parent::__construct();
        $this->span_gamut['doParseIncidentVariables'] = 7;
        $this->mappingIncidentVariables = ['{{IP}}' => '{{incident.hostAddress}}',
            '{{hostAddress}}' => '{{incident.hostAddress}}',
            '{{reporter}}' => '{{incident.reporter}}',
            '{{type}}' => '{{incident.type}}',
            '{{network}}' => '{{incident.network}}',
            '{{networkAdmin}}' => '{{incident.network.networkAdmin}}',
        ];
    }

    protected function _doCodeBlocks_callback($matches) {
        $codeblock = $matches[1];

        $codeblock = $this->outdent($codeblock);
        $codeblock = htmlspecialchars($codeblock, ENT_NOQUOTES);

        # trim leading newlines and trailing newlines
        $codeblock = preg_replace('/\A\n+|\n+\z/', '', $codeblock);

        $codeblock = "<pre><code>" . $this->doParseIncidentVariables($codeblock) . "\n</code></pre>";
        return "\n\n" . $this->hashBlock($codeblock) . "\n\n";
    }

    public function doParseIncidentVariables($text) {

        foreach ($this->mappingIncidentVariables as $template_var => $incident_var) {
            $text = str_replace($template_var, $incident_var, $text);
        }
        return $text;
    }

    public function transformMarkdown($text, $appendHead = true) {
        $html = parent::transform($text);
        $html = $appendHead ? "{# 
 This file is part of the Ngen - CSIRT Incident Report System.
 
 (c) CERT UNLP <support@cert.unlp.edu.ar>
 
 This source file is subject to the GPL v3.0 license that is bundled
 with this source code in the file LICENSE.
#}
{% set father = 'CertUnlpNgenBundle:InternalIncident:Report/Twig/BaseReport/baseReport.'~txtOrHtml~'.twig' %}
{% extends father %}" . $html : $html;

        return $html;
    }

    protected function _doHeaders_callback_setext($matches) {

        $reportBlock = $this->getReportBlock($matches[2]);
        if ($reportBlock) {
            return $reportBlock;
        } else {
            if ($matches[3] == '-' && preg_match('{^- }', $matches[1]))
                return $matches[0];
            $block = "<p class=\"lead\">" . $this->runSpanGamut($matches[1]) . "</p>";
            return "\n" . $this->hashBlock($block) . "\n\n";
        }
    }

    protected function getReportBlock($text) {
        $patt_open = "#\[([^\/].+)\]#";
        $patt_close = "#\[\/(.+)\]#";

        if (preg_match($patt_open, $text, $matches_open)) {
            if ($matches_open[1] == 'destacated') {

                return "\n" . $this->hashBlock('<div class = "' . $this->runSpanGamut($matches_open[1]) . '">') . "\n\n";
            } else {
                return "\n" . $this->hashBlock("{% block " . $this->runSpanGamut($matches_open[1]) . " %}") . "\n\n";
            }
        }

        if (preg_match($patt_close, $text, $matches_close)) {
            if ($matches_close[1] == 'destacated') {

                return "\n" . $this->hashBlock('</' . $this->runSpanGamut('div') . '>') . "\n\n";
            } else {
                return "\n" . $this->hashBlock("{% " . $this->runSpanGamut('endblock') . " %}") . "\n\n";
            }
        }
        return false;
    }

    protected function _doHeaders_callback_atx($matches) {
        $reportBlock = $this->getReportBlock($matches[2]);
        if ($reportBlock) {
            return $reportBlock;
        } else {
            $block = "<p class=\"lead\">" . $this->runSpanGamut($matches[2]) . "</p>";
            return "\n" . $this->hashBlock($block) . "\n\n";
        }
    }

    protected function formParagraphs($text) {
        #
        #	Params:
        #		$text - string to process with html <p> tags
        #
		# Strip leading and trailing lines:
        $text = preg_replace('/\A\n+|\n+\z/', '', $text);

        $grafs = preg_split('/\n {
            2, }/', $text, -1, PREG_SPLIT_NO_EMPTY);

        #
        # Wrap <p> tags and unhashify HTML blocks
        #
		foreach ($grafs as $key => $value) {
            $value = trim($this->runSpanGamut($value));

            # Check if this should be enclosed in a paragraph.
            # Clean tag hashes & block tag hashes are left alone.
            $is_p = !preg_match('/^B\x1A[0-9]+B|^C\x1A[0-9]+C$/', $value);

            if ($is_p) {
                $value = "<p>$value</p>";
            }
            $grafs[$key] = $value;
        }

        # Join grafs in one text, then unhash HTML tags. 
        $text = implode("\n\n", $grafs);

        # Finish by removing any tag hashes still present in $text.
        $text = $this->unhash($text);

        return $text;
    }

}
