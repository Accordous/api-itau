<?php
namespace Itau\API\Boleto;

use Itau\API\BoleCode\Beneficiario;
use Itau\API\BoleCode\DadoBoleto;
use Itau\API\BoleCode\Juros;
use Itau\API\BoleCode\Pagador;
use Itau\API\TraitEntity;

class Boleto implements \JsonSerializable
{
    use TraitEntity;

    private string $nosso_numero;

    const ETAPA_TESTE = "validacao";
    const ETAPA_EFETIVO = "efetivacao";

    private string $etapa_processo_boleto;
    private string $codigo_canal_operacao =  "API";

    private Beneficiario $beneficiario;
    private DadoBoleto $dado_boleto;
    private Pagador $pagador;
    private Juros $juros;

    public function __construct($agencia, $contaComDigito)
    {       
        $this->beneficiario()->setIdBeneficiario($agencia, $contaComDigito);
    }

    public function setEtapaProcessoBoleto($etapa): self
    {
        $this->etapa_processo_boleto = $etapa;
        return $this;
    }

    public function beneficiario(): Beneficiario
    {
        $beneficiario = new Beneficiario();

        $this->setBeneficiario($beneficiario);

        return $beneficiario;
    }

    public function getBeneficiario(): Beneficiario
    {
        return $this->beneficiario;
    }

    public function setBeneficiario(Beneficiario $beneficiario): self
    {
        $this->beneficiario = $beneficiario;
        return $this;
    }

    public function dadoBoleto(): DadoBoleto
    {
        $dado = new DadoBoleto();

        $this->setDadoBoleto($dado);

        return $dado;
    }

    public function setDadoBoleto(DadoBoleto $dado): self
    {
        $this->dado_boleto = $dado;
        return $this;
    }

    public function pagador(): Pagador
    {
        $pagador = new Pagador();

        $this->setPagador($pagador);

        return $pagador;
    }

    private function setPagador(Pagador $pagador): self
    {
        $this->pagador = $pagador;
        return $this;
    }

    public function juros(): Juros
    {
        $juros = new Juros();

        $this->setJuros($juros);

        return $juros;
    }

    public function setJuros(Juros $juros): self
    {
        $this->juros = $juros;
        return $this;
    }



}