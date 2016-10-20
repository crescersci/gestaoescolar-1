<?php

namespace App\Http\Controllers;

use App\Aluno;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MateriaHasProfessor;
use App\MateriaHasTurma;
use App\Presenca;
use App\PresencaHasMatricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PresencaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $value = 1;
        $presencas = MateriaHasTurma::with('materia_has_professor', 'materia_has_professor.materia', 'turma')->whereHas('materia_has_professor', function($q) use($value) {
            $q->where('id_professor', '=', $value);
        })->paginate(25);
        return view('admin.presencas.index', compact('presencas'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create($id)
    {
        $presenca = Aluno::with('pessoa','matricula', 'matricula.turma', 'matricula.turma.materia_has_turma')->whereHas('matricula.turma.materia_has_turma', function($q) use($id) {
            $q->where('id_materia_professor', '=', $id);
        })->get();
        return view('admin.presencas.create', compact('presenca', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
        $pre = Presenca::create(['data' => $request->input('data'), 'id_materia_professor' => $request->input('identificador')]);
        foreach($request->only('presenca')['presenca'] as $matricula => $presenca){
            PresencaHasMatricula::create(['id_presenca' => $pre->id, 'presenca' => $presenca == "1" ? "presente" : "falta", 'id_matricula' => $matricula]);
        }

        Session::flash('success', 'Presenca added!');
        return redirect('admin/presencas');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $presencas = DB::table('presencas')
                ->selectRaw('presencas.*, (SELECT SUM(if(presenca = "presente", 1, 0)) FROM presenca_has_matricula WHERE presenca_has_matricula.id_presenca = presencas.id) as presentes, (SELECT SUM(if(presenca = "falta", 1, 0)) FROM presenca_has_matricula WHERE presenca_has_matricula.id_presenca = presencas.id) as faltantes')
                ->join('presenca_has_matricula', 'presencas.id', '=', 'presenca_has_matricula.id_presenca')
                ->where('id_materia_professor', '=', $id)
                ->paginate(15);
        return view('admin.presencas.show', compact('presencas', 'id'));
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
        $presenca = collect(
            DB::table('pessoas')
                ->select('pessoas.nome', 'matriculas.id', 'presenca_has_matricula.presenca', 'presencas.data', 'presencas.id as id_presenca')
                ->join('alunos', 'pessoas.id', '=', 'alunos.id_pessoas')
                ->join('matriculas', 'alunos.id', '=', 'matriculas.id_aluno')
                ->join('turmas', 'matriculas.id_turma', '=', 'turmas.id')
                ->join('materia_has_turma', 'materia_has_turma.id_turma', '=', 'turmas.id')
                ->join('presencas', 'materia_has_turma.id_materia_professor', '=', 'presencas.id_materia_professor')
                ->join('presenca_has_matricula', function($join) {
                    $join->on('presenca_has_matricula.id_presenca', '=', 'presencas.id');
                    $join->on('presenca_has_matricula.id_matricula','=', 'matriculas.id');
                })
                ->where('presencas.id', '=', $id)
                ->get()
        );
        //dd($presenca);
        return view('admin.presencas.edit', compact('presenca'));
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

        PresencaHasMatricula::where('id_presenca', '=', $id)->delete();

        foreach($request->only('presenca')['presenca'] as $matricula => $presenca){
            PresencaHasMatricula::create(['id_presenca' => $id , 'presenca' => $presenca == "1" ? "presente" : "falta", 'id_matricula' => $matricula]);
        }

        Session::flash('flash_message', 'Presenca updated!');

        return redirect('admin/presencas');
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
        Presenca::destroy($id);

        Session::flash('flash_message', 'Presenca deleted!');

        return redirect('admin/presencas');
    }
}
