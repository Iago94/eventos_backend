<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index()
    {
        //método index vai retornar todos os inscritos cadastrados
        $eventos = Evento::paginate(10);

        return response()->json($eventos);
    }

    public function show(string $id)
    {
        //esse método vai exibir apenas um inscrito quando passado o id
        try{
            $eventos = Evento::find($id);

            if (!$eventos) {
  
                $retorno = response()->json([
                    'status'  => 0,
                    'message' => 'Evento não encontrado'
                ]);
            } 
            
            $retorno = response()->json([
                'status' => 1,
                'id' => $eventos
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
            'nome'       =>'required',
            'data_inicio'=>'required', 
            'data_fim'   =>'required', 
            'status'     =>'required'
        ];
        $mensagens = [
            'required' => 'O campo :attribute é obrigatório',
            
        ];

        $this->validate($request, $regras, $mensagens);

        $params = $request->all();

        try {
            $eventos = Evento::create($params);

            if (!$eventos) {
  
                $retorno = response()->json([
                    'status'  => 0,
                    'message' => 'Evento não encontrado'
                ]);
            } 

            $retorno = response()->json([
                'status' => 1,
                'id'     => $eventos->id
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
        $regras = [
            'nome'       =>'required',
            'data_inicio'=>'required', 
            'data_fim'   =>'required', 
            'status'     =>'required'
        ];
        $mensagens = [
            'required' => 'O campo :attribute é obrigatório',
            
        ];

        $this->validate($request, $regras, $mensagens);

        $params = $request->all();

        try{
            $eventos = Evento::find($id);
           
            $eventos->update($params);
            
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
           $eventos = Evento::find($id);
           if (!$eventos) {
  
                return response()->json([
                    'status'  => 0,
                    'message' => 'Evento não encontrado'
                ]);
            }   
           
           $eventos->delete();

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
