<?php

/**
 * 轻量级多功能的打印调试工具
 * 
 * TIP:
 * 关闭xdebug的var_dump重写(php.ini): xdebug.overload_var_dump=Off
 * 
 * @author  詹光成 <14712905@qq.com>
 * @date 2017-04-11
 */
class Output
{
    public static function var_dump()
    {
        ob_start();
        echo PHP_SAPI != 'cli' ? "<pre>\n" : '';
        call_user_func_array('var_dump', func_get_args());
        echo preg_replace('/=>\n\s+/', '=> ', ob_get_clean());
        echo PHP_SAPI != 'cli' ? "</pre>\n" : '';
    }

    public static function print_r()
    {
        echo PHP_SAPI != 'cli' ? "<pre>\n" : '';
        foreach (func_get_args() as $value) {
            if ($value === true) {
                echo 'true';
            } elseif ($value === false) {
                echo 'false';
            } elseif ($value === null) {
                echo 'NULL';
            } else {
                call_user_func('print_r', $value);
            }
            echo PHP_EOL;
        }
        echo PHP_SAPI != 'cli' ? "</pre>\n" : '';
    }

    public static function console_log()
    {
        self::console(func_get_args(), 'js');
    }

    public static function console_var_dump()
    {
        self::console(func_get_args(), 'php');
    }

    public static function var_dump_plus()
    {
        static $flag = 0;
        if ($flag === 0) {
            $flag = 1;
            echo '<style>pre.var_dump{border:1px solid #ddd;background-color:#f5f5f5;color:#000;font-size:14px;border-radius:5px;padding:10px;font-family:Monaco,Menlo,Consolas,monospace; } .var_dump .string{color:#cc0000; } .var_dump .boolean{color:#77527D;font-size:16px;font-weight:bold; } .var_dump .array{font-weight:bold; } .var_dump .int{color:#4E9A06;font-size:16px;font-weight:bold; } .var_dump .float{color:#F57900;font-size:16px;font-weight:bold; } .var_dump .null{color:red; } .var_dump .object{font-weight:bold; } .var_dump .index{color:#000; } .var_dump .symbol{color:#888A85; } .var_dump .length{font-style:italic;color:#888A85; }</style>';
        }
        $args = func_get_args();
        $output_str = array();
        foreach ($args as $v) {
            if (is_null($v)) {
                $output = '<span class="null">NULL</span>';
            } else {
                ob_start();
                var_dump($v);
                $output = ob_get_clean();
                $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
                $output = preg_replace('/\["(.*?)"\] =>/','<span class="string">\'\1\' </span><span class="symbol">=></span>',$output);
                $output = preg_replace('/string\((.*?)\) "(.*)"/','string <span class="string">\'\2\'</span> <span class="length">(length=\1)</span>',$output);
                $output = preg_replace('/bool\((true)\)/','boolean <span class="boolean">\1</span>',$output);
                $output = preg_replace('/bool\((false)\)/','boolean <span class="boolean">\1</span>',$output);
                $output = preg_replace('/(array\(\d+\))/','<span class="array">\1</span>',$output);
                $output = preg_replace('/int\((\d+)\)/','int <span class="int">\1</span>',$output);
                $output = preg_replace('/float\(([\d\.]+)\)/','float <span class="float">\1</span>',$output);
                $output = preg_replace('/\[(\d+)\] =>/','<span class="index">\1 </span><span class="symbol">=></span>',$output);
                $output = preg_replace('/=><\/span> NULL/','=></span> <span class="null">NULL</span>',$output);
                $output = preg_replace('/resource\((\d+)\) of type \(stream\)/','resource(<span class="int">\1</span>) of type (stream)',$output);
                $output = preg_replace('/object\((.*?)\)#(\d+) \((\d+)\)/','<span class="object">object(\1)</span>#\2 (<span class="int">\3</span>)', $output);
            }
            $output_str[] = $output;
        }
        echo '<pre class="var_dump">', implode('<br>', $output_str), '</pre>', PHP_EOL;
    }

    private static function console(array $args, $type = 'js')
    {
        $label = $args[0];
        $label = str_replace('`', '', (is_string($label) || is_numeric($label) ? $label : gettype($label)));
        echo "<script>\n";
        echo 'console.groupCollapsed(`' . $label . "`);\n";
        if ($type == 'js') {
            $args  = array_map('Output::get_console_log', $args);
            $args  = array_map('json_encode', $args);
            echo 'console.log(' . implode(',', $args) . ");\n";
        } else {
            $args  = array_map('Output::get_var_dump', $args);
            echo 'console.log(`' . str_replace('`', '', implode("\n", $args)) . "`);\n";
        }
        echo "console.groupEnd();\n";
        echo "</script>\n";
    }

    private static function get_var_dump()
    {
        ob_start();
        call_user_func_array('var_dump', func_get_args());
        return preg_replace('/=>\n\s+/', '=> ', ob_get_clean());
    }

    private static function get_console_log($v)
    {
        $type = gettype($v);
        if (is_callable($v)) {
            $v = '[PHP Function]';
        } elseif ($type == 'resource') {
            $v = '[PHP Resource]';
        } elseif (is_array($v) || $type == 'object'){
            $v = array_map('Output::get_console_log', (array) $v);
        }
        return $v;
    }
}
