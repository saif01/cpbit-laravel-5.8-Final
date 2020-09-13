<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Http\Controllers\SmsDataController;

class SmsMessage implements WithHeadings, FromArray
{

    public $data;

    public function __construct($data)
    {   
        //  $Object = new SmsDataController();

        //  $data = $Object->Index();

         $this->data = $data;
    }


    public function array(): array
    {
        // return [
        //     [
        //         'name' => 'Povilas',
        //         'email' => 'povilas@laraveldaily.com',
        //     ],
        //     [
        //         'name' => 'Taylor',
        //         'email' => 'taylor@laravel.com',
        //     ],
        // ];

        return  $this->data;
    }



    public function headings(): array
       {
          return [
            'Number',
            'Message',
           ];
        }
}
