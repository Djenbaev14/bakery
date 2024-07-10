<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;

class UserTable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Имя", "username")
                ->sortable()
                ->searchable(),
            Column::make("Тип", "role.r_name")
                ->sortable()
                ->searchable(),
            Column::make("ТЕЛЕФОН НОМЕР", "phone")
                ->sortable()
                ->searchable(),
            Column::make("ОБНОВЛЕНО", "updated_at")
                ->sortable()
                ->searchable(),
               
        ];
    }
}
