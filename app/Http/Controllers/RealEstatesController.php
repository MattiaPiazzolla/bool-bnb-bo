<?php

namespace App\Http\Controllers;

use App\Models\real_estates;



use App\Http\Requests\StoreRealEstateRequest; //Importa la classe StoreRealEstateRequest
use App\Http\Requests\UpdateRealEstateRequest; //Importa la classe UpdateRealEstateRequest

use illuminate\Support\Facades\Storage;
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
        // recupero tutti gli immobili
        $real_estates = real_estates::all();
        return view('real_estates', compact('real_estates'));
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
    public function store(StoreRealEstateRequest $request)
    {
        //usa i dati validati dal request StoreRealEstateRequest
        $form_data = $request->validate();

        
        return redirect()->route('real_estates.index')->with('success', 'real_estate creato con successo!');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\real_estates  $real_estates
     * @return \Illuminate\Http\Response
     */
    public function show(real_estates $real_estates)
    {
        return view('real_estates.show', compact('realEstate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\real_estates  $real_estates
     * @return \Illuminate\Http\Response
     */
    public function edit(real_estates $real_estates)
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
    public function update(UpdateRealEstateRequest $request, RealEstate $realEstate)
    {
        // Usa i dati validati dalla request `UpdateRealEstateRequest`
        $form_data = $request->validate();

        return redirect()->route('real_estates.index')->with('success', 'Real Estate updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\real_estates  $real_estates
     * @return \Illuminate\Http\Response
     */
    public function destroy(real_estates $real_estates)
    {
        $real_estates->delete();
        return redirect()->route('real_estates.index')->with('success', 'Real Estate deleted successfully');
    }
}