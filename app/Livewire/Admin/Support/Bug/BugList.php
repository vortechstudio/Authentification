<?php

namespace App\Livewire\Admin\Support\Bug;

use Jira\Laravel\Facades\Jira;
use Livewire\Attributes\Title;
use Livewire\Component;

class BugList extends Component
{
    public $search = '';
    public $statusFilter = '';
    public $priorityFilter = '';
    public $composantFilter = '';

    private $searchRender = '';
    private $statusRender = '';
    private $priorityRender = '';
    private $composantRender = '';
    #[Title("Gestionnaire de Bugs - Powered by Jira Software")]
    public function render()
    {
        if($this->search != '') {
            $this->searchRender = str_replace($this->search, 'AND summary ~ '.$this->search, $this->search);
        } else {
            $this->searchRender = '';
        }

        if($this->priorityFilter != '') {
            $this->priorityRender = str_replace($this->priorityFilter, 'AND priority = '.$this->priorityFilter, $this->priorityFilter);
        } else {
            $this->priorityRender = '';
        }

        if($this->statusFilter != '') {
            $this->statusRender = str_replace($this->statusFilter, 'AND status = '.$this->statusFilter, $this->statusFilter);
        } else {
            $this->statusRender = '';
        }

        if($this->composantFilter != '') {
            $this->composantRender = str_replace($this->composantFilter, 'AND component = '.$this->composantFilter, $this->composantFilter);
        } else {
            $this->composantRender = '';
        }

        return view('livewire.admin.support.bug.bug-list', [
            "bugs" => Jira::issues()->search([
                "jql" => "project = 'Vortech Studio Helpdesk' {$this->searchRender} {$this->priorityFilter} AND issuetype = Bug {$this->statusRender} {$this->composantRender} ORDER BY created DESC",
            ])['issues']
        ])
            ->layout("components.layouts.admin");
    }

    public function refreshFilter()
    {
        $this->statusFilter = '';
        $this->priorityFilter = '';
        $this->search = '';
        $this->priorityRender = '';
        $this->statusRender = '';
        $this->searchRender = '';
    }
}
