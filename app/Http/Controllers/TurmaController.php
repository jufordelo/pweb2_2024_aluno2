<?php

namespace App\Http\Controllers;
use App\Models\Categoria; //adicionei categoria
use App\Models\Turma;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    public function index()
    {
        $dados = Turma::paginate($this->pagination);
        return view ("turma.list", ["dados" => $dados]);
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view("turma.form", ['categorias' => $categorias]);
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
            $diretorio = "imagem/turma/";

            $imagem->storeAs($diretorio, $nome_arquivo, 'public');

            $data['imagem'] = $diretorio . $nome_arquivo;
        }
        Turma::create($data);

        return redirect('turma');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Turma $turma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Turma $turma)
    {
        {
            $dado = Turma::findOrFail($id);
    
            $turmas = Turma::all();
    
            return view("turma.form", [
                'dado' => $dado,
                'turma' => $turma //no caso deveria ter uma categoria para relacionarmos porém, não foi feito em aula ainda.
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Turma $turma)
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
            $diretorio = "imagem/turma/";

            $imagem->storeAs($diretorio, $nome_arquivo, 'public');

            $data['imagem'] = $diretorio . $nome_arquivo;
        }

        Turma::updateOrCreate(
            ['id' => $request->id],
            $data
        );

        return redirect('turma');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Turma $turma)
    {
        dado = Turma::findOrFail($id);
        // dd($dado);
        $dado->delete();
        return redirect('turma');

    }
    public function search(Request $request)
    {
        if (!empty($request->pss)) {
            $dados = Turma::where(
                "pss",
                "like",
                "%" . $request->pss . "%"
            )->get();
        } else {
            $dados = Turma::all();
        } //dd($dados)
        return view("turma.list", ["dados" => $dados]);
    }


}
