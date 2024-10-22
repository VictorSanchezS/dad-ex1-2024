<?php

namespace App\Http\Controllers;

use App\Models\Infraction;
use Illuminate\Http\Request;

class InfractionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $registros= Infraction::where('plate', 'like','%'.$texto.'%')->paginate(10);
        return view('infractions.index', compact('registros','texto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $infraction = new Infraction();
        return view('infractions.action',['infraction'=>new Infraction()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $registro = new Infraction();
        $registro->dni=$request->input('dni');
        $registro->fecha=$request->input('fecha');
        $registro->plate=$request->input('plate');
        $registro->infraccion=$request->input('infraccion');
        $registro->description=$request->input('description');
        $registro->save();

        return response()->json([
            'status'=> 'success',
            'message'=> 'Record created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Infraction $infraction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $infraction = Infraction::findOrFail($id);
        return view('infractions.action',compact('infraction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $infraction = Infraction::findOrFail($id);
        //$vehicle->update($request->all());
        $infraction->dni=$request->dni;
        $infraction->fecha=$request->fecha;
        $infraction->plate=$request->plate;
        $infraction->infraccion=$request->infraccion;
        $infraction->description=$request->description;
        $infraction->save();
        return response()->json([
            "status"=> "success",
            "message"=> "Updated successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $infraction = Infraction::findOrFail($id);
        $infraction->delete();

        return response()->json([
            'status' => 'success',
            'message' => $infraction->plate . ' Eliminado'
        ]);
    }
}
