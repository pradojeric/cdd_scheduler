<?php

namespace App\Http\Livewire\Others;

use App\Models\Faculty;
use App\Models\FacultySubject;
use App\Models\Subject;
use Livewire\Component;

class PreferredSubjects extends Component
{
    public $faculty;
    public $isModalOpen;

    public $search;
    public $subjects = [];

    protected $rules = [
        'subjects.*' => 'nullable'
    ];

    public function mount(Faculty $faculty)
    {
        $this->faculty = $faculty;
    }

    public function addPreferredSubjects()
    {
        $this->isModalOpen = true;

        if(count($this->faculty->preferredSubjects) > 0) {

            $this->subjects = $this->faculty->preferredSubjects->mapWithKeys(function($item){
                return [$item->subject_code => $item->subject_code];
            });
        }

    }

    public function updatePreferredSubjects()
    {
        $this->faculty->preferredSubjects()->delete();

        $subjectArray = collect($this->subjects)->filter()->values()->all();

        $subjects = Subject::whereIn('id', $subjectArray)->select('code as subject_code', 'title as subject_title')->get();

        $this->faculty->preferredSubjects()->createMany($subjects->toArray());

        return redirect()->route('faculties.show', $this->faculty);
    }

    public function close()
    {
        $this->reset('isModalOpen', 'search', 'subjects');
    }

    public function render()
    {
        $allSubjects = Subject::when($this->search != '', function($query){
            $query->where('code', 'like', '%'.$this->search.'%')
                ->orWhere('title', 'like', '%'.$this->search.'%');
        })->orderBy('code')->get()->unique('code');

        return view('livewire.others.preferred-subjects', [
            'allSubjects' => $allSubjects,
        ]);
    }
}
