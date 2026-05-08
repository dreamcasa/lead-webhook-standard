# Webhook Dreamcasa — Payload Padrão

Esta documentação descreve o payload JSON enviado pelos webhooks da plataforma Dreamcasa.

> O uso de autenticação via token não se aplica neste modelo de integração.  
> Para habilitação ou informações adicionais, entre em contato através do formulário oficial:  
> https://dreamcasa.com.br/contato

---

# Estrutura do Payload

O webhook envia requisições HTTP contendo um JSON no seguinte formato:

```json
{
  "leadOrigin": "Dreamcasa",
  "clientListingId": "12345",
  "name": "João Silva",
  "email": "joao@email.com",
  "phoneNumber": "+55 27 99999-9999",
  "message": "Tenho interesse neste imóvel."
}
```

---

# Campos

| Campo | Tipo | Descrição |
|---|---|---|
| `leadOrigin` | `string` | Origem do lead. Valor fixo: `"Dreamcasa"` |
| `clientListingId` | `string` \| `number` | Identificador do imóvel no sistema do cliente |
| `name` | `string` | Nome do lead |
| `email` | `string` | E-mail do lead |
| `phoneNumber` | `string` | Telefone do lead |
| `message` | `string` | Mensagem enviada pelo lead |

---

# Método HTTP

```http
POST
```

---

# Headers

Os webhooks utilizam o header padrão:

```http
Content-Type: application/json
```

Nenhum header adicional de autenticação é enviado neste modelo.

---

# Exemplo de Requisição

```http
POST /webhook HTTP/1.1
Host: cliente.com.br
Content-Type: application/json
```

```json
{
  "leadOrigin": "Dreamcasa",
  "clientListingId": "98765",
  "name": "Maria Oliveira",
  "email": "maria@email.com",
  "phoneNumber": "+55 27 98888-7777",
  "message": "Gostaria de agendar uma visita."
}
```

---

# Observações

- O payload é enviado em formato JSON.
- O campo `token` não é incluído no corpo da requisição.
- O endpoint do cliente deve responder com status HTTP `200 OK` para confirmar o recebimento.
- Em caso de indisponibilidade temporária, novas tentativas de envio poderão ocorrer conforme política interna da plataforma.
