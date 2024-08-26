<?php

namespace AsaasIntegracao\Domain\Entities;

class Cliente extends AbstractEntity {
    /**
     * Identificador único do cliente
     */
    public $id;

    /**
     * Data de criação do cliente
     */
    public $dateCreated;

    /**
     * Nome do cliente
     */
    public $name;

    /**
     * E-mail do cliente
     */
    public $email;

    /**
     * Telefone do cliente
     */
    public $phone;

    /**
     * Celular do cliente
     */
    public $mobilePhone;

    /**
     * Endereço do cliente
     */
    public $address;

    /**
     * Número do endereço do cliente
     */
    public $addressNumber;

    /**
     * Complemento do endereço do cliente
     */
    public $complement;

    /**
     * Bairro do endereço do cliente
     */
    public $province;

    /**
     * Identificador único da cidade no Asaas
     * @default 0
     */
    public $city = 0;

    /**
     * Cidade do endereço do cliente
     */
    public $cityName;

    /**
     * Estado do endereço do cliente
     */
    public $state;

    /**
     * País do cliente
     */
    public $country;

    /**
     * CEP do endereço do cliente
     */
    public $postalCode;

    /**
     * CPF ou CNPJ do cliente
     */
    public $cpfCnpj;

    /**
     * Tipo de pessoa (FISICA ou JURIDICA)
     */
    public $personType;

    /**
     * Indica se é um cliente deletado
     * @default true
     */
    public $deleted = true;

    /**
     * E-mails adicionais do cliente
     */
    public $additionalEmails = null;

    /**
     * Referência externa do cliente
     */
    public $externalReference = null;

    /**
     * Indica se as notificações estão desabilitadas
     * @default true
     */
    public $notificationDisabled = true;

    /**
     * Observações do cliente
     */
    public $observations = null;
}
