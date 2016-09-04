<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Advertencia;
use Illuminate\Http\Request;
use Session;

class AdvertenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $advertencias = Advertencia::paginate(25);

        return view('advertencias.advertencias.index', compact('advertencias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('advertencias.advertencias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $requestData = $request->all();
        
        Advertencia::create($requestData);

        Session::flash('flash_message', 'Advertencia added!');

        return redirect('admin/advertencias');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $advertencia = Advertencia::findOrFail($id);

        return view('advertencias.advertencias.show', compact('advertencia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $advertencia = Advertencia::findOrFail($id);

        return view('advertencias.advertencias.edit', compact('advertencia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $requestData = $request->all();
        
        $advertencia = Advertencia::findOrFail($id);
        $advertencia->update($requestData);

        Session::flash('flash_message', 'Advertencia updated!');

        return redirect('admin/advertencias');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Advertencia::destroy($id);

        Session::flash('flash_message', 'Advertencia deleted!');

        return redirect('admin/advertencias');
    }
}