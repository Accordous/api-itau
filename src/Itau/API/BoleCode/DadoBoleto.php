<?php

namespace Itau\API\BoleCode;

use Itau\API\TraitEntity;

class DadoBoleto implements \JsonSerializable
{
    use TraitEntity;

    const ESPECIE_DM = '01';
    const ESPECIE_DS = '08';

    const INSTRUMENTO_COBRANCA_BOLETO = "boleto";
    const INSTRUMENTO_COBRANCA_BOLECODE = "boleto_pix";

    private string $descricao_instrumento_cobranca = self::INSTRUMENTO_COBRANCA_BOLECODE;
    private int $codigo_carteira = 109;
    private string $valor_total_titulo;
    private string $codigo_especie;
    private string $data_emissao;
    private string $texto_seu_numero;
    private Pagador $pagador;
    private ?array $dados_individuais_boleto = [];
    private Juros $juros;
    private Multa $multa;
    private string $tipo_boleto = "a vista";
    private RecebimentoDivergente $recebimento_divergente;
    private int $desconto_expresso =  0;



    
    public function __construct()
    {
        $this->data_emissao = date("Y-m-d");
    }

    public function setDados(string $valor, string $codigoEspecia,string $numero): self
    {
        $this->valor_total_titulo = round($valor*100);
        $this->codigo_especie = $codigoEspecia;
        $this->texto_seu_numero = $numero;
        return $this;
    }

    public function setDescricaoInstrumentoCobranca($descricao_instrumento_cobranca){
        $this->descricao_instrumento_cobranca = $descricao_instrumento_cobranca;
        return $this;
    }

    public function setDataEmissao($data_emissao){
        $this->data_emissao = $data_emissao;
        return $this;
    }

    public function pagador(): Pagador
    {
        $pagador = new Pagador();

        $this->setPagador($pagador);

        return $pagador;
    }

    public function setPagador(Pagador $pagador): self
    {
        $this->pagador = $pagador;
        return $this;
    }

    public function dadosIndividuais(): DadosIndividuaisBoleto
    {
        $dados = new DadosIndividuaisBoleto();

        $this->setDadosIndividuaisBoleto($dados);

        return $dados;
    }

    public function setDadosIndividuaisBoleto(DadosIndividuaisBoleto $dados): self
    {
        array_push($this->dados_individuais_boleto, $dados);
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

    public function multa(): Multa
    {
        $multa = new Multa();

        $this->setMulta($multa);

        return $multa;
    }

    public function setMulta(Multa $multa): self
    {
        $this->multa = $multa;
        return $this;
    }

    
    public function recebimento_divergente(): RecebimentoDivergente
    {
        $recebimentoDivergente = new RecebimentoDivergente();

        $this->setRecebimentoDivergente($recebimentoDivergente);

        return $recebimentoDivergente;
    }

    public function setRecebimentoDivergente(RecebimentoDivergente $recebimentoDivergente): self
    {
        $this->recebimento_divergente = $recebimentoDivergente;
        return $this;
    }

}