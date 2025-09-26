<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Service\ClientService;
use App\Models\Client;

class ClientController extends Controller
{
    private $clientService;

    public $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'cnpj' => ['required', 'string', 'unique:clients,cnpj'],
        'observation' => ['nullable', 'string'],
        'contract_value' => ['required', 'numeric', 'min:0'],
        'address.street' => ['required', 'string', 'max:255'],
        'address.number' => ['required', 'string', 'max:255'],
        'address.postal_code' => ['required', 'string', 'max:255'],
        'address.complement' => ['nullable', 'string', 'max:255'],
        'address.neighborhood' => ['required', 'string', 'max:255'],
        'address.city' => ['required', 'string', 'max:255']
    ];

    public $messages = [
        'name.required' => 'O campo nome é obrigatório.',
        'name.string' => 'O campo nome deve ser uma string.',
        'name.max' => 'O campo nome não deve exceder 255 caracteres.',
        'email.required' => 'O campo email é obrigatório.',
        'email.string' => 'O campo email deve ser uma string.',
        'email.email' => 'O campo email deve ter um formato válido.',
        'email.max' => 'O campo email não deve exceder 255 caracteres.',
        'cnpj.required' => 'O campo CNPJ é obrigatório.',
        'cnpj.string' => 'O campo CNPJ deve ser uma string.',
        'cnpj.unique' => 'Este CNPJ já está sendo usado.',
        'contract_value.required' => 'O campo valor do contrato é obrigatório.',
        'contract_value.numeric' => 'O campo valor do contrato deve ser numérico.',
        'contract_value.min' => 'O campo valor do contrato deve ser no mínimo 0.',
        'address.street.required' => 'O campo rua é obrigatório.',
        'address.number.required' => 'O campo número é obrigatório.',
        'address.postal_code.required' => 'O campo CEP é obrigatório.',
        'address.neighborhood.required' => 'O campo bairro é obrigatório.',
        'address.city.required' => 'O campo cidade é obrigatório.'
    ];

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }
    public function CreateClient(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            $client = $this->clientService->createClient($request->all());
            return response()->json([
                'error' => false,
                'data' => $client
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function GetAllClients(Request $request)
    {
        try {
            $start_date = $request->input('startDate');
            $end_date = $request->input('endDate');

            $clients = $this->clientService->getAllClients($start_date, $end_date);
            return response()->json([
                'error' => false,
                'data' => $clients
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
