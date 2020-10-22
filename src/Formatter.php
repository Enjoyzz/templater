<?php

/*
 * The MIT License
 *
 * Copyright 2020 deadl.
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

namespace Enjoys\Templater;

/**
 * Description of Formatter
 *
 * @author Enjoys
 */
class Formatter
{

    public static function sanitize($buffer)
    {
        $search = array(
            '/\>[^\S ]+/s', //strip whitespaces after tags, except space
            '/[^\S ]+\</s', //strip whitespaces before tags, except space
            '/(\s)+/s', // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        );
        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );

        $blocks = \preg_split('/(<\/?pre[^>]*>)/', $buffer, 0, \PREG_SPLIT_DELIM_CAPTURE);
        $result = '';
        foreach ($blocks as $i => $block) {
            if ($i % 4 == 2) {
                $result .= $block; //break out <pre>...</pre> with \n's
            } else {
                $result .= \preg_replace($search, $replace, $block);
            }
        }

        return $result;
    }

    public static function excludeCss($content)
    {
        $styles = [];
        $css = [];
        preg_match_all("/<style[^>]*?>.*?<\/style>/simu", $content, $styles);
        foreach ($styles[0] as $style) {
            $minify = true;
            $move = true;
            //var_dump($script);
            if (strpos($style, '//SKIP_MINIFY//') !== false) {
                $minify = false;
            }

            if (strpos($style, '//NOMOVE//') !== false) {
                $move = false;
            }

            if ($move === true) {
                $content = str_replace($style, "\n\r", $content);
//                $css[] = [
//                    'style' => $style,
//                    'minify' => $minify
//                ];
                //\Enjoys\Core\Minify::addCSS($style, $minify);
                Extern\CSS::addInternal($style);
            }
        }
        return $content;
//        return [
//            'content' => $content,
//            'css' => $css
//        ];
    }
}
