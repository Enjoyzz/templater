<?php
declare(strict_types=1);

namespace Enjoys\SimplePhpTemplate;

use Enjoys\Traits\Options;

/**
 * Description of Content
 *
 * @author deadl
 */
class Content
{
    use Options;

    private \SplFileInfo $path;


    /**
     * Content constructor.
     * @param string $path
     * @param array $vars
     * @throws TemplateException
     */
    public function __construct(string $path, array $vars)
    {
        $this->path = new \SplFileInfo($path);

        if (!$this->path->isFile()) {
            throw new TemplateException(sprintf("Нет файла в по указанному пути: %s", $this->path->getPathname()));
        }

        $this->initVars($vars);
    }

    /**
     * @param iterable $vars
     * @throws TemplateException
     */
    private function initVars(iterable $vars): void
    {
        foreach ($vars as $k => $v) {
            if (is_int($k)) {
                throw new TemplateException('Недопустимый индекс для переменной, должен быть string а не int');
            }
            $this->$k = $v;
        }
    }


    /**
     * @return string
     */
    public function getHtml(): string
    {
        ob_start();
        require($this->path->getRealPath());
        $content = ob_get_contents();
        ob_end_clean();

//        if ($this->getOption('excludeCss') === true) {
//            $content = Formatter::excludeCss($content);
//        }
//        if ($this->getOption('excludeJs') === true) {
//            $content = Formatter::excludeJs($content);
//        }
        if ($this->getOption('sanitizeOutput') === true) {
            $content = Formatter::sanitize($content);
        }

        return $content;
    }

}
