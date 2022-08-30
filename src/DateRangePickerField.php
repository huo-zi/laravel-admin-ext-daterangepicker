<?php

namespace Huozi\Admin\DateRangePicker;

use Encore\Admin\Admin;
use Encore\Admin\Form\Field\Text;
use Illuminate\Support\Arr;

class DateRangePickerField extends Text
{

    use DateRangeOption;

    protected $icon = 'fa-calendar';

    public function __construct($column, $arguments = [])
    {
        if (is_array($column)) {
            $this->column = [
                'start' => $column[0],
                'end' => $column[1]
            ];

            $this->label = $this->formatLabel($arguments);
            $this->id = implode('_', $this->column);

            $this->setElementName($this->id);
            $this->attribute('name', '');
        } else {
            $this->single();
            parent::__construct($column, $arguments);
        }
    }

    /**
     * daterangepicker js
     */
    protected function pickerScript()
    {
        $options = $this->buildOptions();
        $locale = config('app.locale');

        Admin::script(<<<SCRIPT
            moment.locale('{$locale}');
            $('#{$this->id}').daterangepicker({$options});
SCRIPT);

        if (is_array($this->column)) {
            Admin::script(<<<SCRIPT
            $('#{$this->id}').on('apply.daterangepicker', function(ev, picker) {
                var range = $('#{$this->id}').val().split(' - ');
                $('#{$this->column['start']}').val(range[0]);
                $('#{$this->column['end']}').val(range[1]);
            });
SCRIPT);
        }
    }

    /**
     * append hidden fields
     */
    protected function appendHidden()
    {
        $start = old($this->column['start'], Arr::get($this->value(), 'start'));
        $end = old($this->column['end'], Arr::get($this->value(), 'end'));

        $this->append(<<<HIDDEN
            <input type="hidden" id="{$this->column['start']}" name="{$this->column['start']}" value="{$start}"/>
            <input type="hidden" id="{$this->column['end']}" name="{$this->column['end']}" value="{$end}"/>
HIDDEN);
    }

    protected function setValue($value)
    {
        $separator = Arr::get($this->options, 'locale.separator', ' - ');
        $value = implode($separator, array_map(function ($value) {
            if ($value instanceof \DateTime) {
                $value = $value->format('c');
            }
            return $value;
        }, (array) $value));
        $this->attribute('value', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        if (is_array($this->column)) {
            $this->setValue($this->value());
            $this->appendHidden();
        }

        $this->pickerScript();

        return parent::render();
    }

}
