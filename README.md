# PHP Templater
## Usage

```php
$tpl = new \Enjoys\SimplePhpTemplate\Template(__DIR__.'/template/');
$tpl->setOption('sanitizeOutput', true);

//$site->title
$tpl->assignGlobal('site', (object) [
        'title' => 'Title Site'
    ]);

//$form
$tpl->assign('form', (string) $form->display());
$tpl->fetch('module', __DIR__.'/template/form.html');
echo $tpl->display('template.html');
```