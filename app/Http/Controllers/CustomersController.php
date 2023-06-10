<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Customers;
use App\Models\Communes;
use App\Models\Regions;
use App\Enums\Status;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customers::all();

        return response()->json($customers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id_reg = $request->input('id_reg');
        $regions = Regions::select(['id_reg'])->where('id_reg','=',$id_reg)->get();
        if(count($regions) == 0){
            return response()->json(['status'=> false,'errors'=>'region no existe'],400);
        }
        $id_com = $request->input('id_com');
        $communes = Communes::select(['id_com'])->where('id_reg','=',$id_reg)->where('id_com','=',$id_com)->get();
        if(count($communes) == 0){
            return response()->json(['status'=> false,'errors'=>'communes no existe'],400);
        }
        $dni = $request->input('dni');
        $customer = Customers::select(['dni'])->where('id_reg','=',$id_reg)->where('id_com','=',$id_com)->where('dni','=',$dni)->get();
        if(count($customer) > 0){
            return response()->json(['status'=> false,'errors'=>'el customer no se ha podido crear'],400);
        }
        $rules = [
            'dni' => 'required|numeric',
            'id_reg' => 'required|numeric',
            'id_com' => 'required|numeric',
            'email' => 'required|email|unique:customers|max:80',
            'name' => 'required|string|min:1|max:100',
            'last_name' => 'required|string|min:1|max:100',
            'status' => 'required',Status::class,
        ];
        $validador = \Validator::make($request->input(),$rules);
        if($validador->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validador->errors()->all(),
            ],400);
        }
        $customers = new Customers($request->input());
        $customers->save();
        return response()->json([
                'status' => true,
                'message' => 'customer creado satisfactoriamente',
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customers $customers)
    {
        //var_dump ($customers);
        return response()->json(['status' => true,'data' => $customers]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customers $customers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $email = $request->input('email');
        $rules = [
            'email' => 'required|email|unique|max:80',
        ];
        $validador = \Validator::make($request->input(),$rules);
        if(!isset($email)){
            return response()->json([
                'status' => false,
                'errors' => 'Debe proporcionar un email',
            ],400);
        }
        $customers = DB::table('customers')
            ->select('customers.name', 'customers.last_name', 'customers.address')
            ->where('customers.status','=','trash')
            ->where('customers.email', '=', $email)
            ->get();
        if(count($customers) > 0){
            return response()->json([
                'status' => false,
                'errors' => 'Registro no existe',
            ],400);
        }
        $customer = Customers::where('email', $email)->update(['status' => 'trash']);

        if($customer == true){
             return response()->json([
                'status' => true,
                'message' => 'Registro eliminado',
            ],200);
        }
        
    }

    public function all(){
        $customers = DB::table('customers')
            ->join('communes', function ($join) {
                $join->on('communes.id_com','=','customers.id_com')
                    ->on('communes.id_reg','=','customers.id_reg');
            })
            ->join('regions', function ($join) {
                $join->on('regions.id_reg','=','customers.id_reg');
            })
            ->select('customers.name',
            'customers.last_name',
            'customers.address',
            'regions.description',
            'communes.description')
            ->get();

        //$customers->get();

        return response()->json($customers);
    }

    public function one(Request $request){
        $dni = $request->input('dni');
        $email = $request->input('email');
        if(!isset($dni) and !isset($email)){
            return response()->json([
                'status' => false,
                'errors' => 'Debe proporcionar un email o dni',
            ],400);
        }
        $customers = DB::table('customers')
            ->join('communes', function ($join) {
                $join->on('communes.id_com', '=', 'customers.id_com')
                    ->on('communes.id_reg', '=', 'customers.id_reg');
            })
            ->join('regions', function ($join) {
                $join->on('regions.id_reg', '=', 'customers.id_reg');
            })
            ->select('customers.name', 'customers.last_name', 'regions.description as region', 'communes.description as commune','customers.address',)
            ->where('customers.status','=','A');

        if (isset($dni)) {
            $customers->where('customers.dni', '=', $dni);
        }
        elseif (isset($email)) {
            $customers->where('customers.email', '=', $email);
        }

        $results = $customers->get();
        if(count($results) == 0){
            return response()->json([
                'status' => false,
                'errors' => 'registro no encontrado',
            ],400);
        }
        return response()->json($results);
    }
}
