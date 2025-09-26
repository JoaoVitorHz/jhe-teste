<?php

namespace App\Http\Service;

use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ClientService {

    public function createClient($data)
    {
        DB::beginTransaction();

        try {
            $client = Client::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'cnpj' => $data['cnpj'],
                'observation' => $data['observation'] ?? null,
                'contract_value' => $data['contract_value']
            ]);

            $client->address()->create([
                'street' => $data['address']['street'],
                'number' => $data['address']['number'],
                'postal_code' => $data['address']['postal_code'],
                'complement' => $data['address']['complement'] ?? null,
                'neighborhood' => $data['address']['neighborhood'],
                'city' => $data['address']['city']
            ]);

            $client->load('address');

            DB::commit();

            return $client;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function getAllClients($start_date = null, $end_date = null)
    {
        $query = Client::with('address');

        if ($start_date && $end_date) {
            $query->whereBetween('created_at', [$start_date, $end_date]);
        } elseif ($start_date) {
            $query->where('created_at', '>=', $start_date);
        } elseif ($end_date) {
            $query->where('created_at', '<=', $end_date);
        }

        return $query->get();
    }
}