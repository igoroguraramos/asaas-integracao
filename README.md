# Requisitos
- PHP 7.4 ou superior
- Biblioteca Guzzle HTTP

# Iniciando
```php
require_once "./vendor/autoload.php";

use AsaasIntegracao\Domain\Config;
use AsaasIntegracao\Application\Asaas;

$config = new Config(
    [
        "accessToken" => '{{Token Gerado na Asaas}}',
        "baseUri" => "https://sandbox.asaas.com",
        "ssl" => false //setar apenas se for local para testes
    ]
);
$asaas = new Asaas($config);
```
# Exemplo de Uso
## Cliente
```php
$cliente = $asaas->cliente();

// Listar clientes
$users = $cliente->index();

// Criar novo cliente
$newUser = $cliente->create([
    'name' => 'John Doe',
    'cpfCnpj' => '00000000100'
]);

// Recuperar um único cliente
$user = $cliente->show('cus_G7Dvo4iphUNk');

// Atualizar cliente existente
$updatedUser = $cliente->update('cus_G7Dvo4iphUNk', [
    'name' => 'Jane Doe'
]);

// Remover cliente
$cliente->delete('cus_G7Dvo4iphUNk');

// Restaurar cliente removido
$cliente->restore('cus_G7Dvo4iphUNk');
```

## Cobrança
```php
use AsaasIntegracao\Domain\Enums\BillingType;

// Listar cobranças
$cobranca->index();

// Criar nova cobrança
$cobranca->create([
    'customer' => 'cus_G7Dvo4iphUNk',
    'billingType' => BillingType::BOLETO->value,
    'dueDate' => '2024-09-01',
    'value' => 150.00
]);

// Recuperar uma única cobrança
$cobranca->show('pay_G7Dvo4iphUNk');

// Atualizar cobrança existente
$cobranca->update('pay_G7Dvo4iphUNk', [
    'value' => 175.00
]);

// Excluir cobrança
$cobranca->delete('pay_G7Dvo4iphUNk');

// Restaurar cobrança removida
$cobranca->restore('pay_G7Dvo4iphUNk');

// Obter linha digitável do boleto
$cobranca->getLinhaDigitavel('pay_G7Dvo4iphUNk');

// Obter QR Code para pagamentos via Pix
$cobranca->getQrCode('pay_G7Dvo4iphUNk');
```

# Contribuição
Contribuições são bem-vindas! Sinta-se à vontade para abrir issues ou enviar pull requests.

# Licença
Este projeto está licenciado sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

# Documentação Base
https://docs.asaas.com/
