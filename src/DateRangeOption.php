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

    public function ranges($rangesJson)
    {
        $this->options['ranges'] = $rangesJson;
    }

    public function buildOptions()
    {
        $this->options += DateRangePicker::config('config', []);

        $this->options['locale']['applyLabel'] = Arr::get($this->options, 'locale.applyLabel', __('admin.confirm'));
        $this->options['locale']['cancelLabel'] = Arr::get($this->options, 'locale.cancelLabel', __('admin.cancel'));
        $this->options['locale']['format'] = Arr::get($this->options, 'locale.format', 'YYYY-MM-DD');

        if ($ranges = $this->options['ranges'] ?? '') {
            $ranges = sprintf(',ranges:%s', $ranges);
            unset($this->options['ranges']);
        }

        $options = json_encode($this->options);
        return $options . $ranges;
    }

}
