<?php

namespace App\Services;

class CapturaService
{
    protected $client;

    public function __construct()
    {
    }

    /**
     * Retorna a busca pela palavra chave
     * 
     * @param string $palavraChave
     * 
     * @return array
     */
    public function getEstoque(string $palavraChave)
    {
        $this->client = app('Captura\Estoque');

        $response = $this->client->get("?termo={$palavraChave}");

        if (200 !== $response->getStatusCode())
            throw new \Exception("Falha na busca de dados do estoque: " . $response->getReasonPhrase());

        $sHtml = (string)$response->getBody();

        $dom = new \DOMDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML($sHtml);

        $domXPath = new \DomXPath($dom);

        $sQyeryArticle = "//main[@class='main-content']//div[@class='list']//article";
        $domList = $domXPath->query($sQyeryArticle);

        if ($domList->count() <= 0)
            return [];

        $fnTratarString = function ($sStr) {
            return trim(str_replace(["\r\n", "\r", "\n"], "", $sStr));
        };

        $veiculos = [];
        for ($iVeiculo = 0; $iVeiculo < $domList->count(); $iVeiculo++) {
            try {
                $id = $domList->item($iVeiculo)->getAttribute('id');
                $queryVeiculo = "{$sQyeryArticle}[@id='{$id}']";

                $dadosVeiculo = [
                    'id'           => FuncoesService::parseInt($id),
                    'nome_veiculo' => $fnTratarString($domXPath->query("{$queryVeiculo}//div[@class='card__inner']//h2//a")->item(0)->nodeValue),
                    'link'         => $domXPath->query("{$queryVeiculo}//div[@class='card__inner']//h2//a")->item(0)->getAttribute('href'),
                    'link_img'     => $domXPath->query("{$queryVeiculo}//div[@class='card__img']//a//img")->item(0)->getAttribute('src'),
                    'preco'        => FuncoesService::parseInt($fnTratarString($domXPath->query("{$queryVeiculo}//div[@class='card__price']//span")->item(0)->nodeValue)),
                ];

                $listInfo = $domXPath->query("{$queryVeiculo}//div[@class='card__desc_wrap']//li[@class='card-list__row']");
                foreach ([
                    'ano',
                    'quilometragem',
                    'combustivel',
                    'cambio',
                    'portas',
                    'cor'
                ] as $ordemInfo => $atributoInfo) {
                    $itemInfo = $listInfo->item($ordemInfo);

                    $dadosVeiculo[$atributoInfo] = $fnTratarString($itemInfo->getElementsByTagName('span')->item(1)->nodeValue);

                    // Aplicando tratamentos
                    if (in_array($atributoInfo, ['ano', 'km']))
                        $dadosVeiculo[$atributoInfo] = FuncoesService::parseInt($dadosVeiculo[$atributoInfo]);
                }

                $veiculos[] = $dadosVeiculo;
            } catch (\Exception $e) {
                // Nada a fazer
            }
        }

        return $veiculos;
    }
}
