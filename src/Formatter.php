<?php
declare(strict_types=1);

namespace Enjoys\SimplePhpTemplate;

/**
 * Description of Formatter
 *
 * @author Enjoys
 */
class Formatter
{

    /**
     * @param string $buffer
     * @return string
     */
    public static function sanitize(string $buffer): string
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
//
//    public static function excludeCss($content)
//    {
//        $styles = [];
//        $css = [];
/*        preg_match_all("/<style[^>]*?>.*?<\/style>/simu", $content, $styles);*/
//        foreach ($styles[0] as $style) {
//            $minify = true;
//            $move = true;
//            //var_dump($script);
//            if (strpos($style, '//SKIP_MINIFY//') !== false) {
//                $minify = false;
//            }
//
//            if (strpos($style, '//NOMOVE//') !== false) {
//                $move = false;
//            }
//
//            if ($move === true) {
//                $content = str_replace($style, "\n\r", $content);
////                $css[] = [
////                    'style' => $style,
////                    'minify' => $minify
////                ];
//                //\Enjoys\Core\Minify::addCSS($style, $minify);
//                Extern\CSS::addInternal($style);
//            }
//        }
//        return $content;
////        return [
////            'content' => $content,
////            'css' => $css
////        ];
//    }
}
