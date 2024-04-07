<?php

namespace App\Http\Controllers;
use App\Models\Categoria; //adicionei categoria
use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        $dados = Curso::paginate($this->pagination);
        return view ("curso.list", ["dados" => $dados]);
    }

        public function create()
    {
        $categorias = Categoria::all();
        return view("curso.form", ['categorias' => $categorias]);
    }

    /**
     * Store a newly created resource in storage.
     */
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
            $diretorio = "imagem/curso/";

            $imagem->storeAs($diretorio, $nome_arquivo, 'public');

            $data['imagem'] = $diretorio . $nome_arquivo;
        }
        Curso::create($data);

        return redirect('curso');
    }
    public function show(Curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        {
            $dado = Curso::findOrFail($id);
    
            $cursos = Curso::all();
    
            return view("curso.form", [
                'dado' => $dado,
                'curso' => $curso //no caso deveria ter uma categoria para relacionarmos porém, não foi feito em aula ainda.
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso)
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
            $diretorio = "imagem/curso/";

            $imagem->storeAs($diretorio, $nome_arquivo, 'public');

            $data['curso'] = $diretorio . $nome_arquivo;
        }

        Curso::updateOrCreate(
            ['id' => $request->id],
            $data
        );

        return redirect('curso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        dado = Curso::findOrFail($id);
        // dd($dado);
        $dado->delete();

        return redirect('curso');

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
