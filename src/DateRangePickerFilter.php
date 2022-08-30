<?php

namespace Huozi\Admin\DateRangePicker;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid\Filter\AbstractFilter;
use Illuminate\Support\Arr;

class DateRangePickerFilter extends AbstractFilter
{

    use DateRangeOption;

    private $options = [];

    /**
     * @var \Closure
     */
    private $where;

    public $input;

    public function __construct($column, $label = '', \Closure $callback = null)
    {
        $this->column = $column;
        $this->label = $this->formatLabel($label);
        $this->id = $this->formatId($column);
        $this->where = $callback;

        $this->setPresenter(new DateRangePickerPresenter);
    }

    /**
     * {@inheritdoc}
     */
    public function condition($inputs)
    {
        if ($this->ignore || ! ($value = Arr::get($inputs, $this->column))) {
            return;
        }

        $this->value = $value;

        // custome where
        if ($this->where) {
            $this->input = $value;
            return $this->buildCondition($this->where->bindTo($this));
        }

        // whereBetween
        if (! Arr::get($this->options, 'singleDatePicker', false)) {
            $this->query = 'whereBetween';
            $values = explode(Arr::get($this->options, 'locale.separator', ' - '), $value);
            return $this->buildCondition($this->column, $values);
        }

        return parent::condition($inputs);
    }

    /**
     * {@inheritdoc}
     */
    protected function variables()
    {
        $this->pickerScript();

        return parent::variables();
    }

    /**
     * daterangepicker js
     */
    protected function pickerScript()
    {
        $locale = config('app.locale');
        $options = $this->buildOptions();

        Admin::script(<<<SCRIPT
        moment.locale('{$locale}');
        $('#{$this->id}').daterangepicker({$options});
SCRIPT);
    }

}
