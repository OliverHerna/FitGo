<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ReportsExport implements FromArray, WithHeadings, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function array(): array
    {
        $clients = User::where('role_id', 3)->get();

        foreach($clients as $client)
        {
            $array[] = [$client->company_name, 
                        isset($client->ActivePackage->first()->HoursSpentValue) ?  $client->getTotalPackagesHoursAttribute($client) - $client->ActivePackage->first()->HoursSpentValue : $client->getTotalPackagesHoursAttribute($client),
                        $client->first_name,
                        $client->last_name,
                        $client->phone,
                        $client->email,
                       ];
        }
        return $array;
    }

    public function headings(): array
    {
        return [
            'Cliente',
            'Horas restantes',
            'Nombre',
            'Apellido',
            'Teléfono',
            'Correo',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 40,
            'B' => 20,
            'C' => 25,
            'D' => 25,
            'E' => 25,
            'F' => 30,          
        ];
    }

}
