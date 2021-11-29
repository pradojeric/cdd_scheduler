<?php

namespace App\Http\Livewire\Subjects;

use App\Models\Configurations\CurriculumSubject;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $allSubjects;
    public $perPage = 10;
    public $pages = [
        10, 25, 50, 100
    ];

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    protected $listeners = [
        'updateSubjects',
    ];



    public function importSubjects()
    {
        $this->resetErrorBag();

        try {
            DB::transaction(function () {
                $allSubjects = CurriculumSubject::leftJoin('curricula', 'curricula.id', 'curriculum_id')
                    ->leftJoin('courses', 'courses.id', 'curricula.course_id')
                    ->select('*', 'curriculum_subjects.code as code')
                    ->where('curricula.active', 1)
                    ->get();

                foreach($allSubjects as $subject)
                {
                    Subject::create($subject->only([
                        'uuid',
                        'course_id', 'year', 'term', 'code', 'title', 'curriculum_id',
                        'lec_hours', 'lec_units', 'lab_hours', 'lab_units',
                        'prereq',
                    ]));
                }
                session()->flash('success', 'Successfully imported subjects');
            });
        } catch (\Exception $e) {
            //throw $th;

            $this->addError('error', 'Sorry! There seems to be an error importing Subjects! Contact Administrator!');
        }
    }

    public function updateSubjects($delete = false)
    {
        $this->resetErrorBag();

        try {
            DB::transaction(function () use ($delete) {

                $allSubjects = CurriculumSubject::leftJoin('curricula', 'curricula.id', 'curriculum_id')
                        ->leftJoin('courses', 'courses.id', 'curricula.course_id')
                        ->when($delete, function($query) {
                            $query->where('curricula.active', true);
                        })
                        ->select('*', 'curriculum_subjects.code as code')
                        ->get();


                if($delete){
                    $oldSubjects = Subject::all();

                    $diff = $oldSubjects->diff($allSubjects);

                    Subject::destroy($diff);
                }

                foreach($allSubjects as $subject)
                {
                    Subject::updateOrCreate(
                        [
                            'uuid' => $subject->uuid
                        ],
                        $subject->only([
                            'uuid',
                            'course_id', 'year', 'term', 'code', 'title', 'curriculum_id',
                            'lec_hours', 'lec_units', 'lab_hours', 'lab_units',
                            'prereq', 'active',
                        ]
                    ));
                }

                session()->flash('success', 'Successfully updated subjects');
            });

            $this->emit('openModal');
        } catch (\Exception $e) {
            //throw $th;
            $this->addError('error', 'Sorry! There seems to be an error importing Subjects! Contact Administrator!');
        }
    }

    public function removeSubject($id)
    {
        //
        dd($id);
        Subject::find($id)->delete();
    }

    public function render()
    {
        return view('livewire.subjects.index', [
            'subjects' => Subject::with('course')->orderBy('course_id')->orderBy('code')->orderBy('year')->orderBy('term')->paginate($this->perPage),
        ]);
    }
}
