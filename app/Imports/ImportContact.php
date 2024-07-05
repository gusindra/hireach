<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PDO;

class ImportContact implements ToModel, WithStartRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $client = Client::firstOrCreate(
            ['phone' => $row[0], 'user_id' => auth()->user()->id],
            [
                'uuid'      => Str::uuid(),
                'email'     => $row[1],
                'name'      => $row[2],
                'created_at' => $row[3],
                'title'     => $row[4],
                'sender'    => $row[5],
                'identity'  => $row[6],
                'note'      => $row[7],
                'tag'       => $row[8],
                'source'    => $row[9],
                'address'   => $row[10]
            ]
        );

        if ($client) {
            $client->update([
                'name'      => $row[2],
                'email'     => $row[1],
                'title'     => $row[4],
                'sender'    => $row[5],
                'identity'  => $row[6],
                'note'      => $row[7],
                'tag'       => $row[8],
                'source'    => $row[9],
                'address'   => $row[10]
            ]);
        }

        // return new Client([
        //     'uuid'      => Str::uuid(),
        //     'name'      => $row[0],
        //     'phone'     => $row[1],
        //     'email'     => $row[2],
        //     'created_at'=> $row[3],
        //     'title'     => $row[4],
        //     'sender'    => $row[5],
        //     'identity'  => $row[6],
        //     'note'      => $row[7],
        //     'tag'       => $row[8],
        //     'source'    => $row[9],
        //     'address'   => $row[10],
        //     'user_id' => auth()->user()->id,
        // ]);
    }
}
