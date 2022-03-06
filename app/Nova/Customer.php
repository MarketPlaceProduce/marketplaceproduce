<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Http\Requests\NovaRequest;

class Customer extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Customer::class;

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
            
            Textarea::make(__('Address'), 'address')
                ->alwaysShow()
                ->rows(2)
                ->showOnIndex()
                ->withMeta(['extraAttributes' => [
                    'placeholder' => "530 NW 23rd St\nOklahoma City, OK 73103"]
                ]),
            
            Text::make(__('Contact Name'), 'contact_name')->sortable(),

            Text::make(__('Contact Email'), 'contact_email')->sortable(),

            Text::make(__('Contact Phone'), 'contact_phone')->sortable(),

            HasMany::make('Orders'),

            BelongsToMany::make('Products')
                ->fields(function ($request, $relatedModel) {
                    return [
                        Number::make('Markup')
                            ->step(0.01)
                            ->displayUsing(function ($markup) use ($relatedModel) {
                                return $markup ? ($markup * 100).'% ($'.(($relatedModel->source_price * $markup) + $relatedModel->source_price).')' : ($relatedModel->default_markup * 100).'% ($'.(($relatedModel->source_price * $relatedModel->default_markup) + $relatedModel->source_price).') (default)';
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
