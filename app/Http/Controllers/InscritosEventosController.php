<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InscritoEvento;
use App\Models\Inscrito;
use App\Models\Evento;

class InscritosEventosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lógica para listar inscritos em eventos
        $inscritosEventos = InscritoEvento::paginate(10);

        return response()->json($inscritosEventos);
    }
 

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)

    {
        $regras = [
            'inscrito_id'=> 'required|exists:inscritos,id',
            'evento_id'  => 'required|exists:eventos,id',
           
        ];
        $mensagens = [
            'required'           => 'O campo :attribute é obrigatório',
            'inscrito_id.exists' => 'A inscrito informado não existe!',
            'evento_id.exists'   => ' O evento informado não existe!'
        ];

        $this->validate($request, $regras, $mensagens);

        $inscritoId = $request->input('inscrito_id');
        $eventoId = $request->input('evento_id');
    
        try {
            $inscrito = Inscrito::findOrFail($inscritoId);
            $evento = Evento::findOrFail($eventoId);
    
            // Verifica se o evento está ativo
            if ($evento->status) {
                // Verifica conflitos de horários, se necessário
                $conflitos = $inscrito->eventos()->where(function ($query) use ($evento) {
                    $query->where('data_inicio', '<', $evento->data_fim)
                        ->where('data_fim', '>', $evento->data_inicio);
                })->count();
    
                if ($conflitos > 0) {
                    $retorno = response()->json([
                        'status'  => 0,
                        'message' => 'Conflito de horários. O inscrito já está inscrito em um evento que se sobrepõe a este.'
                    ]);
                } else {
                    // Adiciona o inscrito ao evento
                    $evento->inscritos()->attach($inscrito);
    
                    $retorno = response()->json([
                        'status'  => 1,
                        'message' => 'Inscrito vinculado ao evento com sucesso'
                    ]);
                }
            } else {
                $retorno = response()->json([
                    'status'  => 0,
                    'message' => 'Evento inativo. Não é possível realizar inscrição.'
                ]);
            }
        } catch (\Exception $e) {
            $retorno = response()->json([
                'status'  => 0,
                'message' => $e->getMessage()
            ]);
        }
    
        return $retorno;
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Lógica para exibir detalhes de uma inscrição
        try {
            $inscritoEvento = InscritoEvento::findOrFail($id);

           $retorno = response()->json([
                'status' => 1,
                'inscrito_evento' => $inscritoEvento
            ]);
        } catch (\Exception $e) {
           $retorno = response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ]);
        }

        return $retorno;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Lógica para excluir uma inscrição em um evento (se necessário)
        try {
            $inscritoEvento = InscritoEvento::findOrFail($id);
            $inscritoEvento->delete();

            $retorno = response()->json([
                'status' => 1,
                'message' => 'Inscrição excluída com sucesso'
            ]);
        } catch (\Exception $e) {
            $retorno = response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ]);
        }
        return $retorno;
    }
}
