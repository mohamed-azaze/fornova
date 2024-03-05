<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\MultiselectField\Multiselect;

class Tickets extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Tickets>
     */
    public static $model = \App\Models\Ticket::class;

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
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Users', 'users', User::class),
            Text::make('body')->onlyOnIndex(),
            Text::make('subject'),
            BelongsTo::make('Departments', 'departments', Departments::class)
                ->hideFromIndex(),
            BelongsTo::make('Statuses', 'statuses', Statuses::class),
            BelongsTo::make('Priorities', 'priorities', Priorities::class),
            Textarea::make('TICKET SUMMARY', 'body'),
            Multiselect::make('labels')
                ->belongsToMany(\App\Nova\Labels::class, false)
                ->rules('required')
                ->showOnCreating(false),
            BelongsToMany::make('labels', 'labels', Labels::class),
            Multiselect::make('CannedReplies')
                ->belongsToMany(\App\Nova\CannedReplies::class, false)
                ->showOnCreating(false),
            BelongsToMany::make('CannedReplies', 'cannedReplies', CannedReplies::class),
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
        return [
            ID::make()->sortable(),

        ];
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