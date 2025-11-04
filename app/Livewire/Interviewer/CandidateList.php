<?php
// app/Livewire/Interviewer/CandidateList.php

namespace App\Livewire\Interviewer;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class CandidateList extends Component
{
    use WithPagination;

    public $search = '';
    public $positionFilter = '';
    public $statusFilter = 'active';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPositionFilter(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function getCandidatesProperty()
    {
        return User::where('role', 'candidate')
            ->with('candidateProfile')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->positionFilter, function ($query) {
                $query->whereHas('candidateProfile', function ($q) {
                    $q->where('desired_position', $this->positionFilter);
                });
            })
            ->when($this->statusFilter, function ($query) {
                if ($this->statusFilter === 'active') {
                    $query->where('is_active', true);
                } elseif ($this->statusFilter === 'inactive') {
                    $query->where('is_active', false);
                }
            })
            ->latest()
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.interviewer.candidate-list', [
            'candidates' => $this->candidates,
        ]);
    }
}