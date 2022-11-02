<?php

namespace CompanyApi\DateFilter;

use Carbon\Carbon;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class DateFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'date-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        $values = explode('to', $value);

        $from = Carbon::parse($values[0])->startOfDay();
        $to = null;
        if (isset($values[1])) {
            $to = Carbon::parse($values[1])->endOfDay();
        }

        return $query
            ->when($from, function ($query) use ($from) {
                return $query->whereDate('created_at', '>=', $from);
            })
            ->when($to, function ($query) use ($to) {
                return $query->whereDate('created_at', '<=', $to);
            });
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return [];
    }
}
