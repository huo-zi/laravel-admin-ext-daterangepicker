Daterangepicker extension for laravel-admin
======
laravel-admin扩展，基于 [daterangepicker](http://www.daterangepicker.com/) 扩展 Field 及 Filter

## 安装

```bash
composer require huo-zi/laravel-admin-ext-daterangepicker
```

发布静态资源
```bash
php artisan vendor:publish --tag=laravel-admin-daterangepicker
```

## 配置

在`config/admin.php`文件的`extensions`节点，可以增加这个扩展的配置
```php

    'extensions' => [
        'daterangepicker' => [
            'enable' => true,
            // 可以在这里配置全局的daterangepicker配置
            'config' => [

            ]
        ]
    ]

```
## 使用

### 表单中使用

单时间字段可以使用：

```php
$form->daterangepicker('date_field', 'date_label');
```

如果是双字段的时间段，可以这样使用：

```php
$form->daterangepicker(['date_start_field', 'date_end_field'], 'date_label');
```

如果需要自定义日期格式化：

```php
$form->daterangepicker(...)->format('YYYY-MM-DD');
```

强制使用时间段：

```php
$form->daterangepicker(...)->single(false);
```

其他`daterangepicker`的配置：

```php
$form->daterangepicker(...)->option('option_name', 'option_value');
$form->daterangepicker(...)->option('option_parent.option_child', 'option_value');
```

### 表格筛选中使用

默认为筛选时间段：

```php
$filter->daterangepicker('filter_field', 'filter_label');
```

时间筛选：

```php
$filter->daterangepicker('filter_field', 'filter_label')->single();
```

自定义筛选：

```php
$filter->daterangepicker('filter_field', 'filter_label', function($query) {
  $query->where(...);
});
```

License
------------
Licensed under [The MIT License (MIT)](LICENSE).
