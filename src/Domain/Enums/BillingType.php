<?php

namespace AsaasIntegracao\Domain\Enums;

enum BillingType: string
{
    case BOLETO = 'BOLETO';
    case CREDIT_CARD = 'CREDIT_CARD';
    case PIX = 'PIX';
}
