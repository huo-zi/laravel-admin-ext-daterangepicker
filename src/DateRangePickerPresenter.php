<?php

namespace Huozi\Admin\DateRangePicker;

use Encore\Admin\Grid\Filter\Presenter\Presenter;

class DateRangePickerPresenter extends Presenter
{

    public function view(): string
    {
        return 'admin::filter.datetime';
    }

    public function variables(): array
    {
        return [
            'group' => $this->filter->group,
        ];
    }
}
