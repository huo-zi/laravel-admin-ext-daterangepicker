<?php

namespace Huozi\Admin\DateRangePicker;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid\Filter;
use Illuminate\Support\ServiceProvider;

class DateRangePickerServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(DateRangePicker $extension)
    {
        if (! DateRangePicker::boot()) {
            return ;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, DateRangePicker::NAME);
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/huo-zi/' . DateRangePicker::NAME)],
                'laravel-admin-' . DateRangePicker::NAME
            );
        }

        Admin::booting(function () {
            Form::extend('daterangepicker', DateRangePickerField::class);
            Filter::extend('daterangepicker', DateRangePickerFilter::class);
        });
    }
}