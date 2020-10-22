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

    protected string $content;

    public function __construct(string $path, array $vars, array $options = [])
    {
        if (!file_exists($path)) {
            throw new Exception(sprintf("Нет файла в по указанному пути: %s", $path));
        }

        $this->setOptions($options);

        foreach ($vars as $k => $v) {
            $$k = $v;
        }

        ob_start();
        require($path);
        $this->content = ob_get_contents();
        ob_end_clean();

    }

    public function getHtml(): string
    {

        if ($this->getOption('excludeCss') === true) {
            $this->content = Formatter::excludeCss($this->content);
        }
        if ($this->getOption('excludeJs') === true) {
            $this->content = Formatter::excludeJs($this->content);
        }
        if ($this->getOption('sanitizeOutput') === true) {
            $this->content = Formatter::sanitize($this->content);
        }
        
        return $this->content;
    }

}
