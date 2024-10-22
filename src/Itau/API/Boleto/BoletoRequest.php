<?php
namespace Itau\API\Boleto;

use Itau\API\TraitEntity;

class BoletoRequest implements \JsonSerializable
{
    use TraitEntity;

    public Boleto $data;
}