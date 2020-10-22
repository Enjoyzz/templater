<?php

/*
 * The MIT License
 *
 * Copyright 2020 Enjoys.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

declare(strict_types=1);

namespace Enjoys\Templater\Extern;

/**
 * Description of CSS
 *
 * @author Enjoys
 */
class CSS implements ExternInterface
{
    private static $css;
    public static function addInternal($style, $namespace = '_defaults')
    {
        if (!isset(static::$css[$namespace])) {
            static::$css[$namespace] = null;
        }
//        if ($minify === true) {
//            $class = new \Enjoys\Core\Minify\Adapter\CSS('css');
//            $class->set($body);
//            $body = $class->min('css') . "\r\n";
//        }
        static::$css[$namespace] .= $style . "\n";
    }

    public static function buildInternal($namespace = '_defaults')
    {
        return static::$css[$namespace];
    }
}
