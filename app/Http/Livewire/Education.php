<?php

namespace App\Http\Livewire;

use App\Models\Education as ModelsEducation;
use Livewire\Component;

class Education extends Component
{
    public $educationData = [], $educationFirst, $educationSecond, $existEducation;
    public $keyId, $school_name, $degree, $marks, $year;


    public function mount()
    {
        $this->getData();
    }

    public function add()
    {
        $this->educationData[] = ['school_name' => '', 'degree' => '', 'marks' => '', 'year' => '', 'education_id' => ''];
    }

    public function remove($educationId, $index)
    {
        if (!empty($educationId)) {
            $existEducation = ModelsEducation::whereId($educationId)->where('user_id', 1)->first();
            $existEducation->delete();
        }

        unset($this->educationData[$index]);
        $this->educationData = array_values($this->educationData);
    }

    public function getData()
    {
        $this->educationFirst = ModelsEducation::where('user_id', 1)->where('index', '1')->first();
        $this->educationSecond = ModelsEducation::where('user_id', 1)->where('index', '2')->first();

        $datas = ModelsEducation::where('user_id', 1)->whereNotIn('index', ['1', '2'])->get();

        $arraData = [];
        foreach ($datas as $data) {
            $dataArray[] = [
                'school_name' => $data->school_name ?? null,
                'degree' => $data->degree ?? null,
                'marks' => $data->marks ?? null,
                'year' => $data->year ?? null,
                'index' => $data->index ?? null,
                'education_id' => $data->id ?? null,
            ];

            $arraData = $dataArray;
        }

        $this->educationData = $arraData;
    }

    public function showModel($educationId, $index)
    {
        $this->keyId = $index;

        $this->existEducation = ModelsEducation::whereId($educationId)->where('user_id', 1)->first();

        $this->school_name = $this->existEducation->school_name ?? null;
        $this->degree = $this->existEducation->degree ?? null;
        $this->marks = $this->existEducation->marks ?? null;
        $this->year = $this->existEducation->year ?? null;

        $this->emit('showModel');
    }

    public function store()
    {
        $education = new ModelsEducation();

        if ($this->existEducation) {
            $education->id = $this->existEducation->id;
            $education->exists = true;
        }
        $education->user_id = 1;
        $education->school_name = $this->school_name;
        $education->degree = $this->degree;
        $education->marks = $this->marks;
        $education->year = $this->year;
        $education->index = $this->keyId;
        $education->save();

        $this->reset();
        $this->getData();
        $this->emit('cloaseModal');
    }

    public function render()
    {
        return view('livewire.education')->extends('layouts.app');
    }
}
