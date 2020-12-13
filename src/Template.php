<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

declare(strict_types=1);

namespace Enjoys\SimplePhpTemplate;

use Enjoys\Traits\Options;

/**
 * Description of Template
 *
 * @author Enjoys
 */
class Template
{
    use Options;

    private string $template_dir;
    private array $vars = [];

    /**
     * Template constructor.
     * @param string $template_dir
     */
    public function __construct(string $template_dir)
    {
        $this->template_dir = $template_dir;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function assign(string $name, $value): void
    {
        $this->vars[$name] = $value;
    }

    /**
     * @param string $name
     * @param string $template_path
     * @throws TemplateException
     */
    final public function fetch(string $name, string $template_path): void
    {
        $this->assign($name, $this->getContent($template_path));
    }

    /**
     * @param string $template_path
     * @return string
     * @throws TemplateException
     */
    final public function display(string $template_path): string
    {
        return $this->getContent($this->template_dir . '/' . $template_path);
    }

    /**
     * @param string $path
     * @return string
     * @throws TemplateException
     */
    private function getContent(string $path): string
    {
        $content = new Content($path, $this->vars);
        $content->setOptions($this->getOptions());
        $this->vars = [];
        return $content->getHtml();
    }
}
