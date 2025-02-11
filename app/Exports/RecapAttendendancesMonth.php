<?php

namespace App\Exports;

use App\Models\Attendances;
use Maatwebsite\Excel\Concerns\FromCollection;

class RecapAttendendancesMonth implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Attendances::all();
    }
}
