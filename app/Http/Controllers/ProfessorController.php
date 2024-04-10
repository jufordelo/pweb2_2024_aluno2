<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\Categoria; //adicionei categoria
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    
    public function index()
    {
        $dados = Professor::paginate($this->pagination);
        return view("professor.list", ["dados" => $dados]);
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view("professor.form", ['categorias' => $categorias]);
    }

    
    public function store(Request $request)
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
            $diretorio = "imagem/professor/";

            $imagem->storeAs($diretorio, $nome_arquivo, 'public');

            $data['imagem'] = $diretorio . $nome_arquivo;
        }
        Professor::create($data);

        return redirect('professor');
    }

    
    public function show(Professor $professor)
    {
        //não precisa
    }

    
    public function edit(Professor $professor)
    {
        {
            $dado = Professor::findOrFail($id);
    
            $professors = Professor::all();
    
            return view("professor.form", [
                'dado' => $dado,
                'professor' => $professor
        //no caso deveria ter uma categoria para relacionarmos porém, não foi feito em aula ainda.
            ]);
        }
    }

    
    public function update(Request $request, Professor $professor)
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
            $diretorio = "imagem/professor/";

            $imagem->storeAs($diretorio, $nome_arquivo, 'public');

            $data['imagem'] = $diretorio . $nome_arquivo;
        }

        Professor::updateOrCreate(
            ['id' => $request->id],
            $data
        );

        return redirect('professor');
    }
    
    public function destroy(Professor $professor)
    {
        
        $dado = Professor::findOrFail($id);
        // dd($dado);
        $dado->delete();

        return redirect('professor');
    }
// criei o buscar 
    public function search(Request $request)
    {
        if (!empty($request->pss)) {
            $dados = Professor::where(
                "pss",
                "like",
                "%" . $request->pss . "%"
            )->get();
        } else {
            $dados = Professor::all();
        } //dd($dados)
        return view("professor.list", ["dados" => $dados]);
    }

}
