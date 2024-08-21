# README #
# Documentação Carnes API #

# 1. Instalação e Configuração do XAMPP #
XAMPP é um pacote de software gratuito que inclui o servidor Apache, PHP, MySQL, e outras ferramentas.

Passos:

Download e Instalação:
Baixe o XAMPP em *apachefriends.org*.
Instale o XAMPP no seu sistema.

Configuração:
Inicie o XAMPP Control Panel.
Inicie apemas o servidor Apache.

Verifique a Instalação:
Acesse http://localhost no seu navegador. Se o XAMPP estiver instalado corretamente, você verá a página inicial do XAMPP.

# 2. Instalar o Postman #

Download: Baixe o Postman do site oficial *postman.com*.
Instalação: Siga as instruções de instalação para o seu sistema operacional.
PORT: 80


# 3. Base URL #

http://localhost/carnes-api/index.php

- Criar Carnê de Pagamento -

Endpoint: /carne

Method: POST
Descrição: Este endpoint cria um novo carnê de pagamento.
Request Body (JSON):
{
  "valor_total": 0.98,
  "qtd_parcelas": 4,
  "data_primeiro_vencimento": "2024-09-01",
  "periodicidade": "semanal",
  "valor_entrada": 0.08
}

- Consultar Parcelas de um Carnê Específico -

Endpoint: /carne/{id_carne}/parcelas

Method: GET
Descrição: Este endpoint retorna as parcelas associadas a um carnê específico.
URL Parameters:

id_carne (integer): O ID do carnê para o qual as parcelas serão retornadas.
Exemplo de Request:
http://localhost/carnes-api/index.php/carne/1/parcelas


