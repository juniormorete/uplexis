<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Carros;

class CapturaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tela/operação de captura de dados
     * 
     * @return void
     */
    public function index()
    {
        return view('captura.capturar');
    }

    /**
     * Tela de listagem das capturas salvas em banco de dados
     * @return void
     */
    public function lista()
    {
        return view('captura.lista', [
            'colunas' => [
                'img'           => 'Imagem',
                'nome_veiculo'  => 'Veículo',
                'ano'           => 'Ano',
                'combustivel'   => 'Combustível',
                'cambio'        => 'Câmbio',
                'portas'        => 'Portas',
                'cor'           => 'Cor',
                'quilometragem' => 'Km',
                'preco'         => 'Preço'
            ],
            'colunas_classes' => [
                'img'   => 'text-center',
                'ano'   => 'text-center',
                'preco' => 'text-right text-nowrap'
            ],
            'carros' => Carros::all()
        ]);
    }

    /**
     * Executa uma busca e salva em banco de dados
     * 
     * @param Request $request
     * 
     * @return json
     */
    public function capturar(Request $request)
    {
        try {
            $palavraChave = $request->input('palavra-chave');
            $estoque = (new \App\Services\CapturaService())->getEstoque($palavraChave) ?: [];

            if (!empty($estoque)) {
                $estoque = array_map(function ($veiculo) {
                    $veiculo['user_id'] = Auth::user()->id;
                    return $veiculo;
                }, $estoque);

                // Salvando em banco de dados
                Carros::upsert($estoque, []);
            }

            return response()->json([
                'sts'     => 'OK',
                'palavraChave' => $palavraChave,
                'estoque' => $estoque
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'sts'     => 'NOK',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Exclui um registro do banco de dados
     * 
     * @param Request $request
     * 
     * @return void
     */
    public function excluir(Request $request)
    {
        try {
            $idCarro = $request->input('id');

            if (empty($idCarro))
                throw new \Exception("ID inválido");

            $carro = Carros::find($idCarro);
            if (!$carro->exists())
                throw new \Exception("ID inexistente");

            if (!$carro->delete())
                throw new \Exception("Falha ao excluir registro");

            return response()->json([
                'sts' => 'OK'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'sts'     => 'NOK',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
