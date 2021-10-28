<?php

namespace App\Http\Livewire\Subjects;

use Livewire\Component;

class SubjectModal extends Component
{
    public $isModalOpen = false;
    public $deleteAll = false;

    protected $listeners = [
        'openModal'
    ];

    public function openModal()
    {
        $this->isModalOpen = !$this->isModalOpen;
    }

    public function updateSubjects()
    {


        $this->emitUp('updateSubjects', $this->deleteAll);
    }


    public function render()
    {
        return view('livewire.subjects.subject-modal');
    }
}
