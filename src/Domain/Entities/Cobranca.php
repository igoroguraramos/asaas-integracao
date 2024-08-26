<?php

namespace AsaasIntegracao\Domain\Entities;

class Cobranca extends AbstractEntity
{

    /**
     * Identificador único da cobrança no Asaas
     */
    public $id;

    /**
     * Identificador único do cliente ao qual a cobrança pertence
     */
    public $customer;

    /**
     * Data de criação da cobrança
     */
    public $dateCreated;

    /**
     * Data de vencimento da cobrança
     */
    public $dueDate;

    /**
     * Identificador único do parcelamento (quando cobrança parcelada)
     */
    public $installment = null;

    /**
     * Identificador único da assinatura (quando cobrança recorrente)
     */
    public $subscription = null;

    /**
     * Identificador único do link de pagamentos ao qual a cobrança pertence
     */
    public $paymentLink = null;

    /**
     * Valor da cobrança
     */
    public $value;

    /**
     * Valor líquido da cobrança após desconto da tarifa do Asaas
     */
    public $netValue;

    /**
     * Forma de pagamento
     */
    public $billingType;

    /**
     * Status da cobrança
     */
    public $status;

    /**
     * Descrição da cobrança
     */
    public $description = null;

    /**
     * Dias após o vencimento para cancelamento do registro (somente para boleto bancário)
     */
    public $daysAfterDueDateToRegistrationCancellation;

    /**
     * Campo livre para busca
     */
    public $externalReference = null;

    /**
     * Informa se a cobrança pode ser paga após o vencimento (Somente para boleto)
     */
    public $canBePaidAfterDueDate = true;

    /**
     * Identificador único da transação Pix à qual a cobrança pertence
     */
    public $pixTransaction = null;

    /**
     * Identificador único do QrCode estático gerado para determinada chave Pix
     */
    public $pixQrCodeId = null;

    /**
     * Valor original da cobrança (preenchido quando paga com juros e multa)
     */
    public $originalValue;

    /**
     * Valor calculado de juros e multa que deve ser pago após o vencimento da cobrança
     */
    public $interestValue;

    /**
     * Vencimento original no ato da criação da cobrança
     */
    public $originalDueDate;

    /**
     * Data de liquidação da cobrança no Asaas
     */
    public $paymentDate = null;

    /**
     * Data em que o cliente efetuou o pagamento do boleto
     */
    public $clientPaymentDate = null;

    /**
     * Número da parcela
     */
    public $installmentNumber = null;

    /**
     * URL do comprovante de confirmação, recebimento, estorno ou remoção
     */
    public $transactionReceiptUrl = null;

    /**
     * Identificação única do boleto
     */
    public $nossoNumero = null;

    /**
     * URL da fatura
     */
    public $invoiceUrl = null;

    /**
     * URL para download do boleto
     */
    public $bankSlipUrl = null;

    /**
     * Número da fatura
     */
    public $invoiceNumber = null;

    /**
     * Informações de desconto
     */
    public $discount;

    /**
     * Informações de multa para pagamento após o vencimento
     */
    public $fine;

    /**
     * Informações de juros para pagamento após o vencimento
     */
    public $interest;

    /**
     * Determina se a cobrança foi removida
     */
    public $deleted = true;

    /**
     * Define se a cobrança será enviada via Correios
     */
    public $postalService = true;

    /**
     * Define se a cobrança foi antecipada ou está em processo de antecipação
     */
    public $anticipated = true;

    /**
     * Determina se a cobrança é antecipável
     */
    public $anticipable = true;

    /**
     * Informações de estorno (array de objetos Refund)
     */
    public $refunds = [];

    /**
     * Informações de split (array de objetos Split)
     */
    public $split = [];

    /**
     * Informações de chargeback
     */
    public $chargeback;
}
