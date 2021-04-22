<?php

namespace App\Imports;

use App\models\ServiceProvider;
use Maatwebsite\Excel\Concerns\ToModel;


class InvoiceImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ServiceProvider([
            'cat'=>(isset($row[0]) && !empty($row[0]))? $row[0]:" ",
            'sub_cat' =>(isset($row[1]) && !empty($row[1]))? $row[1]:" ",
            'name'=>(isset($row[2]) && !empty($row[2]))? $row[2]:" ",
            'phone'=>(isset($row[3]) && !empty($row[3]))? $row[3]:" ",
            'address'=>(isset($row[4]) && !empty($row[4]))? $row[4]:" ",
            'district'=>(isset($row[5]) && !empty($row[5]))? $row[5]:" ",
            'state'=>(isset($row[6]) && !empty($row[6]))? $row[6]:" ",
            'pin_code'=>(isset($row[7]) && !empty($row[7]))? $row[7]:" ",
            'delete_status'=>'1',
            'created_at'=>date('Y-m-d'),     
        ]);
    }
}
