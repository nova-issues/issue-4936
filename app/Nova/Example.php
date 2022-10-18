<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Example extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Example::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

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
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Select::make('Field Type')
                ->options([
                    'text' => 'Text',
                    'number' => 'Number',
                ])
                ->displayUsingLabels(),

            Text::make('Field Value')
                ->exceptOnForms(),

            Number::make('Number', 'field_value')
                ->help('Number test')
                ->dependsOn(
                    ['field_type'],
                    function (Number $field, NovaRequest $request, FormData $formData) {
                        if ($formData->field_type == 'number') {
                            $field
                                ->show()
                                ->rules('required');
                        } else {
                            $field
                                ->hide();
                        }
                    }
                )->onlyOnForms(),

            Text::make('Text', 'field_value')
                ->help('Text test')
                ->dependsOn(
                    ['field_type'],
                    function (Text $field, NovaRequest $request, FormData $formData) {
                        if ($formData->field_type == 'text') {
                            $field
                                ->show()
                                ->rules('required');
                        } else {
                            $field
                                ->hide();
                        }
                    }
                )->onlyOnForms(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
