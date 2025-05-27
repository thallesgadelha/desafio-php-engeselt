# 📦 Desafio Engeselt Softwares

Este projeto contém a resolução dos chamados do desafio proposto

---
## Funcionalidades Principais
1. Gestão de Chamados Técnicos
    - Criação de Chamados: Usuários podem registrar novos chamados técnicos, fornecendo detalhes como título, descrição, categoria e prioridade.
    - Acompanhamento: Visualização de uma lista de chamados com filtros por status e prioridade.
    - Detalhamento: Acesso a informações completas de cada chamado, incluindo histórico de respostas e status atual.

2. Respostas e Interações
    - Respostas Técnicas: Técnicos podem adicionar respostas aos chamados, mantendo um histórico de interações.
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

## Instalação e Configuração
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

---

### Usuários de Acesso

A aplicação conta com dois usuários para que você possa utilizar para testar a aplicação.

E-mail | Senha | Role
------ | ----- | ------
colaborador@mail.com | colaborador#engeselt | Colaborador
tecnico@mail.com | tecnico#engeselt | Técnico
