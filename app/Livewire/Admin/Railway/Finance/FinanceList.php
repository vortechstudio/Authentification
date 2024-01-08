<?php

namespace App\Livewire\Admin\Railway\Finance;

use App\Models\Railway\RailwayBanque;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Str;

class FinanceList extends Component
{
    use LivewireAlert, WithFileUploads, WithPagination;

    public string $search = '';

    public int $perPage = 5;

    public string $orderField = 'name';

    public string $orderDirection = 'ASC';

    protected array $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'name'],
        'orderDirection' => ['except' => 'ASC'],
    ];

    public string $name = '';

    public string $description = '';

    public int $minimal_interest = 0;

    public int $maximal_interest = 0;

    public int $maximal_account_express_base = 0;

    public int $maximal_account_public_base = 0;

    public bool $actualize = false;

    public $logo;

    #[Title('Gestion des services bancaires')]
    public function render()
    {
        return view('livewire.admin.railway.finance.finance-list', [
            'banks' => RailwayBanque::where('name', 'like', "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ])
            ->layout('components.layouts.admin');
    }

    /**
     * @codeCoverageIgnore
     */
    public function setOrderField(string $name)
    {
        if ($name === $this->orderField) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->orderField = $name;
            $this->reset('orderDirection');
        }
    }

    private function resetField()
    {
        $this->name = '';
        $this->description = '';
        $this->minimal_interest = 0;
        $this->maximal_interest = 0;
        $this->maximal_account_express_base = 0;
        $this->maximal_account_public_base = 0;
        $this->logo = null;
        $this->actualize = false;
    }

    public function adding()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'minimal_interest' => 'required',
            'maximal_interest' => 'required',
            'maximal_account_express_base' => 'required',
            'maximal_account_public_base' => 'required',
        ]);

        $bank = RailwayBanque::create([
            'uuid' => \Str::uuid(),
            'name' => $this->name,
            'description' => $this->description,
            'minimal_interest' => $this->minimal_interest,
            'maximal_interest' => $this->maximal_interest,
            'maximal_account_express_base' => $this->maximal_account_express_base,
            'maximal_account_public_base' => $this->maximal_account_public_base,
        ]);

        if (isset($this->logo)) {
            $this->logo->storeAs('/logos/banks', Str::slug($this->name).'.png', 'public');
        }

        if ($this->actualize) {
            $bank->flux()->create([
                'date' => now()->startOfDay(),
                'interest' => generateRandomFloat($bank->minimal_interest, $bank->maximal_interest),
            ]);
        }

        $this->resetField();

        $this->alert('success', 'Le banque a bien été ajoutée');
    }

    public function actualizeAll()
    {
        foreach (RailwayBanque::all() as $bank) {
            if (! $bank->flux()->where('date', now()->startOfDay())->exists()) {
                $bank->flux()->create([
                    'date' => now()->startOfDay(),
                    'interest' => generateRandomFloat($bank->minimal_interest, $bank->maximal_interest),
                ]);
            }
        }

        $this->alert('success', 'Tous les flux sont actualisés');
    }

    public function delete($id)
    {
        $bank = RailwayBanque::find($id);
        $bank->delete();

        \Storage::disk('public')->delete('/logos/banks/'.Str::slug($bank->name).'.png');

        $this->alert('success', 'Le banque a bien été supprimée');
    }
}
