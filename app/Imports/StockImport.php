<?php

namespace App\Imports;

use App\Personalization;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StockImport implements ToModel,WithChunkReading,WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Personalization([
                 'id'=>$row[0],
                 'stock_id' =>$row[1],
                 'total'=> $row[20],
                 'stocks_number' => $row[19],
                 'min_stocks' => $row[21],
                 'additional_stocks' => $row[22],
                 'percentage_stocks' => $row[23],
                 'total_stocks' => $row[24],
                 'total_percentage'=>$row[18],
                 'total_round'=>$row[24],

        ])  ;

    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 5000;
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 1;
    }

    /**
     * @return array
     */
    public function rules(): array
    {

        return [
            '0' => 'required|numeric',
            '2' => 'required|numeric',
            '3' => 'required|numeric',
            '4' => 'required|numeric',
            '6' => 'required|numeric',
            '7' => 'required|numeric',

            // so on
        ];

    }
}
