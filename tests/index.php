<?php
require '../src/Output.php';

// 测试对象数据
$object = new stdClass;
$object->name = 'Grass';
$object->age = 18;
$object->diy = array('key'=>'value', 2, 3, array(new stdClass, fopen(__FILE__, 'r')));

// 原生的var_dump打印, 优化了换行
echo '<h1>Output::var_dump()</h1>';
Output::var_dump('path.tag', 2, 3.14, true, 'String...', array('key'=>'value', 2, 3, array(new stdClass, fopen(__FILE__, 'r'))), $object, fopen(__FILE__, 'r'), function(){}, null);

// 原生的print_r打印, 增加了多个参数的支持(不建议使用)
echo '<h1>Output::print_r()</h1>';
Output::print_r('path.tag', 2, 3.14, true, 'String...', array('key'=>'value', 2, 3, array(new stdClass, fopen(__FILE__, 'r'))), $object, fopen(__FILE__, 'r'), function(){}, null);

// 升级版的var_dump打印, 美化之后的, 类似xdebug的打印效果
echo '<h1>Output::var_dump_plus()</h1>';
Output::var_dump_plus('path.tag', 2, 3.14, true, 'String...', array('key'=>'value', 2, 3, array(new stdClass, fopen(__FILE__, 'r'))), $object, fopen(__FILE__, 'r'), function(){}, null);

// 将打印信息打印到浏览器的控制台上, 打印的格式为js数据方式
echo '<h1>Output::console_log()</h1>';
echo 'See debug messages in JavaScript Console(Ctrl+Shift+J)';
Output::console_log('Output::console_log()', 2, 3.14, true, 'String...', array('key'=>'value', 2, 3, array(new stdClass, fopen(__FILE__, 'r'))), $object, fopen(__FILE__, 'r'), function(){}, null);

// 将打印信息打印到浏览器的控制台上, 打印的格式为var_dump()的字符串结果
echo '<h1>Output::console_var_dump()</h1>';
echo 'See debug messages in JavaScript Console(Ctrl+Shift+J)';
Output::console_var_dump('Output::console_var_dump()', 2, 3.14, true, 'String...', array('key'=>'value', 2, 3, array(new stdClass, fopen(__FILE__, 'r'))), $object, fopen(__FILE__, 'r'), function(){}, null);
