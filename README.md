# Instalação do projeto

## Requisitos

- php: `>=7.4`
- Composer: `^1.9`

## Considerações

Devido ao tempo curto para uma arquitetura mais robusta não foi possível aplicar testes de unidade nem de features que estavam em meu escopo para esse projeto, pelo mesmo motivo e por ter uma complexidade baixa,  alguns padrões de projetos também não foram implementados como por exemplo um `Observers` para notificar ações de alguns usuários após um pedido ser enviado, mas apliquei o `Singleton` que ao meu ver era essencial para garantir apenas uma instância de acesso à base de dados evitado assim consumo excessivo do mesmo.

## Instalação

Realize o clone do projeto para seu local de trabalho

```bash
git clone https://github.com/BrianXJ6/soft-expert-back.git
```

Após clonar o repositório, prepare seu arquivo de variáveis de ambiente, poderá renomear o arquivo `.env.example` ou realizar uma cópia via linha de comandos:

```bash
cp .env.example .env || mv .env.example .env
```

Se desejar, fique a vontade para alterar quaisquer valores em relação ao acesso a sua base de dados.
> Caso você opte por levantar o serviço da base de dados via docker, utilize o próprio nome o container que esse mapeamento de rede já está configurado.
>
### Docker

Caso o ambiente não seja compatível com os requisitos citados anteriormente, disponibilizei uma imagem lapidada com as libs necessárias para o bom funcionamento do projeto, com o arquivo `docker-compose` é possível subir os serviços da aplicação e da base de dados que serão usados, para isso, siga os passos abaixo, caso não seja necessário pode avançar para o próximo passo referente ao **Composer**.

Para subir os serviços de servidor e base de dados basta apenas executar o comando abaixo:

```bash
docker-compose up -d
```

Após todos os serviços estarem rodando, acesso o container da aplicação com o comando abaixo:

```bash
docker exec -it server /bin/bash
```

Estando dentro do container, execute o comando do Composer para instalar todas as dependências necessárias.

### Composer

Na raiz da aplicação, deixei um arquivo local do `composer.phar` para ser possível instalar todas as dependências do projeto:

```bash
composer update
```

### Database

Na raiz do projeto existe um arquivo chamado `backup.sql`, infelizmente minha ferramenta de banco de dados está com um bug e não foi possível gerar um dump nativo, sendo assim, basta apenas executar o script de criação das tabelas em seu SGBD para que tudo funcione bem.
