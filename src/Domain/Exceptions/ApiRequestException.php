<?php

namespace AsaasIntegracao\Domain\Exceptions;

use RuntimeException;

class ApiRequestException extends RuntimeException
{
    protected array $problemDetails;

    public function __construct(array $problemDetails, int $code = 0, \Throwable $previous = null)
    {
        $this->problemDetails = $problemDetails;
        parent::__construct($problemDetails['detail'] ?? 'Erro na API', $code, $previous);
    }

    public function getProblemDetails(): array
    {
        return $this->problemDetails;
    }
}
