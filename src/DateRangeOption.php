<?php

namespace Huozi\Admin\DateRangePicker;

use Illuminate\Support\Arr;

trait DateRangeOption
{

    public function option($key, $value)
    {
        Arr::set($this->options, $key, $value);
        return $this;
    }

    public function format($format = 'YYYY-MM-DD')
    {
        $this->option('locale.format', $format);
        if ($format === '' || preg_match('/(H|h|m|s)/', $format)) {
            $this->option('timePicker', true);
        }
        return $this;
    }

    public function single($value = true)
    {
        return $this->option('singleDatePicker', $value);
    }

}
