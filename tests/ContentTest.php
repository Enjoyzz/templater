<?php


namespace Tests\Enjoys\SimplePhpTemplate;


use Enjoys\SimplePhpTemplate\Content;
use PHPUnit\Framework\TestCase;

class ContentTest extends TestCase
{
    public function dataProvider()
    {
        return [
            [[
                'string' => 'test'
            ], '{"string":"test"}'],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function test($vars, $expect)
    {
        $object = new Content(__DIR__ . '/fixtures/file1.html', $vars);

        $this->assertSame($expect, $object->getHtml());

    }

}