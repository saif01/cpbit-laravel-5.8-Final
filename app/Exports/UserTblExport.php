<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;

use App\User;

class UserTblExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select(['name','email'])->get();
    }


    public function headings(): array
       {
          return [
            'Number',
            'Email',
           ];
        }
}
