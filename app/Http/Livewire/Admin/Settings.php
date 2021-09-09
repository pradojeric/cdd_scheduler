<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Configurations\Settings as Config;

class Settings extends Component
{
    public $settings;
    public $terms;

    public $year1;
    public $year2;
    public $term;

    protected $rules = [
        'year1' => 'required|numeric',
        'year2' => 'required|numeric',
    ];

    public function mount()
    {
         $this->settings = Config::first();
         $this->terms = [
            1 => 'First Semester',
            2 => 'Second Semester',
            3 => 'Summer'
         ];
         $this->year1 = $this->settings->school_year[0];
         $this->year2 = $this->settings->school_year[1];
         $this->term = $this->settings->term;
    }

    public function saveSettings()
    {
        $this->settings->update([
            'school_year' => "$this->year1-$this->year2",
            'term' => $this->term,
        ]);

        session()->flash('message', 'Settings saved');
    }

    public function render()
    {
        return view('livewire.admin.settings');
    }
}
