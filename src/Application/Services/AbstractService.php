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
}
