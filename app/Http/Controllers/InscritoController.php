<?php

namespace App\Http\Controllers;

use App\Models\Inscrito;
use Illuminate\Http\Request;

class InscritoController extends Controller
{
   
    public function index()
    {
        //método index vai retornar todos os inscritos cadastrados
        $inscritos = Inscrito::paginate(10);

        return response()->json($inscritos);
    }

    public function show(string $id)
    {
        //esse método vai exibir apenas um inscrito quando passado o id
        try{
            $inscrito = Inscrito::find($id);
            
            $retorno = response()->json([
                'status' => 1,
                'id'     => $inscrito
            ]);

        }catch(\Exception $e) {
            $retorno = response()->json([
                'status'  => 0,
                'message' => $e->getMessage()
            ]); 

        }
        return $retorno;
    }

    public function store(Request $request)
    {
        $regras = [
            'nome'  => 'required',
            'cpf'   => 'required',
            'email' => 'required'
        ];

        $mensagens = [
            'required'    => 'O campo :attribute é obrigatório',
            'email.email' => 'o campo precisa de um email valido'
        ];

        $this->validate($request, $regras, $mensagens);

        $params = $request->all();

        if(isset($params['cpf']) && !empty($params['cpf'])) {
            $params['cpf'] = preg_replace( '/[^0-9]/', '', $params['cpf']);
        }

        try {
            $model = Inscrito::create($params);

            $retorno = response()->json([
                'status' => 1,
                'id'     => $model->id
            ]);
            
        } catch(\Exception $e) {
            $retorno = response()->json([
                'status'  => 0,
                'message' => $e->getMessage()
            ]);
        }
        
        return $retorno;
    }

    public function update(Request $request, string $id)
    {
        //atualiza o registro
        $regras = [
            'nome'  => 'required',
            'cpf'   => 'required',
            'email' => 'required'
        ];

        $mensagens = [
            'required'    => 'O campo :attribute é obrigatório',
            'email.email' => 'o campo precisa de um email valido'
        ];

        $this->validate($request, $regras, $mensagens);

        $params = $request->all();

            if(isset($params['cpf']) && !empty($params['cpf'])) {
            $params['cpf'] = preg_replace( '/[^0-9]/', '', $params['cpf']);
            }
        
        try{
            $inscrito = Inscrito::find($id);
           
            $inscrito->update($params);
            
            $retorno = response()->json([
                'status'  => 1,
                'message' => 'Inscrito atualizado com sucesso'
            ]);

        }catch(\Exception $e) {
            $retorno = response()->json([
                'status'  => 0,
                'message' => $e->getMessage()
            ]); 
        }

        return $retorno;
    }

    public function destroy(string $id)
    {   
        
        try{
           $inscrito = Inscrito::find($id);
           
           $inscrito->delete();

           $retorno = response()->json([
            'status'  => 0,
            'message' => 'Inscrito excluido com sucesso'
           ]);

       }catch(\Exception $e) {
            $retorno = response()->json([
                'status'  => 0,
                'message' => $e->getMessage()
            ]); 
        }
        return $retorno;
    }

}
