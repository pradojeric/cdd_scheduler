<?php

namespace App\Http\Livewire\Sections;

use App\Models\Configurations\Course;
use App\Models\Configurations\Settings;
use App\Models\Section;
use Livewire\Component;
use Livewire\WithPagination;

class SectionIndex extends Component
{
    use WithPagination;

    public $perPage = 15;

    public $section;
    public $filterCourse = '';

    public $course = '';
    public $year = '';
    public $graduating;

    public $config;
    public $years = [
        1 => 'First',
        2 => 'Second',
        3 => 'Third',
        4 => 'Fourth',
        5 => 'Fifth',
        6 => 'Sixth?'
    ];
    public $isEditing;

    protected $listeners = [
        'deleteSection'
    ];

    protected $rules = [
        'course' => 'required',
        'year' => 'required',
        'graduating' => 'nullable'
    ];

    protected $queryString = [
        'page'
    ];

    public function mount()
    {
        $this->config = Settings::getSettings();
    }

    public function massCreateSections()
    {
        $courses = Course::all();
        foreach($courses as $course)
        {

            foreach($this->years as $y => $year) {

                if($y > 4) continue;

                $blocksCount = Section::where('year', $y)->where('term', $this->config->term)->where('course_id', $course->id)->count() + 1;

                Section::create([
                    'course_id' => $course->id,
                    'school_year' => $this->config->getRawOriginal('school_year'),
                    'year' => $y,
                    'term' => $this->config->term,
                    'block' => $blocksCount,
                    'graduating' => $this->graduating ?? false,
                ]);
            }

        }
        session()->flash('success', 'Mass creation of sections is successful');
    }

    public function addSection()
    {
        $this->validate();

        $blocksCount = Section::where('year', $this->year)->where('term', $this->config->term)->where('course_id', $this->course)->count() + 1;

        Section::create([
            'course_id' => $this->course,
            'school_year' => $this->config->getRawOriginal('school_year'),
            'year' => $this->year,
            'term' => $this->config->term,
            'block' => $blocksCount,
            'graduating' => $this->graduating ?? false,
        ]);

        session()->flash('success', 'Section successfully added');
        $this->reset(['course', 'year']);
    }

    public function updateSection()
    {
        $this->validate();
        $this->section->update([
            'course_id' => $this->course,
            'school_year' => $this->config->getRawOriginal('school_year'),
            'year' => $this->year,
            'term' => $this->config->term,
            'graduating' => $this->graduating ?? false,
        ]);
        session()->flash('success', 'Section successfully updated');
        $this->reset(['course', 'year']);
    }

    public function editSection(Section $section)
    {
        $this->section = $section;
        $this->course = $section->course_id;
        $this->year = $section->year;
        $this->isEditing = true;
    }

    public function deleteSection(Section $section)
    {
        $sections = Section::where('course_id', $section->id);

        if($sections->count() > 1){
            $sections->each(function($s){
                $s->decrement('block');
            });
        }

        $section->delete();

        session()->flash('success', 'Section successfully deleted');
    }

    public function render()
    {
        return view('livewire.sections.section-index', [
            'sections' => Section::with('course')->orderBy('course_id')->orderBy('year')->paginate($this->perPage),
            'allCourses' => Course::orderBy('name')->get(),
            'courses' => Course::with(['sections', 'sections.course'])->when($this->filterCourse != '', function($query){
                $query->where('id', $this->filterCourse);
            })->paginate($this->perPage),
        ]);
    }
}
