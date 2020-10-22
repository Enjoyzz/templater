<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

declare(strict_types=1);

namespace Enjoys\Templater;

/**
 * Description of Template
 *
 * @author Enjoys
 */
class Template
{
    use \Enjoys\Traits\Options;

    private string $templateDir;
    private array $vars = [];
    private array $globalVars = [];
    private array $exludedCss = [];
    private array $exludedJs = [];

    public function __construct($templateDir = __DIR__)
    {
        $this->setBaseTemplateDir($templateDir);
    }

    public function setBaseTemplateDir($templateDir)
    {
        $this->templateDir = $templateDir;
    }

    public function assign(string $name, $value): void
    {
        $this->vars[$name] = $value;
    }

    public function assignGlobal(string $name, $value): void
    {
        $this->globalVars[$name] = $value;
    }

    final public function fetch($variable, $template)
    {
        if (!file_exists($template)) {
            throw new Exception(sprintf("Нет файла в по указанному пути: %s", $template));
        }
        $this->assign($variable, $this->getContent($template));
    }

    final public function display($template)
    {
        $tpl = $this->templateDir . $template;

        if (!file_exists($tpl)) {
            throw new Exception(sprintf("Нет файла в по указанному пути: %s", $tpl));
        }

        $this->setOptions([
            'excludeCss' => false,
            'excludeJs' => false,
        ]);
        return $this->getContent($tpl);
    }

    private function getContent($path)
    {
        $content = new Content(
                $path,
                (array) $this->vars + (array) $this->globalVars,
                $this->getOptions()
        );
        $this->vars = [];

//        $this->exludedCss = $content->getExludedCss();
//        $this->exludedJs = $content->getExludedJs();
        // _var_dump($path, Extern\CSS::get());

        return $content->getHtml();
    }
}
