<?php

namespace AsaasIntegracao\Application\Services;

abstract class AbstractService extends Service
{
    abstract protected function createEntityFromResponse(string $response);

    /**
     * Listar
     *
     * @return array
     */
    public function index(): array
    {
        $response = $this->api();
        return json_decode($response, true);
    }

    /**
     * Criar
     *
     * @param array $payload
     */
    public function create(array $payload)
    {
        $response = $this->api("/", "POST", ["form_params" => $payload]);
        return $this->createEntityFromResponse($response);
    }

    /**
     * Mostrar
     *
     * @param string $id
     */
    public function show(string $id)
    {
        $response = $this->api("/$id");
        return $this->createEntityFromResponse($response);
    }

    /**
     * Atualizar
     *
     * @param string $id
     * @param array $payload
     */
    public function update(string $id, array $payload)
    {
        $response = $this->api("/$id", "PUT", ["json" => $payload]);
        return $this->createEntityFromResponse($response);
    }

    /**
     * Excluir
     *
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        return $this->api("/$id", "DELETE");
    }

    /**
     * Restaurar Exclusão
     *
     * @param string $id
     * @return bool
     */
    public function restore(string $id): bool
    {
        return $this->api("/$id/restore", "POST");
    }

    protected function handleApiResponse(string $response): array
    {
        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Resposta inválida da API: " . json_last_error_msg());
        }

        if (isset($data['errors']) && is_array($data['errors']) && count($data['errors']) > 0) {
            $messages = array_map(fn($err) => ($err['description'] ?? $err['code'] ?? 'Erro desconhecido'), $data['errors']);
            throw new \Exception("Erro da API: " . implode("; ", $messages));
        }

        if (isset($data['error'])) {
            throw new \Exception("Erro da API: " . $data['error']);
        }

        return $data;
    }
}
