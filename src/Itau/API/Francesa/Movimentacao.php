<?php

namespace Itau\API\Francesa;

use Itau\API\TraitEntity;

class Movimentacao implements \JsonSerializable {

    use TraitEntity;

    private $agencia;
    private $conta;
    private $data_movimentacao;
    private $numero_carteira;
    private $codigo_status;
    private $nosso_numero;
    private $seu_numero;
    private $dac_titulo;
    private $tipo_cobranca;
    private $pagador;
    private $agencia_recebedora;
    private $data_movimentacao_titulo_carteira;
    private $data_inclusao_titulo_cobranca;
    private $data_vencimento;
    private $valor_titulo;
    private $valor_liquido_lancado;
    private $valor_acrescimo;
    private $valor_decrescimo;
    private $indicador_pagamento_reserva_administrativa;
    private $indicador_rateio_credito;
    private $dac_agencia_conta_beneficiario;
    private $operacoes_cobranca = [];

    // Getters e Setters para todos os atributos

    public function getAgencia() {
        return $this->agencia;
    }

    public function setAgencia($agencia) {
        $this->agencia = $agencia;
    }

    public function getConta() {
        return $this->conta;
    }

    public function setConta($conta) {
        $this->conta = $conta;
    }

    public function getDataMovimentacao() {
        return $this->data_movimentacao;
    }

    public function setDataMovimentacao($data_movimentacao) {
        $this->data_movimentacao = $data_movimentacao;
    }

    public function getNumeroCarteira() {
        return $this->numero_carteira;
    }

    public function setNumeroCarteira($numero_carteira) {
        $this->numero_carteira = $numero_carteira;
    }

    public function getCodigoStatus() {
        return $this->codigo_status;
    }

    public function setCodigoStatus($codigo_status) {
        $this->codigo_status = $codigo_status;
    }

    public function getNossoNumero() {
        return $this->nosso_numero;
    }

    public function setNossoNumero($nosso_numero) {
        $this->nosso_numero = $nosso_numero;
    }

    public function getSeuNumero() {
        return $this->seu_numero;
    }

    public function setSeuNumero($seu_numero) {
        $this->seu_numero = $seu_numero;
    }

    public function getDacTitulo() {
        return $this->dac_titulo;
    }

    public function setDacTitulo($dac_titulo) {
        $this->dac_titulo = $dac_titulo;
    }

    public function getTipoCobranca() {
        return $this->tipo_cobranca;
    }

    public function setTipoCobranca($tipo_cobranca) {
        $this->tipo_cobranca = $tipo_cobranca;
    }

    public function getPagador() {
        return $this->pagador;
    }

    public function setPagador($pagador) {
        $this->pagador = $pagador;
    }

    public function getAgenciaRecebedora() {
        return $this->agencia_recebedora;
    }

    public function setAgenciaRecebedora($agencia_recebedora) {
        $this->agencia_recebedora = $agencia_recebedora;
    }

    public function getDataMovimentacaoTituloCarteira() {
        return $this->data_movimentacao_titulo_carteira;
    }

    public function setDataMovimentacaoTituloCarteira($data_movimentacao_titulo_carteira) {
        $this->data_movimentacao_titulo_carteira = $data_movimentacao_titulo_carteira;
    }

    public function getDataInclusaoTituloCobranca() {
        return $this->data_inclusao_titulo_cobranca;
    }

    public function setDataInclusaoTituloCobranca($data_inclusao_titulo_cobranca) {
        $this->data_inclusao_titulo_cobranca = $data_inclusao_titulo_cobranca;
    }

    public function getDataVencimento() {
        return $this->data_vencimento;
    }

    public function setDataVencimento($data_vencimento) {
        $this->data_vencimento = $data_vencimento;
    }

    public function getValorTitulo() {
        return $this->valor_titulo;
    }

    public function setValorTitulo($valor_titulo) {
        $this->valor_titulo = $valor_titulo;
    }

    public function getValorLiquidoLancado() {
        return $this->valor_liquido_lancado;
    }

    public function setValorLiquidoLancado($valor_liquido_lancado) {
        $this->valor_liquido_lancado = $valor_liquido_lancado;
    }

    public function getValorAcrescimo() {
        return $this->valor_acrescimo;
    }

    public function setValorAcrescimo($valor_acrescimo) {
        $this->valor_acrescimo = $valor_acrescimo;
    }

    public function getValorDecrescimo() {
        return $this->valor_decrescimo;
    }

    public function setValorDecrescimo($valor_decrescimo) {
        $this->valor_decrescimo = $valor_decrescimo;
    }

    public function getIndicadorPagamentoReservaAdministrativa() {
        return $this->indicador_pagamento_reserva_administrativa;
    }

    public function setIndicadorPagamentoReservaAdministrativa($indicador_pagamento_reserva_administrativa) {
        $this->indicador_pagamento_reserva_administrativa = $indicador_pagamento_reserva_administrativa;
    }

    public function getIndicadorRateioCredito() {
        return $this->indicador_rateio_credito;
    }

    public function setIndicadorRateioCredito($indicador_rateio_credito) {
        $this->indicador_rateio_credito = $indicador_rateio_credito;
    }

    public function getDacAgenciaContaBeneficiario() {
        return $this->dac_agencia_conta_beneficiario;
    }

    public function setDacAgenciaContaBeneficiario($dac_agencia_conta_beneficiario) {
        $this->dac_agencia_conta_beneficiario = $dac_agencia_conta_beneficiario;
    }

    public function getOperacoesCobranca() {
        return $this->operacoes_cobranca;
    }

    public function setOperacoesCobranca(array $operacoes_cobranca) {
        $this->operacoes_cobranca = $operacoes_cobranca;
    }
}
?>
