<?php
namespace Itau\API\BoleCode;

use Itau\API\TraitEntity;
use JsonSerializable;

class Juros implements JsonSerializable
{
    use TraitEntity;

    const SEM_JUROS = '05';
    const PERCENTUAL_MENSAL = '90';

    private string $codigo_tipo_juros;
    private string $percentual_juros;
    private int $quantidade_dias_juros;

    public function setJuros($codigo, $percentual, $quantidade_dias_juros): self
    {
        $this->codigo_tipo_juros = $codigo;
        if($codigo != self::SEM_JUROS){
            $this->percentual_juros = $percentual*100000;
        }

        $this->quantidade_dias_juros = $quantidade_dias_juros;
        
        return $this;
    }
}