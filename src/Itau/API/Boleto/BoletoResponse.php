<?php

namespace Itau\API\Boleto;

use Itau\API\BaseResponse;
use Itau\API\BoleCode\DadoBoleto;

class BoletoResponse extends BaseResponse
{
    protected DadoBoleto $dado_boleto;
}