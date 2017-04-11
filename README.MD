## php-output

轻量级多功能的打印调试工具。

全部功能：

> 所有方法都是不定参数

* `Output::var_dump();`         // 原生的var_dump打印，优化了换行。
* `Output::print_r();`          // 原生的print_r打印，增加了多个参数的支持。
* `Output::var_dump_plus();`    // 版的var_dump打印，美化之后的，类似xdebug的打印效果。
* `Output::console_log();`      // 将打印信息打印到浏览器的控制台上，打印的格式为js数据方式。
* `Output::console_var_dump();` // 将打印信息打印到浏览器的控制台上，打印的格式为var_dump()的字符串结果。


## 需求

PHP5.3+既可


## 效果图

![](../images/php-output.png "效果图")


## 简单使用

```php
<?php
require '../src/Output.php';

$data = array('key'=>'value', 1, 2);

// 打印到页面
Output::var_dump_plus($data);

// 打印到控制台
Output::console_log($data);

```
