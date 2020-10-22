<?php
namespace Enjoys\Core\Minify\Adapter;
/**
 * @24-05-2018 
 * - Если $addtopath полноценный URL то не надо добавлять к строке адрес проекта
 * иначе получалось что-то вроде этого: url('http://myproject.ru/blabla/https://code.jquery.com/css/...');
 * теперь внутри css нормальный URL: url('https://code.jquery.com/css/...');
 */
class CSS extends \Enjoys\Core\Minify\Wrapper{

    public function min($file) {
        $css = $this->input;
        $options = "";
        $options = ($options == "") ? array() : (is_array($options) ? $options : explode(",", $options));
        // Remove comments
        $css = preg_replace("/\/\*[\d\D]*?\*\/|\t+/", " ", $css);
        // Replace CR, LF and TAB to spaces
        $css = str_replace(array("\n", "\r", "\t"), " ", $css);
        // Replace multiple to single space
        $css = preg_replace("/\s\s+/", " ", $css);
        // Remove unneeded spaces
        $css = preg_replace("/\s*({|}|\[|\]|=|~|\+|>|\||;|:|,)\s*/", "$1", $css);
        if (in_array("remove-last-semicolon", $options)) {
            // Removes the last semicolon of every style definition
            $css = str_replace(";}", "}", $css);
        }
        $css = trim($css);
        
         //TODO
        // prevent url
        //$path = static::$project_url;
        $path = '';
        
        if ( strrpos($file,'/') !== false ){
            
            $addtopath = substr($file,0,strrpos($file,'/')+1);
            //dump($addtopath);
            $path .= $addtopath; 
            //Если $addtopath полноценный URL то не надо добавлять к строке адрес проекта
            //а просто вставляем целиком URL
            if(filter_var($addtopath, FILTER_VALIDATE_URL) !== false){
                $path = $addtopath; 
            }
        }
        //dump(\Enjoys\Helpers\File::normalizePath($path));
        $path = \Enjoys\Helpers\File::normalizePath($path);
        
     	// Fix all paths within this CSS file, ignoring absolute paths.
        // неправильно работает с url("data:image"), url("//google.com/...") и с url("http://")
        //$css = preg_replace('/url\(([\'"]?)(?![a-z]+:)/i', 'url(\1'. $path . '\2', $css);   
        
        //Этот Fix работает только с относительными путями и не затрагивает data:image, http(s) и //
        
        $css = preg_replace('/(url\([\'"]?)(?!["\'a-z]+:|\/{2})/i', '\1'. $path, $css);            	
        
        
        return $css;
    }
    public function cssmin_array_clean(array $array) {
        $r = array();
        $c = count($v);
        if (cssmin_array_is_assoc($array))
        {
            foreach ($array as $key => $value)
            {
                $r[$key] = trim($value);
            }
        }
        else
        {
            foreach ($array as $value)
            {
                if (trim($value) != "")
                {
                    $r[] = trim($value);
                }
            }
        }
        return $r;
    }
}
