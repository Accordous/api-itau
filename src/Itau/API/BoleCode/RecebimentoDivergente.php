<?php
namespace Itau\API\BoleCode;

use Itau\API\TraitEntity;
use JsonSerializable;

class RecebimentoDivergente implements JsonSerializable
{
    use TraitEntity;

    const NAO_ACEITAR_DIVERGENTE = "03";

    private string $codigo_tipo_autorizacao;

    public function setRecebimentoDivergente($codigo): self
    {
        $this->codigo_tipo_autorizacao = $codigo;
        return $this;
    }
}