<?php
// /api-carne/helpers.php

function validateCreateCarneInput($data) {
    return isset($data['valor_total']) && isset($data['qtd_parcelas']) && isset($data['data_primeiro_vencimento']) && isset($data['periodicidade']);
}
