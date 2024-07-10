<?php

namespace App\Http\Livewire;

use App\Models\Sale;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class SearchSalesa extends PowerGridComponent
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
                ->showPerPage(perPage: 10, perPageValues: [0,10, 50, 100, 500])
                ->showRecordCount(),
        ];
    }

    public string $sortField = 'created_at'; 

    public string $sortDirection = 'desc';
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
     * @return Builder<\App\Models\Sale>
     */
    public function datasource(): Builder
    {
        return Sale::query();
                // ->join('clients','sales.client_id','=','clients.id')
                // ->join('users','sales.user_id','=','users.id')
                // ->join('breads','sales.bread_id','=','breads.id')
                // ->select('sales.*','clients.name as client_name','users.username as username','breads.name as bread_name')  ;
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
            'user' => [
                'username',
            ],
 
            'client' => [
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
            ->addColumn('sale_id', fn ($sale) => e($sale->id))
            // ->addColumn('bread_name', fn ($sale) => e($sale->bread->name))
            // ->addColumn('responsible_name', fn ($sale) => e($sale->user->username))
            // ->addColumn('client_name', fn ($sale) => e($sale->client->name))
            ->addColumn('price', fn ($sale) => e(number_format($sale->price).' сум'))
            ->addColumn('cost_price', fn ($sale) => e(number_format($sale->price * $sale->quantity).' сум'))
            ->addColumn('debt', fn ($sale) => e(number_format($sale->price * $sale->quantity).' сум'))
            ->addColumn('paid', fn ($sale) => e(number_format($sale->sale_history->sum('paid')).' сум'))
            ->addColumn('quantity', fn ($sale) => e($sale->quantity));
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
            // Column::make('Маҳсулот номи', 'bread_name')->sortable(),
            // Column::make('Маъсул', 'username')->searchable()->sortable(),
            // Column::make('Xаридор', 'client_name')->searchable()->sortable(),
            Column::make('Товар нархи', 'price'),
            Column::make('Тан нарх', 'cost_price'),
            Column::make('Толанган нарх', 'paid'),
            Column::make('Карз нархи', 'debt'),
            Column::make('Миқдор (дона)', 'quantity'),
            Column::make('Вақти', 'created_at')->sortable(),
            // Column::make('Действия', 'id'),

        ];
    }
    /**
     * PowerGrid Filters.
     *
     * @return array<int, Filter>
     */

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid Sale Action Buttons.
     *
     * @return array<int, Button>
     */

    
    public function actions(): array
    {
       return [
        //    Button::make('edit', 'Edit')
        //        ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
        //        ->route('sale.edit', function(\App\Models\Sale $model) {
        //             return $model->id;
        //        }),

           Button::make('destroy', 'Delete')
               ->class('btn btn-danger btn-sm')
               ->route('sales.destroy', ['id'=>'sale_id'])
               ->method('delete')
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
     * PowerGrid Sale Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($sale) => $sale->id === 1)
                ->hide(),
        ];
    }
    */
}
