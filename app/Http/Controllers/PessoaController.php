<?php

namespace App\Http\Controllers;

use App\Model\Pessoa;
use App\Model\PessoaTelefone;
use Illuminate\Http\Request;

class PessoaController extends Controller
{
    
    public function pesquisar(Request $request)
    {
        $pesquisa = Pessoa::with('telefones');

        if ($request->nome_completo) {
            $pesquisa->whereRaw("nome_completo like '%".$request->nome_completo."%'");
        }

        if ($request->cpf) {
            $pesquisa->whereRaw("cpf like '%".$request->cpf."%'");
        }

        return $pesquisa->get();
    }

    public function index()
    {
        return view("pessoas.index");
    }

    
    public function create()
    {
        return view("pessoas.create");
    }

    
    public function store(Request $request)
    {
        $pessoa = new Pessoa();
        $pessoa->fill($request->all());
        $pessoa->save();

        foreach ($request->telefones as $key => $telefone) {
            PessoaTelefone::create([
                'ddd' => $telefone['ddd'],
                'numero' => $telefone['numero'],
                'pessoa_id' => $pessoa->id
            ]);
        }

        return $pessoa->id;
        
    }

    
    public function show($id)
    {
    }


    public function edit($id)
    {
        return view('pessoas.edit',['pessoa' => Pessoa::with('telefones')->find($id)]);
    }

    public function update(Request $request, $id)
    {
      
        $pessoa = Pessoa::find($id);
        $pessoa->fill($request->all());
        $pessoa->save();

        PessoaTelefone::where('pessoa_id', $id)->delete();
        foreach ($request->telefones as $key => $telefone) {
            PessoaTelefone::create([
                'ddd' => $telefone['ddd'],
                'numero' => $telefone['numero'],
                'pessoa_id' => $pessoa->id
            ]);
        }

        return $pessoa->id;
        
    }

    public function destroy($id)
    {
        PessoaTelefone::where('pessoa_id',$id)->delete();
        Pessoa::where('id',$id)->delete();

        return 'true';
    
    }
}
