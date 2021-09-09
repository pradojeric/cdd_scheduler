<?php

namespace App\Http\Livewire\Subjects;

use App\Models\Configurations\CurriculumSubject;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{

    public $allSubjects;

    public function importSubjects()
    {
        $this->resetErrorBag();

        $allSubjects = CurriculumSubject::leftJoin('curricula', 'curricula.id', 'curriculum_id')
            ->leftJoin('courses', 'courses.id', 'curricula.course_id')
            ->select('*', 'curriculum_subjects.code as code')
            ->get();

        try {
            DB::transaction(function () use ($allSubjects) {

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

    public function updateSubjects()
    {
        $this->resetErrorBag();

        $allSubjects = CurriculumSubject::leftJoin('curricula', 'curricula.id', 'curriculum_id')
            ->leftJoin('courses', 'courses.id', 'curricula.course_id')
            ->select('*', 'curriculum_subjects.code as code')
            ->get();

        try {
            DB::transaction(function () use ($allSubjects) {

                $oldSubjects = Subject::all();

                $diff = $oldSubjects->diffKeys($allSubjects);

                Subject::destroy($diff);

                foreach($allSubjects as $subject)
                {
                    Subject::updateOrCreate(
                        ['uuid' => $subject->uuid],
                        $subject->only([
                            'uuid',
                            'course_id', 'year', 'term', 'code', 'title', 'curriculum_id',
                            'lec_hours', 'lec_units', 'lab_hours', 'lab_units',
                            'prereq',
                        ]
                    ));
                }

                session()->flash('success', 'Successfully updated subjects');
            });
        } catch (\Exception $e) {
            //throw $th;
            $this->addError('error', 'Sorry! There seems to be an error importing Subjects! Contact Administrator!');
        }
    }

    public function render()
    {
        return view('livewire.subjects.index', [
            'subjects' => Subject::orderBy('course_id')->orderBy('year')->orderBy('term')->get(),
        ]);
    }
}
