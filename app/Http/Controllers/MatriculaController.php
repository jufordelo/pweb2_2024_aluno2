<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Categoria; //adicionei categoria
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $dados = Matricula::paginate($this->pagination);
        return view("matricula.list", ["dados" => $dados]);
    }

   
    public function create()
    {
        $categorias = Categoria::all();
        return view("matricula.form", ['categorias' => $categorias]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         //app/http/Controller

         $request->validate([
            'nome' => "required|max:100",
            'cpf' => "required|max:16",
            'categoria_id' => "required",
            'telefone' => "nullable",
            'imagem' => "nullable|image|mimes:png,jpeg,jpg",
        ], [
            'nome.required' => "O :attribute é obrigatório",
            'nome.max' => "Só é permitido 100 caracteres",
            'cpf.required' => "O :attribute é obrigatório",
            'cpf.max' => "Só é permitido 16 caracteres",
            'categoria_id.required' => "O :attribute é obrigatório",
            'imagem.image' => "Deve ser enviado uma imagem",
            'imagem.mimes' => "A imagem deve ser da extensão de PNG, JPEG ou JPG",
        ]);

        $data = $request->all();
        $imagem = $request->file('imagem');

        if ($imagem) {
            $nome_arquivo =
                date('YmdHis') . "." . $imagem->getClientOriginalExtension();
            $diretorio = "imagem/matricula/";

            $imagem->storeAs($diretorio, $nome_arquivo, 'public');

            $data['imagem'] = $diretorio . $nome_arquivo;
        }
        Professor::create($data);

        return redirect('professor');
    }

   
    public function show(Matricula $matricula)
    {
        //não precisa
    }

    public function edit(Matricula $matricula)
    {
        {
            $dado = Matricula::findOrFail($id);
    
            $matriculas = Matricula::all();
    
            return view("matricula.form", [
                'dado' => $dado,
                'matricula' => $matricula //no caso deveria ter uma categoria para relacionarmos porém, não foi feito em aula ainda.
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Matricula $matricula)
    {
        
        $request->validate([
            'nome' => "required|max:100",
            'cpf' => "required|max:16",
            'categoria_id' => "required",
            'telefone' => "nullable",
            'imagem' => "nullable|image|mimes:png,jpeg,jpg",
        ], [
            'nome.required' => "O :attribute é obrigatório",
            'nome.max' => "Só é permitido 100 caracteres",
            'cpf.required' => "O :attribute é obrigatório",
            'cpf.max' => "Só é permitido 16 caracteres",
            'categoria_id.required' => "O :attribute é obrigatório",
            'imagem.image' => "Deve ser enviado uma imagem",
            'imagem.mimes' => "A imagem deve ser da extensão de PNG, JPEG ou JPG",
        ]);

        $data = $request->all();
        $imagem = $request->file('imagem');

        if ($imagem) {
            $nome_arquivo =
                date('YmdHis') . "." . $imagem->getClientOriginalExtension();
            $diretorio = "imagem/matricula/";

            $imagem->storeAs($diretorio, $nome_arquivo, 'public');

            $data['imagem'] = $diretorio . $nome_arquivo;
        }

        Matricula::updateOrCreate(
            ['id' => $request->id],
            $data
        );

        return redirect('matricula');
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matricula $matricula)
    {
        $dado = Matricula::findOrFail($id);
        // dd($dado);
        $dado->delete();

        return redirect('matricula');
    }
//criei o buscar 
    public function search(Request $request)
    {
        if (!empty($request->pss)) {
            $dados = Matricula::where(
                "pss",
                "like",
                "%" . $request->pss . "%"
            )->get();
        } else {
            $dados = Matricula::all();
        } //dd($dados)
        return view("matricula.list", ["dados" => $dados]);
    }
}
