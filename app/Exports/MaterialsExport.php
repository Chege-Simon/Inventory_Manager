<?php

namespace App\Exports;

use App\Models\material;
use Maatwebsite\Excel\Concerns\FromCollection;

class MaterialsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return material::all();
    }
}
