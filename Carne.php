<?php

class Carne {
    public $valor_total;
    public $qtd_parcelas;
    public $data_primeiro_vencimento;
    public $periodicidade;
    public $valor_entrada;

    public function __construct($valor_total, $qtd_parcelas, $data_primeiro_vencimento, $periodicidade, $valor_entrada = 0) {
        $this->valor_total = $valor_total;
        $this->qtd_parcelas = $qtd_parcelas;
        $this->data_primeiro_vencimento = $data_primeiro_vencimento;
        $this->periodicidade = $periodicidade;
        $this->valor_entrada = $valor_entrada;
    }

    private function validarDataPrimeiroVencimento()
    {
        if ($this->data_primeiro_vencimento < (new DateTime())->format('Y-m-d')) {
            throw new Exception('A data do primeiro vencimento não pode ser menor que a data atual.');
        }
    }

    public function gerarParcelas()
    {
        $this->validarDataPrimeiroVencimento();

        $parcelas = [];
        $valorRestante = $this->valor_total - $this->valor_entrada;
        $valorParcela = round($valorRestante / $this->qtd_parcelas, 2);
        $dataVencimento = new DateTime($this->data_primeiro_vencimento);

        if ($this->valor_entrada > 0) {
            $parcelas[] = [
                'numero' => 1,
                'valor' => $this->valor_entrada,
                'data_vencimento' => (new DateTime())->format('Y-m-d'),
                'entrada' => true
            ];

        }

        for ($i = 1; $i <= $this->qtd_parcelas; $i++) {
            $parcelas[] = [
                'numero' => $this->valor_entrada > 0 ? $i + 1 : $i,
                'valor' => $valorParcela,
                'data_vencimento' => $dataVencimento->format('Y-m-d'),
            ];
            $this->ajustaDataVencimento($dataVencimento);
        }

        return $parcelas;
    }

    private function ajustaDataVencimento(DateTime $dataVencimento)
    {
        if ($this->periodicidade == 'mensal') {
            $dataVencimento->modify('+1 month');
        } elseif ($this->periodicidade == 'semanal') {
            $dataVencimento->modify('+1 week');
        }
    }

}