<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Http\Requests\NovaRequest;

class Product extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Text::make(__('Name'), 'name')->sortable(),

            Text::make(__('Source'), 'source')->sortable(),

            Currency::make(__('Source Price'), 'source_price')->sortable(),

            Number::make(__('Default Markup'), 'default_markup')
                ->step(0.01)
                ->displayUsing(function ($markup) {
                    return ($markup * 100).'% ($'.(($this->source_price * $markup) + $this->source_price).')';
                })
                ->sortable(),

            BelongsToMany::make('Orders')
                ->fields(function ($request, $relatedModel) {
                    return [
                        Number::make('Quantity'),
                    ];
                }),

            BelongsToMany::make('Customers')
                ->fields(function ($request, $relatedModel) {
                    return [
                        Number::make('Markup')
                            ->step(0.01)
                            ->displayUsing(function ($markup) use ($relatedModel) {
                                return $markup ? ($markup * 100).'% ($'.(($relatedModel->pivot->pivotParent->source_price * $markup) + $relatedModel->pivot->pivotParent->source_price).')' : ($relatedModel->pivot->pivotParent->default_markup * 100).'% ($'.(($relatedModel->pivot->pivotParent->source_price * $relatedModel->pivot->pivotParent->default_markup) + $relatedModel->pivot->pivotParent->source_price).') (default)';
                            }),
                    ];
                }),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
