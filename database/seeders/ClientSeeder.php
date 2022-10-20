<?php

namespace Database\Seeders;

use App\Services\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Client $clientService)
    {
        $dumpTable = DB::connection('pgsql_dump')->table('users')->get(['created_at', 'updated_at',
            'first_name', 'last_name', 'middle_name', 'certificate_serial',
            'certificate_expire_to_date', 'status'])->where('status', '=', 'ACTIVE');

        Storage::put('clients.txt', '');
        $dumpTable->each(function ($user) use ($clientService) {
            $dataToSave['fio'] = $user->last_name . ' ' . $user->first_name . ' ' . $user->middle_name;
            $dataToSave['password'] = Str::random();
            $dataToSave['created_at'] = date('Y-m-d h:i:s', strtotime($user->created_at));
            $dataToSave['updated_at'] = $user->updated_at ? date('Y-m-d h:i:s', strtotime($user->updated_at)) : null;
            $dataToSave['certificate_serial_number'] = $user->certificate_serial;
            $dataToSave['certificate_expire_to_date'] =
                date('Y-m-d h:i:s', strtotime($user->certificate_expire_to_date));

            if ($clientService->create($dataToSave)) {
                Storage::append('clients.txt', $dataToSave['certificate_serial_number'] . ' ' . $dataToSave['fio'] . ' ' . $dataToSave['password']);
            } else {
                dump('Не удалось сохранить:');
                dump($dataToSave);
            }
        });


    }
}
