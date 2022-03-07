<?php

namespace App\Services;

class FuncoesService
{

    /**
     * Transforma uma string formatada em numero decimal p/ sistema e banco de dados
     * @param mixed $sNumDecimal
     * 
     * @return float
     */
    public static function parseFloat(mixed $sNumDecimal): float
    {
        // Se houver "E-" no número, considerar zero
        if (false !== stripos($sNumDecimal, 'E-'))
            return 0.00;

        $sNum = "";
        foreach (str_split(strrev($sNumDecimal)) as $num) {
            if (is_numeric($num) || (in_array($num, array(',', '.')) && stripos($sNum, $num) === false) || $num === '-')
                $sNum .= $num;
        }

        $isNegativo = (mb_substr($sNum, -1) === '-');
        $sNum       = strrev(str_replace("-", "", $sNum));

        $posV = stripos(strrev($sNum), ',');
        $posP = stripos(strrev($sNum), '.');

        //Se o número começar com vírgula ou com ponto, colocar um zero antes
        if ((strlen($sNum) - 1) === (!empty($posV) && ($posV <= $posP || empty($posP)) ? $posV : $posP))
            $sNum = "0{$sNum}";

        $sNum = preg_replace("/\D/", "", $sNum);
        $pos  = mb_strlen($sNum) - (!empty($posV) && ($posV <= $posP || empty($posP)) ? $posV : $posP);

        if (!empty($pos) && mb_strlen($sNum) !== $pos)
            $sNum = mb_substr($sNum, 0, $pos) . "." . mb_substr($sNum, $pos);

        if ($isNegativo)
            $sNum = '-' . $sNum;

        return (float) $sNum;
    }

    /**
     * Transforma string em inteiro
     * 
     * @param mixed $sNum
     * 
     * @return int
     */
    public static function parseInt(mixed $sNum): int
    {
        return (int) (preg_replace("/\D/", "", $sNum) ?: 0);
    }
}
