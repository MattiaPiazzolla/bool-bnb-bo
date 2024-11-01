<?php

namespace App\Http\Controllers\Admin;

use App\Models\RealEstate;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreRealEstateRequest; //Importa la classe StoreRealEstateRequest
use App\Http\Requests\UpdateRealEstateRequest; //Importa la classe UpdateRealEstateRequest

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class RealEstatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    // Recupero tutti gli immobili
    $real_estates = RealEstate::all();

    // Passa la variabile alla vista
    return view('RealEstate.index', compact('real_estates'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Ritorna la vista create
        return view('real_estates');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( $request)
    {
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\real_estates  $real_estates
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $real_estate = RealEstate::findOrFail($id);
        return view('RealEstate.show', compact('real_estate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\real_estates  $real_estates
     * @return \Illuminate\Http\Response
     */
    public function edit(RealEstate $real_estates)
    {
        return view('real_estates.edit', compact('real_estates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\real_estates  $real_estates
     * @return \Illuminate\Http\Response
     */
    public function update( $request, $realEstate)
    {
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\real_estates  $real_estates
     * @return \Illuminate\Http\Response
     */
    public function destroy(RealEstate $real_estates)
    {
        $real_estates->delete();
        return redirect()->route('real_estates.index')->with('success', 'Real Estate deleted successfully');
    }
}