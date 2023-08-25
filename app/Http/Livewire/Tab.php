<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Tab extends Component
{

    public $showModal = false;

    public function openModal()
    {
        $this->showModal = true;
    }


    public $dynamicFields = [
        ['label' => 'Full Name', 'value' => ''],
        ['label' => 'Email', 'value' => ''],
        ['label' => 'Phone', 'value' => ''],
    ];


    public function render()
    {
        return view('livewire.tab');
    }
}
