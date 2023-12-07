<?php

namespace App\Livewire;

use IvanoMatteo\LaravelDeviceTracking\Models\DeviceUser;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class UserDeviceTable extends DataTableComponent
{
    protected $model = DeviceUser::class;

    public function configure(): void
    {
        // TODO: Implement configure() method.
        $this->setPrimaryKey('id');
        $this->setSearchStatus(false);
        $this->setLoadingPlaceholderStatus(true);
        $this->setLoadingPlaceholderContent('Chargement...');
    }

    public function columns(): array
    {
        // TODO: Implement columns() method.
        return [
            Column::make("Date", "device.created_at")
                ->sortable(),
            Column::make('Appareil', 'device.device_type')
                ->sortable(),
            Column::make('IP', 'device.ip'),
            Column::make('Pays')
                ->label(function($row, Column $column) {
                    return geoip($row['device.ip'])->country;
                })
                ->sortable(),
        ];
    }

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return DeviceUser::where('user_id', auth()->user()->id)->with('device');
    }
}
