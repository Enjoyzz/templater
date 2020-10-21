<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

declare(strict_types=1);

namespace Enjoys\Templater;

/**
 * Description of Content
 *
 * @author deadl
 */
class Content
{
    use \Enjoys\Traits\Options;

    protected $content;

    public function __construct($path, $vars, array $options = [])
    {
        $this->setOptions($options);

        foreach ($vars as $k => $v) {
            $$k = $v;
        }

        ob_start();
        require($path);
        $this->content = ob_get_contents();
        ob_end_clean();
    }

    public function getHtml()
    {
        if ($this->getOption('sanitizeOutput') === true) {
            $this->content = Formatter::sanitize($this->content);
        }
        return $this->content;
    }
}
