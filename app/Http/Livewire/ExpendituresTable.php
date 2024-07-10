<?php

namespace App\Http\Livewire;

use App\Models\Expenditure;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class ExpendituresTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {

        return [
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\Expenditure>
     */
    public function datasource(): Builder
    {
        return Expenditure::query()
                ->leftJoin('expenditure__salaries', function ($expenditure_salaries) {
                $expenditure_salaries->on('expenditure__salaries.expenditure_id', '=', 'expenditures.id');
                    })
                ->join('users', function ($users) {
                $users->on('users.id', '=', 'expenditures.responsible_id');
                    })
                ->join('expenditure_types', function ($expenditure_types) {
                    $expenditure_types->on('expenditure_types.id', '=', 'expenditures.expenditure_type_id');
                        })
                ->select([
                    'expenditures.id',
                    'expenditures.price',
                    'expenditures.comment',
                    'expenditures.created_at',
                    'expenditure__salaries.user_id as user_name',
                    'users.username as responsible_name',
                    'expenditure_types.name as type',
                ]);
            
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [
            'user'=>[
                'username'
            ],
            'expenditure_salary'=>[
                'user'=>[
                    'username'
                ]
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
        ->addColumn('id');
        // ->addColumn('responsible_name',function($expenditure){return $expenditure->user->username;})
        // ->addColumn('user_name',function($expenditure){return $expenditure->expenditure_salary->count() > 0 ?  $expenditure->expenditure_salary[0]->user->username : '<span class="border border-info pl-1 pr-1 rounded text-info">none</span>';})
        // ->addColumn('type',function($expenditure){return $expenditure->expenditure_type->name;})
        // ->addColumn('price',function($expenditure){return number_format($expenditure->price).' сум';});
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

     /**
      * PowerGrid Columns.
      *
      * @return array<int, Column>
      */
    public function columns(): array
    {
        return [
            Column::make('Пользователь', 'user_name')->sortable(),
            Column::make('Маъсул', 'responsible_name')->searchable()->sortable(),
            Column::make('Комментария', 'comment')->searchable(),
            Column::make('Тип', 'type')->sortable(),
            Column::make('Количество', 'price')->sortable(),
            Column::make('Вақти', 'created_at')

        ];
    }

    /**
     * PowerGrid Filters.
     *
     * @return array<int, Filter>
     */
    public function filters(): array
    {
        return [
            Filter::inputText('responsible_name')
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid Expenditure Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('expenditure.edit', function(\App\Models\Expenditure $model) {
                    return $model->id;
               }),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('expenditure.destroy', function(\App\Models\Expenditure $model) {
                    return $model->id;
               })
               ->method('delete')
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Expenditure Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($expenditure) => $expenditure->id === 1)
                ->hide(),
        ];
    }
    */
}
