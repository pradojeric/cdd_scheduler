<?php

namespace App\Http\Livewire\Configurations;

use Exception;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Configurations\Course;

class CurriculumCreate extends Component
{
    public Course $course;

    public $effective_sy;
    public $description;

    public $subjects = [
        [
            'term' => [
                [
                    [
                        'code' => '',
                        'title' => '',
                        'lech' => '',
                        'lech' => '',
                        'lecu' => '0',
                        'labu' => '0',
                        'total' => '',
                        'prereq' => '',
                    ],
                ]
            ],
        ]
    ];

    public $years = [
        'First',
        'Second',
        'Third',
        'Fourth',
        'Fifth',
        'Sixth?'
    ];
    public $terms = [
        '1st Semester',
        '2nd Semester',
        'Summer'
    ];

    protected $rules = [
        'effective_sy' => 'required',
        'description' => 'required',
        'subjects.*.term.*.*.code' => 'required',
        'subjects.*.term.*.*.title' => 'required',
        'subjects.*.term.*.*.lech' => 'required|numeric',
        'subjects.*.term.*.*.labh' => 'required|numeric',
        'subjects.*.term.*.*.lecu' => 'required|numeric',
        'subjects.*.term.*.*.labu' => 'required|numeric',
        'subjects.*.term.*.*.total' => 'required|numeric',
        'subjects.*.term.*.*.prereq' => 'nullable',
    ];

    public function mount(Course $course)
    {
        $this->course = $course;
    }

    public function addYear()
    {
        $this->subjects[] = [
            'term' => [
                [
                    [

                        'code' => '',
                        'title' => '',
                        'lech' => '',
                        'lech' => '',
                        'lecu' => '0',
                        'labu' => '0',
                        'total' => '',
                        'prereq' => '',
                    ]
                ],
            ],
        ];
    }

    public function addTerm($i)
    {
        $this->subjects[$i]['term'][] = [
            [
                'code' => '',
                'title' => '',
                'lech' => '',
                'lech' => '',
                'lecu' => '0',
                'labu' => '0',
                'total' => '',
                'prereq' => '',
            ]
        ];
    }

    public function subTerm($i, $j)
    {
        unset($this->subjects[$i]['term'][$j]);
        $this->subjects[$i]['term'] = array_values($this->subjects[$i]['term']);
        if(count($this->subjects[$i]['term']) < 1)
        {
            unset($this->subjects[$i]);
            //$this->subjects[$i] = array_values($this->subjects[$i]);
        }
    }

    public function addSubject($i, $j)
    {
        $this->subjects[$i]['term'][$j][] = [
            'code' => '',
            'title' => '',
            'lech' => '',
            'lech' => '',
            'lecu' => '0',
            'labu' => '0',
            'total' => '',
            'prereq' => '',
        ];
    }

    public function subSubject($i, $j, $k)
    {
        unset($this->subjects[$i]['term'][$j][$k]);
        $this->subjects[$i]['term'][$j] = array_values($this->subjects[$i]['term'][$j]);
    }

    public function saveCurriculum()
    {
        $this->validate();

        try{
            DB::beginTransaction();

            $curriculum = $this->course->curricula()->create([
                'effective_sy' => $this->effective_sy,
                'description' => $this->description,
            ]);

            $subjects = [];
            foreach($this->subjects as $i => $subject)
            {
                foreach($subject['term'] as $j => $s)
                {
                    foreach($s as $a)
                    {
                        $year = $i + 1;
                        $term = $j + 1;
                        $subjects[] = [
                            'uuid' => Str::orderedUuid(),
                            'year' => $year,
                            'term' => $term,
                            'code' => $a['code'],
                            'title' => $a['title'],
                            'lec_hours' => $a['lech'],
                            'lab_hours' => $a['labh'],
                            'lec_units' => $a['lecu'],
                            'lab_units' => $a['labu'],
                            'prereq' => $a['prereq'] ?? null,
                        ];
                    }
                }
            }

            $curriculum->subjects()->createMany($subjects);

            DB::commit();

            session()->flash('success', 'Curriculum successfully added');
            return redirect()->route('courses.show', $this->course);

        }catch (Exception $e){
            DB::rollback();
            dd($e);
        }

    }

    public function computeTotal($i, $j, $k)
    {
        $lecu = (int)$this->subjects[$i]['term'][$j][$k]['lecu'] ?? 0;
        $labu = (int)$this->subjects[$i]['term'][$j][$k]['labu'] ?? 0;
        $subTotal = $lecu + $labu;
        $this->subjects[$i]['term'][$j][$k]['total'] = $subTotal;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.configurations.curriculum-create');
    }
}
