<?php

namespace Huozi\Admin\DateRangePicker;

use Encore\Admin\Extension;

class DateRangePicker extends Extension
{
    const NAME = 'daterangepicker';

    public $name = self::NAME;

    /**
     * @var array
     */
    public $css = [
        'vendor/huo-zi/daterangepicker/daterangepicker.min.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'vendor/huo-zi/daterangepicker/daterangepicker.min.js',
    ];

    public $views = __DIR__.'/../resources/views';

    public $assets = __DIR__.'/../resources/assets';

}