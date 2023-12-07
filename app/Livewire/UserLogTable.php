<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\UserLog;

class UserLogTable extends DataTableComponent
{
    protected $model = UserLog::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchStatus(false);
        $this->setLoadingPlaceholderStatus(true);
        $this->setLoadingPlaceholderContent('Chargement...');
    }

    public function columns(): array
    {
        return [
            Column::make("Date", "created_at")
                ->sortable(),
            Column::make("Action", "action"),
        ];
    }
}
