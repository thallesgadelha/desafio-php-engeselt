# 📦 Desafio Engeselt Softwares

Este projeto contém a resolução dos chamados do desafio proposto

---
## Funcionalidades Principais
1. Gestão de Chamados
    - Criação de Chamados: Usuários podem registrar novos chamados técnicos, fornecendo detalhes como título, descrição, categoria e prioridade.
    - Acompanhamento: Visualização de uma lista de chamados com filtros por status e prioridade.
    - Detalhamento: Acesso a informações completas de cada chamado, incluindo histórico de respostas e status atual.

2. Respostas e Interações
    - Respostas: Técnicos podem adicionar respostas aos chamados, mantendo um histórico de interações.
    - Atualização de Status: Possibilidade de alterar o status do chamado para "Aberto", "Em atendimento", "Resolvido" ou "Fechado".

3. Gestão de Usuários e Permissões
    - Perfis de Usuário: Diferenciação entre colaboradores e técnicos.
    - Ativação/Inativação: Controle sobre o status ativo ou inativo dos usuários.
    - Alteração de Permissões: Interface para modificar o perfil e status de usuários existentes.

4. Exportação de Dados
    - Exportar PDF: Geração de relatórios em PDF dos chamados, com filtros aplicáveis por status e prioridade.
    - Exportar Excel (.xlsx): Exportação dos dados dos chamados em formato Excel, facilitando análises e compartilhamentos.
---

## Requisitos

- PHP >= 8.3
- Composer 2.8.5
- PostgreSQL 17
- Node.JS 22.15.1 (LTS)
- Docker 28.1

## Instalação e Configuração

As orientações de inicialização do projeto são as mesmas do repositório do desafio.

### Configurando o projeto localmente
1. Clone o repositório:
```
git clone https://github.com/thallesgadelha/desafio-php-engeselt.git
cd desafio-php-engeselt
```

2. Instale as dependências:
```
composer install
npm install
```

3. Configure o ambiente:
    - Copie o arquivo .env.example para .env:
        ```
        cp .env.example .env
        ```
    - Gere a chave da aplicação:
        ```
        php artisan key:generate
        ```

4. Execute as migrações e seeders:
```
php artisan migrate --seed
```

5. Compile os assets:
```
npm run dev
```

6. Inicie o servidor de desenvolvimento:
```
php artisan serve
```

### Configurando o projeto utilizando o Laradock
1° - Na raiz do projeto, utilize o comando abaixo para copiar o arquivo .env.laradock.example para a raiz do seu Laradock:
```
cp .env.laradock.example laradock/.env
```

Dependendo da sua estrutura de pastas, será necessário ajustar o path de destino.

2° - Cerifique-se de ter o Docker instalado, caso não tenha clique aqui para seguir o passo a passo para instalação.
3° - Na raiz do seu Laradock execute o comando abaixo:
```
docker compose up -d postgres nginx
```

Dependendo da sua conexão com internet, o processo pode ser um pouco demorado, pois ao executar pela primeira vez o Docker irá baixar as imagens dos respectivos containers.

4° - Crie a base de dados chamados que será utilizada pela aplicação:

Conecte-se ao container do PostgreSQL:
```
docker exec -it laradock-postgres-1 bash
```

Conecte-se ao servidor do PostgreSQL:
```
psql -h localhost -U default -w
```


Crie o banco de dados:
```
CREATE DATABASE chamados;
```


Desconecte-se do servidor do PostgreSQL:
```
\q
```


Por fim, encerre a sessão no bash do container:
```
exit
```

5° - Agora vamos: instalar as dependências do projeto, executar as migrations, executar as seeders, gerar a app key e instalar as dependências do front-end:

Conecte-se ao Workspace:
```
docker exec -it laradock-workspace-1 bash
```


Instale as dependências do projeto:
```
composer install
```


Execute as migrations:
```
php artisan migrate
```


Execute as seeders:
```
php artisan db:seed
```

Esse comando é responsável por popular seu banco de dados com alguns dados iniciais.


Gere a APP Key do Laravel:
```
php artisan key:generate
```

Instale as dependências do front-end:
```
npm install
```

6° - Ainda no Workspace, vamos executar o front-end da aplicação:
```
npm run dev
```

---

### Usuários de Acesso

A aplicação conta com dois usuários para que você possa utilizar para testar a aplicação.

E-mail | Senha | Role
------ | ----- | ------
colaborador@mail.com | colaborador#engeselt | Colaborador
tecnico@mail.com | tecnico#engeselt | Técnico
