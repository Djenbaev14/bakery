<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class PowerGridTable extends PowerGridComponent
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
                ->showRecordCount()
                ->showPerPage(perPage: 10, perPageValues: [0,10, 50, 100, 500]), 
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
     * @return Builder<\App\Models\User>
     */
    public function datasource(): Builder
    {
        return User::query();
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
            'role' => [
                'name',
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
            ->addColumn('id')
            ->addColumn('role_name', fn (User $model) => $model->role->name)
            ->addColumn('user_id', fn (User $model) => $model->id)
            ->addColumn('created_at_formatted', fn (User $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */
    
    public function configure(): void
    {
        $this->setDefaultSort('id', 'desc');
    }
     /**
      * PowerGrid Columns.
      *
      * @return array<int, Column>
      */
    public function columns(): array
    {
        return [
            Column::make('id', 'id')->sortable(),
            Column::make('Имя', 'username')->searchable()->sortable(),
            Column::make('Тип', 'role_name','role.name')->searchable(),
            Column::make('Телефон номер', 'phone')->sortable(),
            Column::make('Обновлено', 'updated_at')->sortable(),
            Column::make('Создано', 'created_at')
                ->sortable(),

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
            Filter::inputText('username'),

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
     * PowerGrid User Action Buttons.
     *
     * @return array<int, Button>
     */

    
    public function actions(): array
    {
       return [

            // Button::add('toggle-detail')
            // ->toggleDetail(),
           Button::make('edit','<i class="fa fa-edit"></i>')
               ->class('btn btn-sm btn-primary rounded')
               ->route('users.edit',['user'=>'user_id'])
                ->method('get')
               ->target('_self'),

           Button::make('view', '<i class="fa fa-key"></i>')
               ->class('btn btn-sm btn-success rounded')
               ->route('user.key', ['id'=>'user_id'])
               ->method('post')
               ->target('_self'),
        ];
    }
    
    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid User Action Rules.
     *
     * @return array<int, RuleActions>
     */

    
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('view')
                ->when(fn($user) => $user->role_id == 1)
                ->hide(),
        ];
    }
    
}
