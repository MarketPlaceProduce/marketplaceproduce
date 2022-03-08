<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Http\Requests\NovaRequest;

class Order extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Order::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public function title()
    {
        return "{$this->customer->name} - {$this->deliver_at}";
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
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

            BelongsTo::make('Customer'),

            DateTime::make('Deliver At')->format('DD MMM YYYY'),

            Badge::make('Status')->map([
                'pending' => 'info',
                'invoiced' => 'warning',
                'rejected' => 'danger',
                'delivered' => 'success',
            ]),

            Select::make('Status')->options([
                'pending' => 'Pending',
                'invoiced' => 'Invoiced',
                'rejected' => 'Rejected',
                'delivered' => 'Delivered',
            ])->onlyOnForms(),

            Text::make('Total', function ($model) {
                if (!count($model->products)) {
                    return '$0.00';
                }

                $sum = $model->products->sum(function ($product) use ($model) {
                    $customerMarkup = $product->customers->find($model->customer_id)->pivot->markup;

                    if ($customerMarkup) {
                        return (($product->source_price * $customerMarkup) + $product->source_price) * $product->pivot->quantity;
                    } else {
                        return (($product->source_price * $product->default_markup) + $product->source_price) * $product->pivot->quantity;
                    }
                });

                $sourceSum = $model->products->sum(function ($product) {
                    return $product->source_price * $product->pivot->quantity;
                });

                return '$'.number_format($sum, 2).' ('.round(($sum / $sourceSum - 1) * 100).'% Markup)';
            })
                ->readonly()
                ->sortable(),

            BelongsToMany::make('Products')
                ->fields(function ($request, $relatedModel) {
                    return [
                        Number::make('Quantity')->step(0.01),

                        Number::make('Markup', function ($pivot) use ($relatedModel) {
                            if (!$relatedModel->customers) {
                                return;
                            }

                            $customerMarkup = $relatedModel->customers->find($relatedModel->pivot->pivotParent->customer_id)->pivot->markup;

                            if ($customerMarkup) {
                                return ($customerMarkup * 100).'% ($'.number_format(($relatedModel->source_price * $customerMarkup) + $relatedModel->source_price, 2).')';
                            } else {
                                return ($relatedModel->default_markup * 100).'% ($'.number_format(($relatedModel->source_price * $relatedModel->default_markup) + $relatedModel->source_price, 2).') (default)';
                            }
                        })
                            ->step(0.01)
                            ->readonly(),
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
