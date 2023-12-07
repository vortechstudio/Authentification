<?php

namespace App\Livewire\Table\Service;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\UserService;

class Inactive extends DataTableComponent
{
    protected $model = UserService::class;

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
            Column::make("Services", "service.name"),
            Column::make("Date de résiliation", "updated_at")
                ->format(function ($value) {
                    return $value->format("d M Y");
                }),
        ];
    }

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return UserService::where('user_services.status', 'inactive')->with('service');
    }
}
