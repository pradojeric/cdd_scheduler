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

    public $perPage = 25;

    public $section;

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

    public function mount()
    {
        $this->config = Settings::first();
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
        if($sections->count() > 0){
            $sections->each(function($s){
                $s->decrement('block');
            });
        }

        $this->section = $section;
        $this->section->delete();

        $this->reset(['course', 'year']);
        session()->flash('success', 'Section successfully deleted');
    }

    public function render()
    {
        return view('livewire.sections.section-index', [
            'sections' => Section::paginate($this->perPage),
            'courses' => Course::all(),
        ]);
    }
}
