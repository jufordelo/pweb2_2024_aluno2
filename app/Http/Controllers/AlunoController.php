<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Categoria;
use Illuminate\Http\Request;

class AlunoController extends Controller
{

    private $pagination = 2;

    public function index()
    {
        //app/http/Controller
        $dados = Aluno::paginate($this->pagination);

        // dd($dados);

        return view("aluno.list", ["dados" => $dados]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();

        return view("aluno.form", ['categorias' => $categorias]);
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
            $diretorio = "imagem/aluno/";

            $imagem->storeAs($diretorio, $nome_arquivo, 'public');

            $data['imagem'] = $diretorio . $nome_arquivo;
        }

        /*
        [
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'cpf' => $request->cpf,
            'categoria_id' => $request->categoria_id,
        ]
        */
        Aluno::create($data);

        return redirect('aluno');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //não precisa
    }

    public function edit(string $id)
    {
        $dado = Aluno::findOrFail($id);

        $categorias = Categoria::all();

        return view("aluno.form", [
            'dado' => $dado,
            'categorias' => $categorias
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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
            $diretorio = "imagem/aluno/";

            $imagem->storeAs($diretorio, $nome_arquivo, 'public');

            $data['imagem'] = $diretorio . $nome_arquivo;
        }

        Aluno::updateOrCreate(
            ['id' => $request->id],
            $data
        );

        return redirect('aluno');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dado = Aluno::findOrFail($id);
        // dd($dado);
        $dado->delete();

        return redirect('aluno');
    }

    public function search(Request $request)
    {
        if (!empty($request->nome)) {
            $dados = Aluno::where(
                "nome",
                "like",
                "%" . $request->nome . "%"
            )->paginate($this->pagination);
        } else {
            $dados = Aluno::paginate($this->pagination);
        }
        // dd($dados);

        return view("aluno.list", ["dados" => $dados]);
    }
}
