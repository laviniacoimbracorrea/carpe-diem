# 📸 Carpe Diem
### Plataforma Web para Fotógrafos Regionais

![Version](https://img.shields.io/badge/version-1.0-blue.svg)
![Status](https://img.shields.io/badge/status-em%20desenvolvimento-green.svg)
![License](https://img.shields.io/badge/license-Educacional-lightgrey.svg)

---
# 1. visão geral

# Sumário

1. Sobre o Projeto

2. Objetivos

3. Motivação

4. Problema

5. Solução Proposta

6. Público-Alvo

7. Funcionalidades Gerais

8. Arquitetura Geral

9. Visão Geral do Sistema

10. Fluxo Macro da Aplicação

11. Tecnologias Utilizadas

12. Estrutura Inicial do Projeto

13. API REST
   - 13.1 Introdução
   - 13.2 Arquitetura da API
   - 13.3 Arquitetura MVC
   - 13.4 Fluxo Geral da API
   - 13.5 Organização das Rotas
   - 13.6 Métodos HTTP
   - 13.7 Autenticação (JWT)
   - 13.8 Padrão das Respostas
   - 13.9 Endpoints da API
     - 13.9.1 Users
     - 13.9.2 Portfolios
     - 13.9.3 Photos
     - 13.9.4 Specialties
     - 13.9.5 Reviews
     - 13.9.6 Messages
     - 13.9.7 Contacts
     - 13.9.8 FAQs
     - 13.9.9 FAQ Categories
   - 13.10 Relacionamento entre as Entidades
   - 13.11 Tratamento de Erros
   - 13.12 Códigos HTTP Utilizados
   - 13.13 Como Executar a API
   - 13.14 Estrutura da API
   - 13.15 Tecnologias Utilizadas na API
   - 13.16 Segurança da Aplicação
   - 13.17 Escalabilidade
   - 13.18 Considerações Técnicas
   - 13.19 Considerações Finais

---

# Sobre o Projeto

O **Carpe Diem** é uma plataforma Web desenvolvida no modelo **Micro SaaS**, criada para conectar fotógrafos profissionais e clientes de maneira simples, organizada e segura.

O sistema foi idealizado para facilitar a divulgação do trabalho de fotógrafos regionais, permitindo que cada profissional possua um portfólio digital completo, organizado por categorias, localização e especialidades.

Além disso, o sistema proporciona aos clientes uma maneira prática de localizar profissionais próximos, visualizar trabalhos realizados e estabelecer contato através da própria plataforma.

---

# Objetivos

O principal objetivo do projeto é incentivar a valorização da fotografia regional através de uma plataforma especializada.

Entre seus objetivos específicos destacam-se:

- Centralizar fotógrafos em uma única plataforma.
- Facilitar a divulgação profissional.
- Organizar portfólios digitais.
- Aproximar clientes dos profissionais.
- Melhorar a comunicação entre ambas as partes.
- Eliminar a necessidade de divulgação exclusivamente pelas redes sociais.
- Incentivar o empreendedorismo local.

---

# Motivação

Grande parte dos fotógrafos independentes enfrenta dificuldades para divulgar seu trabalho de forma profissional.

Normalmente utilizam redes sociais como principal ferramenta de divulgação, ocasionando problemas como:

- baixa organização dos portfólios;
- dificuldade para serem encontrados;
- pouca visibilidade regional;
- comunicação descentralizada;
- mistura entre vida pessoal e profissional.

O projeto busca solucionar exatamente essas dificuldades.

---

# Problema

Atualmente não existe uma plataforma regional que permita localizar fotógrafos utilizando filtros específicos como:

- cidade;
- região;
- especialidade;
- estilo fotográfico;
- portfólio.

Essa dificuldade faz com que clientes utilizem mecanismos pouco eficientes para contratar profissionais.

Ao mesmo tempo, fotógrafos possuem dificuldades para captar novos clientes.

---

# Solução Proposta

A plataforma permitirá que fotógrafos possam:

- criar perfil profissional;
- cadastrar portfólio;
- divulgar serviços;
- informar localização;
- informar especialidades;
- conversar com clientes.

Já os clientes poderão:

- pesquisar fotógrafos;
- visualizar portfólios;
- comparar profissionais;
- entrar em contato;
- solicitar informações.

---

# Público-Alvo

## Fotógrafos

Destinado para profissionais:

- iniciantes;
- intermediários;
- experientes.

Necessidades:

- divulgação profissional;
- novos clientes;
- organização do portfólio;
- fortalecimento da marca pessoal.

---

## Clientes

Pessoas físicas.

Empresas.

Agências.

Organizadores de eventos.

Necessidades:

- encontrar fotógrafos próximos;
- visualizar trabalhos;
- comparar profissionais;
- contratar serviços.

---

## Administradores

Responsáveis pela gestão da plataforma.

Principais responsabilidades:

- gerenciamento de usuários;
- aprovação de cadastros;
- moderação de conteúdo;
- monitoramento do sistema.

---

# Funcionalidades Gerais

A plataforma contará inicialmente com:

✔ Cadastro de usuários

✔ Login

✔ Recuperação de senha

✔ Cadastro de fotógrafos

✔ Cadastro de clientes

✔ Perfil profissional

✔ Upload de fotos

✔ Organização por álbuns

✔ Pesquisa por cidade

✔ Pesquisa por região

✔ Pesquisa por especialidade

✔ Sistema de mensagens

✔ Painel administrativo

✔ Gerenciamento de usuários

✔ Aprovação de fotógrafos

✔ Exclusão de contas

---

# Arquitetura Geral

```
                    Cliente

                       │

               Interface Web

                       │

               Camada de Aplicação

                       │

               Regras de Negócio

                       │

                 Banco de Dados
```

O sistema seguirá uma arquitetura em camadas visando facilitar manutenção, escalabilidade e organização do código.

---

# Visão Geral do Sistema

```
Cliente

↓

Tela Inicial

↓

Pesquisa

↓

Lista de Fotógrafos

↓

Perfil do Fotógrafo

↓

Portfólio

↓

Contato

↓

Negociação
```

---

# Fluxo Macro

```
Cadastro

↓

Login

↓

Pesquisa

↓

Visualização

↓

Contato

↓

Contratação
```

---

# Tecnologias Previstas

Frontend

- HTML5
- CSS3
- JavaScript

Backend

- PHP

Banco de Dados

- MySQL

Ferramentas

- VS Code
- Git
- GitHub
- XAMPP

---

# Estrutura Inicial do Projeto

```
  carpe-diem/

│

├── assets/

├── css/

├── js/

├── images/

├── pages/

├── php/

├── uploads/

├── database/

├── includes/

├── config/

├── README.md

└── index.php
```

---

# Primeira Versão (MVP)

O MVP deverá contemplar:

- cadastro de usuários;
- login;
- perfil de fotógrafo;
- upload de portfólio;
- pesquisa por cidade;
- pesquisa por especialidade;
- envio de mensagens.

Essas funcionalidades representam o núcleo do sistema e servirão como base para evoluções futuras.

---

#  2. Arquitetura do Sistema

## Visão Arquitetural

O PhotoConnect será desenvolvido utilizando uma arquitetura em camadas (Layered Architecture), separando responsabilidades para facilitar manutenção, testes e evolução do sistema.

```
+------------------------------------------------------+
|                  Interface do Usuário                |
|          (HTML • CSS • JavaScript • Bootstrap)       |
+------------------------------------------------------+
                        │
                        ▼
+------------------------------------------------------+
|                Camada de Apresentação                |
|      Telas, formulários e interação com usuário      |
+------------------------------------------------------+
                        │
                        ▼
+------------------------------------------------------+
|                Camada de Aplicação                   |
|        Regras de negócio e processamento             |
+------------------------------------------------------+
                        │
                        ▼
+------------------------------------------------------+
|                 Camada de Persistência               |
|         PHP + SQL + Banco de Dados MySQL             |
+------------------------------------------------------+
                        │
                        ▼
+------------------------------------------------------+
|                     Banco de Dados                   |
+------------------------------------------------------+
```

---

# Componentes do Sistema

O sistema será dividido em módulos independentes para facilitar a organização do desenvolvimento.

## Módulo de Autenticação

Responsável por:

- Cadastro de usuários
- Login
- Recuperação de senha
- Controle de sessão
- Encerramento da sessão

---

## Módulo de Fotógrafos

Responsável por:

- Cadastro profissional
- Perfil público
- Portfólio
- Especialidades
- Cidade
- Região
- Serviços oferecidos

---

## Módulo de Clientes

Responsável por:

- Cadastro
- Pesquisa de fotógrafos
- Favoritos
- Histórico de contatos
- Solicitações

---

## Módulo de Mensagens

Responsável por:

- Conversa entre cliente e fotógrafo
- Histórico
- Notificações
- Organização das conversas

---

## Módulo Administrativo

Responsável por:

- Aprovação de cadastros
- Gerenciamento de usuários
- Moderação
- Estatísticas
- Auditoria

---

# Requisitos Funcionais

## RF001

O sistema deverá permitir cadastro de clientes.

---

## RF002

O sistema deverá permitir cadastro de fotógrafos.

---

## RF003

O fotógrafo poderá editar seu perfil profissional.

---

## RF004

O fotógrafo poderá enviar fotografias para seu portfólio.

---

## RF005

O cliente poderá pesquisar fotógrafos.

---

## RF006

A pesquisa deverá permitir filtros por:

- cidade
- região
- especialidade

---

## RF007

O cliente poderá visualizar o perfil completo.

---

## RF008

O cliente poderá visualizar o portfólio.

---

## RF009

O cliente poderá iniciar uma conversa.

---

## RF010

O administrador poderá aprovar ou rejeitar cadastros.

---

## RF011

O administrador poderá excluir usuários.

---

## RF012

O sistema deverá registrar logs básicos de utilização.

---

# Requisitos Não Funcionais

## RNF001

Sistema responsivo.

---

## RNF002

Compatível com:

- Google Chrome
- Microsoft Edge
- Firefox

---

## RNF003

Tempo médio de carregamento inferior a 3 segundos.

---

## RNF004

Banco de dados relacional.

---

## RNF005

Comunicação segura.

---

## RNF006

Interface intuitiva.

---

## RNF007

Facilidade de manutenção.

---

# Regras de Negócio

## RN001

Cada fotógrafo possuirá apenas um perfil.

---

## RN002

Um cliente poderá conversar com vários fotógrafos.

---

## RN003

Um fotógrafo poderá atender diversos clientes.

---

## RN004

Somente usuários autenticados poderão enviar mensagens.

---

## RN005

O administrador possui acesso total ao sistema.

---

## RN006

Portfólios deverão possuir apenas imagens válidas.

---

## RN007

Usuários desativados não poderão acessar o sistema.

---

# Casos de Uso

## Cliente

- Criar conta
- Fazer login
- Pesquisar fotógrafo
- Aplicar filtros
- Visualizar perfil
- Visualizar portfólio
- Conversar
- Editar cadastro

---

## Fotógrafo

- Criar perfil
- Atualizar informações
- Publicar fotos
- Responder mensagens
- Gerenciar portfólio

---

## Administrador

- Gerenciar usuários
- Aprovar fotógrafos
- Excluir contas
- Visualizar estatísticas
- Moderar conteúdo

---

# Fluxo de Cadastro

```
Início

↓

Preenchimento do formulário

↓

Validação

↓

Cadastro realizado

↓

Login

↓

Painel do usuário
```

---

# Fluxo de Pesquisa

```
Cliente

↓

Tela de pesquisa

↓

Seleciona cidade

↓

Seleciona especialidade

↓

Lista de fotógrafos

↓

Perfil

↓

Contato
```

---

# Fluxo das Mensagens

```
Cliente

↓

Seleciona fotógrafo

↓

Nova conversa

↓

Envio

↓

Recebimento

↓

Resposta

↓

Histórico
```

---

# Estrutura de Diretórios

```
carpe-diem/

assets/
│
├── css/
├── js/
├── fonts/
├── icons/
└── images/

config/
│
├── database.php
├── session.php
└── constants.php

includes/
│
├── header.php
├── footer.php
├── menu.php
└── functions.php

pages/
│
├── login.php
├── cadastro.php
├── perfil.php
├── pesquisa.php
├── mensagens.php
└── administrador.php

uploads/
│
├── portfolio/
└── avatar/

database/
│
├── schema.sql
├── seed.sql
└── backup/

README.md
index.php
```

---

# Modelo Conceitual

Principais entidades:

- Usuário
- Fotógrafo
- Cliente
- Portfólio
- Fotografia
- Mensagem
- Cidade
- Especialidade

Relacionamentos:

- Um fotógrafo possui um perfil.
- Um perfil possui vários portfólios.
- Um portfólio possui várias fotografias.
- Um cliente pode conversar com diversos fotógrafos.
- Um fotógrafo pode receber mensagens de diversos clientes.

---

# Padrões de Desenvolvimento

## Convenções de Nomenclatura

### Arquivos

- letras minúsculas
- palavras separadas por "_"

Exemplo:

```
cadastro_cliente.php
```

### Variáveis

Utilizar camelCase.

```
nomeCliente
cidadeSelecionada
fotoPrincipal
```

### Classes

Utilizar PascalCase.

```
Usuario
Fotografo
Mensagem
Portfolio
```

### Banco de Dados

Tabelas:

```
usuarios
fotografos
mensagens
portfolio
```

Campos:

```
id_usuario
nome
email
senha
cidade
```

---

# Próximas Evoluções

- Avaliação de fotógrafos
- Sistema de favoritos
- Agenda de disponibilidade
- Pagamentos online
- Assinatura Premium
- Notificações por e-mail
- Dashboard do fotógrafo
- Relatórios administrativos

---

# 3. Banco de Dados

## Visão Geral

O banco de dados do PhotoConnect será desenvolvido utilizando **MySQL**, seguindo o modelo relacional para garantir integridade, desempenho e facilidade de manutenção.

Toda a estrutura foi projetada para permitir crescimento da plataforma sem necessidade de grandes alterações estruturais.

Características:

- Banco Relacional
- Integridade Referencial
- Normalização (3FN)
- Chaves Primárias
- Chaves Estrangeiras
- Índices para pesquisas
- Controle de integridade dos dados

---

# Modelo Entidade Relacionamento (MER)

Entidades principais:

```

USUARIO
│
├── CLIENTE
│
├── FOTOGRAFO
│ │
│ ├── PORTFOLIO
│ │ │
│ │ └── FOTO
│ │
│ ├── ESPECIALIDADE
│ │
│ └── CIDADE
│
└── MENSAGEM

```

---

# Relacionamentos

| Origem | Relacionamento | Destino |
|----------|----------------|----------|
| Usuário | 1 : 1 | Cliente |
| Usuário | 1 : 1 | Fotógrafo |
| Fotógrafo | 1 : N | Portfólio |
| Portfólio | 1 : N | Fotografias |
| Cliente | N : N | Fotógrafos |
| Cliente | 1 : N | Mensagens |
| Fotógrafo | 1 : N | Mensagens |

---

# Dicionário de Dados

## Tabela usuarios

Finalidade:

Armazenar todos os usuários cadastrados.

Campos

| Campo | Tipo | Obrigatório |
|--------|------|-------------|
| id_usuario | INT | Sim |
| nome | VARCHAR(150) | Sim |
| email | VARCHAR(150) | Sim |
| senha | VARCHAR(255) | Sim |
| telefone | VARCHAR(20) | Não |
| tipo | ENUM | Sim |
| status | ENUM | Sim |
| data_cadastro | DATETIME | Sim |

---

## SQL

```sql
CREATE TABLE usuarios (

id_usuario INT AUTO_INCREMENT PRIMARY KEY,

nome VARCHAR(150) NOT NULL,

email VARCHAR(150) UNIQUE,

senha VARCHAR(255),

telefone VARCHAR(20),

tipo ENUM('cliente','fotografo','admin'),

status ENUM('ativo','inativo'),

data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP

);
```

---

# Tabela fotografos

Descrição

Armazena informações profissionais.

Campos

| Campo | Tipo |
|---------|------|
| id_fotografo | INT |
| id_usuario | INT |
| biografia | TEXT |
| cidade | VARCHAR(100) |
| especialidade | VARCHAR(100) |
| instagram | VARCHAR(150) |
| site | VARCHAR(150) |

---

SQL

```sql
CREATE TABLE fotografos (

id_fotografo INT AUTO_INCREMENT PRIMARY KEY,

id_usuario INT,

biografia TEXT,

cidade VARCHAR(100),

especialidade VARCHAR(100),

instagram VARCHAR(150),

site VARCHAR(150),

FOREIGN KEY(id_usuario)

REFERENCES usuarios(id_usuario)

);
```

---

# Tabela clientes

Campos

| Campo | Tipo |
|---------|------|
| id_cliente | INT |
| id_usuario | INT |

SQL

```sql
CREATE TABLE clientes (

id_cliente INT AUTO_INCREMENT PRIMARY KEY,

id_usuario INT,

FOREIGN KEY(id_usuario)

REFERENCES usuarios(id_usuario)

);
```

---

# Tabela portfolio

Campos

| Campo | Tipo |
|---------|------|
| id_portfolio | INT |
| id_fotografo | INT |
| titulo | VARCHAR |
| descricao | TEXT |
| data_criacao | DATETIME |

---

SQL

```sql
CREATE TABLE portfolio (

id_portfolio INT AUTO_INCREMENT PRIMARY KEY,

id_fotografo INT,

titulo VARCHAR(120),

descricao TEXT,

data_criacao DATETIME,

FOREIGN KEY(id_fotografo)

REFERENCES fotografos(id_fotografo)

);
```

---

# Tabela fotos

Campos

| Campo | Tipo |
|---------|------|
| id_foto | INT |
| id_portfolio | INT |
| caminho | VARCHAR |
| legenda | VARCHAR |
| data_upload | DATETIME |

---

SQL

```sql
CREATE TABLE fotos (

id_foto INT AUTO_INCREMENT PRIMARY KEY,

id_portfolio INT,

caminho VARCHAR(255),

legenda VARCHAR(255),

data_upload DATETIME,

FOREIGN KEY(id_portfolio)

REFERENCES portfolio(id_portfolio)

);
```

---

# Tabela mensagens

Campos

| Campo | Tipo |
|---------|------|
| id_mensagem | INT |
| remetente | INT |
| destinatario | INT |
| mensagem | TEXT |
| data_envio | DATETIME |
| lida | BOOLEAN |

---

SQL

```sql
CREATE TABLE mensagens (

id_mensagem INT AUTO_INCREMENT PRIMARY KEY,

remetente INT,

destinatario INT,

mensagem TEXT,

data_envio DATETIME,

lida BOOLEAN,

FOREIGN KEY(remetente)

REFERENCES usuarios(id_usuario),

FOREIGN KEY(destinatario)

REFERENCES usuarios(id_usuario)

);
```

---

# Integridade Referencial

O banco utilizará:

- Primary Keys
- Foreign Keys
- UNIQUE
- NOT NULL
- AUTO_INCREMENT

garantindo consistência dos dados.

---

# Índices

Serão criados índices para melhorar pesquisas.

```sql
CREATE INDEX idx_usuario_email

ON usuarios(email);

CREATE INDEX idx_fotografo_cidade

ON fotografos(cidade);

CREATE INDEX idx_especialidade

ON fotografos(especialidade);
```

---

# Normalização

O banco segue até a **Terceira Forma Normal (3FN)**.

Benefícios:

- elimina redundância;
- reduz inconsistências;
- melhora manutenção;
- melhora desempenho.

---

# Fluxo de Persistência

```
Usuário

↓

Preenche formulário

↓

Controller

↓

Validação

↓

Model

↓

Banco MySQL

↓

Retorno

↓

Tela
```

---

# Backup

Recomenda-se:

- Backup diário
- Backup semanal completo
- Backup mensal arquivado
- Testes periódicos de restauração

---

# Segurança do Banco

Boas práticas:

- utilização de Prepared Statements;
- senhas com hash (password_hash);
- validação de entrada;
- controle de permissões;
- proteção contra SQL Injection;
- proteção contra XSS;
- proteção contra CSRF.

---

# Plano de Crescimento

O modelo foi preparado para futuras expansões, incluindo:

- Avaliações dos fotógrafos
- Agenda de disponibilidade
- Sistema de pagamentos
- Planos Premium
- Marketplace
- API REST
- Aplicativo Mobile
- Integração com Google Maps
- Notificações em tempo real
- Dashboard analítico

---

## 4. Paronama geral 

O Carpe Diem foi desenvolvido para conectar fotógrafos e clientes por meio de uma plataforma web centralizada, permitindo divulgação profissional, pesquisa por localização, gerenciamento de portfólios e comunicação segura.

Todos os usuários acessam o mesmo sistema, porém cada perfil possui permissões específicas.

---

# Perfis de Usuário

O sistema possui três perfis principais.

## Cliente

O cliente é o usuário responsável pela contratação dos serviços.

### Permissões

✔ Criar conta

✔ Fazer login

✔ Editar perfil

✔ Alterar senha

✔ Pesquisar fotógrafos

✔ Filtrar pesquisas

✔ Visualizar portfólios

✔ Favoritar fotógrafos (futuro)

✔ Enviar mensagens

✔ Excluir conta

---

## Fotógrafo

É o profissional responsável por divulgar seus serviços.

### Permissões

✔ Criar perfil profissional

✔ Editar informações

✔ Alterar foto de perfil

✔ Publicar fotografias

✔ Criar portfólios

✔ Excluir fotografias

✔ Responder mensagens

✔ Atualizar especialidades

✔ Atualizar cidade

✔ Atualizar redes sociais

---

## Administrador

Responsável pela gestão completa da plataforma.

### Permissões

✔ Gerenciar usuários

✔ Aprovar fotógrafos

✔ Bloquear usuários

✔ Excluir contas

✔ Moderar conteúdo

✔ Emitir relatórios

✔ Gerenciar categorias

✔ Gerenciar especialidades

✔ Monitorar acessos

---

# Fluxo Geral do Sistema

```
Acesso

↓

Login

↓

Identificação do Perfil

↓

Dashboard

↓

Operações

↓

Logout
```

---

# Fluxo do Cliente

```
Cadastro

↓

Login

↓

Pesquisa

↓

Aplica filtros

↓

Lista de fotógrafos

↓

Perfil

↓

Portfólio

↓

Mensagem

↓

Contratação
```

---

# Fluxo do Fotógrafo

```
Cadastro

↓

Login

↓

Completar Perfil

↓

Cadastrar Portfólio

↓

Publicar Fotos

↓

Receber Mensagens

↓

Responder Clientes
```

---

# Fluxo do Administrador

```
Login

↓

Dashboard

↓

Usuários

↓

Aprovação

↓

Monitoramento

↓

Relatórios
```

---

# Dashboard do Cliente

O painel do cliente deverá apresentar:

- Dados pessoais
- Histórico de mensagens
- Fotógrafos favoritos
- Pesquisas recentes
- Perfil editável
- Alteração de senha

---

# Dashboard do Fotógrafo

O painel do fotógrafo deverá conter:

- Foto de perfil
- Biografia
- Especialidades
- Cidade
- Portfólios
- Quantidade de fotos
- Mensagens
- Estatísticas de visualizações (futuro)

---

# Dashboard Administrativo

Informações disponíveis:

- Usuários cadastrados
- Fotógrafos ativos
- Clientes ativos
- Cadastros pendentes
- Fotos publicadas
- Mensagens enviadas
- Relatórios
- Logs

---

# Regras de Negócio

## Cadastro

Todo usuário deverá possuir:

- Nome
- E-mail válido
- Senha segura

O e-mail não poderá estar duplicado.

---

## Login

O acesso somente será permitido mediante:

- e-mail válido;
- senha correta;
- conta ativa.

---

## Perfil do Fotógrafo

O perfil deverá conter no mínimo:

- Foto
- Nome
- Cidade
- Especialidade
- Biografia

Sem essas informações o perfil ficará incompleto.

---

## Portfólio

Cada fotógrafo poderá possuir vários portfólios.

Cada portfólio poderá conter diversas fotografias.

Cada fotografia deverá possuir:

- título (opcional);
- descrição (opcional);
- imagem.

---

## Pesquisa

A pesquisa poderá utilizar os seguintes filtros:

Cidade

Especialidade

Nome

Região

Categoria

---

# Casos de Uso

## UC01

Cadastrar Cliente

Ator:

Cliente

Fluxo:

1. Acessa cadastro.

2. Preenche formulário.

3. Sistema valida dados.

4. Cadastro concluído.

---

## UC02

Cadastrar Fotógrafo

Fluxo:

1. Cadastro.

2. Login.

3. Completa perfil.

4. Aguarda aprovação (caso implementado).

---

## UC03

Pesquisar Fotógrafos

Fluxo:

1. Cliente acessa pesquisa.

2. Seleciona filtros.

3. Sistema consulta banco.

4. Exibe resultados.

---

## UC04

Visualizar Portfólio

Fluxo:

1. Cliente seleciona fotógrafo.

2. Sistema abre perfil.

3. Exibe fotografias.

---

## UC05

Enviar Mensagem

Fluxo:

1. Cliente abre conversa.

2. Digita mensagem.

3. Sistema registra envio.

4. Fotógrafo recebe notificação.

---

## UC06

Responder Mensagem

Fluxo:

1. Fotógrafo acessa conversa.

2. Visualiza histórico.

3. Responde cliente.

---

## UC07

Editar Perfil

Fluxo:

1. Usuário acessa perfil.

2. Atualiza informações.

3. Sistema valida.

4. Salva alterações.

---

# Validações

## Cadastro

Obrigatórios:

- Nome
- Email
- Senha

---

## Senha

Mínimo recomendado:

- 8 caracteres

Sugestão:

- letra maiúscula
- letra minúscula
- número
- caractere especial

---

## Upload de Fotos

Permitir:

JPEG

PNG

WEBP

Limite sugerido:

10 MB por imagem

---

# Mensagens de Erro

Exemplos:

"E-mail já cadastrado."

"Senha inválida."

"Usuário não encontrado."

"Imagem não suportada."

"Campo obrigatório."

"Arquivo excede tamanho permitido."

---

# Tratamento de Exceções

O sistema deverá registrar:

- erros de banco;
- erros de autenticação;
- uploads inválidos;
- tentativas de acesso não autorizado;
- falhas internas.

Todos os erros deverão ser registrados em log para análise.

---

# Sessão do Usuário

Após autenticação:

- criação da sessão;
- identificação do perfil;
- carregamento das permissões;
- redirecionamento para dashboard.

Ao realizar logout:

- destruir sessão;
- limpar variáveis;
- retornar à tela inicial.

---

# Controle de Permissões

| Funcionalidade | Cliente | Fotógrafo | Administrador |
|----------------|:-------:|:---------:|:-------------:|
| Login | ✔ | ✔ | ✔ |
| Editar Perfil | ✔ | ✔ | ✔ |
| Pesquisar Fotógrafos | ✔ | ✔ | ✔ |
| Publicar Fotos | ✖ | ✔ | ✖ |
| Mensagens | ✔ | ✔ | ✔ |
| Gerenciar Usuários | ✖ | ✖ | ✔ |
| Aprovar Cadastros | ✖ | ✖ | ✔ |

---

# 5. Instalação e Configuração

## Requisitos do Sistema

Antes de iniciar a instalação, certifique-se de possuir os seguintes softwares instalados.

### Servidor Web

- Apache 2.4 ou superior

### PHP

Versão recomendada:

```
PHP 8.2+
```

### Banco de Dados

```
MySQL 8+
```

### Navegadores Compatíveis

- Google Chrome
- Microsoft Edge
- Mozilla Firefox
- Opera

---

# Ferramentas Utilizadas

## Desenvolvimento

- Visual Studio Code

## Banco de Dados

- MySQL Workbench
- phpMyAdmin

## Controle de Versão

- Git

## Hospedagem do Código

- GitHub

---

# Clonando o Projeto

```bash
git clone https://github.com/usuario/photoconnect.git
```

Entrar na pasta

```bash
cd photoconnect
```

---

# Estrutura do Ambiente

```
Apache

↓

PHP

↓

MySQL

↓

carpe-diem
```

---

# Configuração do Banco

Criar um banco chamado

```sql
projeto
```

Importar

```
database/schema.sql
```

Depois executar

```
database/seed.sql
```

caso exista.

---

# Arquivo de Configuração

Criar um arquivo

```
config/database.php
```

Exemplo:

```php
<?php

$host = "localhost";

$db = "projeto";

$user = "root";

$password = "";

$conn = new mysqli($host,$user,$password,$db);

?>
```

---

# Organização do Código

O projeto seguirá separação por responsabilidades.

```
config/

assets/

database/

pages/

uploads/

includes/

controllers/

models/

services/

helpers/

middlewares/

logs/
```

---

# Descrição das Pastas

## assets

Arquivos estáticos.

Contém:

- CSS
- JavaScript
- Imagens
- Ícones

---

## config

Configurações do sistema.

Exemplos:

- banco
- constantes
- sessões

---

## controllers

Responsáveis por receber as requisições.

Exemplo:

```
UsuarioController.php

LoginController.php

PortfolioController.php
```

---

## models

Representação das entidades.

Exemplo:

```
Usuario.php

Cliente.php

Fotografo.php

Mensagem.php
```

---

## services

Implementação das regras de negócio.

Exemplos:

```
UsuarioService

MensagemService

PortfolioService
```

---

## helpers

Funções auxiliares.

Exemplo:

```
formatarTelefone()

validarEmail()

uploadImagem()
```

---

## middlewares

Controle de autenticação.

Controle de permissões.

Validação das sessões.

---

## uploads

Armazenamento das imagens enviadas pelos fotógrafos.

Estrutura sugerida:

```
uploads/

avatars/

portfolio/

temporarios/
```

---

## logs

Registro de eventos importantes.

Exemplos:

```
login.log

erros.log

uploads.log
```

---

# Fluxo das Requisições

```
Cliente

↓

Página

↓

Controller

↓

Service

↓

Model

↓

Banco

↓

Retorno

↓

Tela
```

---

# Padrões de Desenvolvimento

## Identação

Utilizar quatro espaços.

---

## Nomenclatura

### Classes

PascalCase

```
UsuarioService
```

### Métodos

camelCase

```
buscarFotografo()

salvarPortfolio()

enviarMensagem()
```

### Variáveis

camelCase

```
nomeUsuario

cidadeSelecionada

fotoPrincipal
```

---

# Tratamento de Erros

Todos os erros deverão possuir tratamento.

Exemplo

```php
try{

// processamento

}catch(Exception $e){

// registrar log

}
```

---

# Logs

O sistema deverá registrar:

- Login

- Logout

- Alterações de perfil

- Uploads

- Exclusões

- Erros

- Falhas

---

# Segurança

## Senhas

Nunca armazenar senhas em texto.

Utilizar

```php
password_hash()
```

e

```php
password_verify()
```

---

## SQL Injection

Todas as consultas deverão utilizar

Prepared Statements.

---

## XSS

Escapar toda saída HTML.

---

## CSRF

Utilizar tokens de validação para formulários.

---

## Uploads

Validar:

- extensão

- MIME Type

- tamanho

- nome do arquivo

---

# Performance

Boas práticas:

✔ Índices no banco

✔ Compressão de imagens

✔ Lazy Loading

✔ Cache

✔ Consultas otimizadas

✔ Paginação

---

# Testes

## Testes Funcionais

- Cadastro

- Login

- Pesquisa

- Mensagens

- Upload

---

## Testes de Interface

- Responsividade

- Navegação

- Compatibilidade

---

## Testes de Banco

- Integridade

- Performance

- Índices

---

## Testes de Segurança

- SQL Injection

- XSS

- CSRF

- Upload malicioso

---

# Versionamento

Fluxo Git sugerido.

```
main

develop

feature/*
```

Exemplo

```
feature/login

feature/mensagens

feature/portfolio
```

---

# Convenção de Commits

```
feat:

fix:

refactor:

docs:

style:

test:

chore:
```

Exemplos

```
feat: cadastro de fotógrafos

fix: correção do login

docs: atualização do README

refactor: melhoria da pesquisa
```

---

# Deploy

Fluxo sugerido.

```
Desenvolvimento

↓

Homologação

↓

Testes

↓

Produção
```

Checklist antes da publicação

- Banco atualizado

- Backup realizado

- Logs limpos

- Variáveis configuradas

- Testes executados

- Uploads validados

---

# Manutenção

Rotinas recomendadas.

Diariamente

- Verificar logs

- Verificar erros

Semanalmente

- Backup

- Limpeza de arquivos temporários

Mensalmente

- Atualização de dependências

- Revisão de permissões

- Otimização do banco

---

# Boas Práticas

✔ Código limpo

✔ Métodos pequenos

✔ Comentários quando necessários

✔ Responsabilidade única

✔ Evitar duplicação

✔ Padronização de nomenclatura

✔ Separação entre lógica e interface

✔ Controle de versão

✔ Documentação atualizada

---

# Conclusão

O PhotoConnect foi concebido para oferecer uma solução escalável, organizada e de fácil manutenção, conectando fotógrafos e clientes em um ambiente seguro e intuitivo.

A adoção das práticas descritas neste README contribui para um desenvolvimento consistente, facilita a colaboração entre os integrantes da equipe e prepara o projeto para futuras evoluções, como aplicativos móveis, integração com mapas, sistemas de avaliação e novos serviços voltados ao mercado da fotografia.

---

# 6. Diagramas UML

## Diagrama de Casos de Uso

```text
                    +----------------------+
                    |      Cliente         |
                    +----------------------+
                           |
      ------------------------------------------------
      |            |            |          |          |
      ▼            ▼            ▼          ▼          ▼
Cadastrar      Pesquisar    Visualizar  Mensagem   Editar
 Conta        Fotógrafos    Portfólio              Perfil


                    +----------------------+
                    |     Fotógrafo        |
                    +----------------------+
                           |
      --------------------------------------------------------
      |            |             |            |               |
      ▼            ▼             ▼            ▼               ▼
Cadastrar     Editar Perfil   Criar      Publicar        Responder
 Perfil                      Portfólio    Fotos          Mensagens


                 +---------------------------+
                 |      Administrador        |
                 +---------------------------+
                           |
      ----------------------------------------------------------
      |             |             |             |               |
      ▼             ▼             ▼             ▼               ▼
Gerenciar      Aprovar      Bloquear      Relatórios      Moderar
 Usuários      Cadastros    Usuários
```

---

# Diagrama de Atividades

```
Início

↓

Login

↓

Selecionar Perfil

↓

Pesquisar Fotógrafo

↓

Visualizar Perfil

↓

Visualizar Portfólio

↓

Entrar em Contato

↓

Fim
```

---

# Diagrama de Sequência

```
Cliente

↓

Tela

↓

Controller

↓

Service

↓

Model

↓

Banco de Dados

↓

Resposta

↓

Tela
```

---

# Manual do Usuário

## Cadastro

1. Clique em **Cadastrar**.
2. Informe seus dados.
3. Escolha o tipo de conta.
4. Finalize o cadastro.
5. Faça login.

---

## Login

1. Informe e-mail.
2. Digite a senha.
3. Clique em **Entrar**.

---

## Pesquisa

Após o login:

- pesquisar fotógrafos;
- selecionar cidade;
- escolher especialidade;
- visualizar resultados.

---

## Perfil do Fotógrafo

Cada perfil apresentará:

- Foto
- Nome
- Cidade
- Biografia
- Especialidades
- Portfólio
- Contato

---

## Envio de Mensagens

1. Abrir perfil.
2. Clicar em **Mensagem**.
3. Escrever texto.
4. Enviar.

---

# Manual do Fotógrafo

Após o primeiro acesso recomenda-se:

- completar o perfil;
- adicionar fotografia principal;
- cadastrar especialidades;
- informar localização;
- criar o primeiro portfólio.

---

## Publicação de Fotografias

Fluxo:

```
Painel

↓

Portfólio

↓

Adicionar Fotos

↓

Selecionar Arquivos

↓

Salvar
```

---

# Manual do Administrador

O painel administrativo permitirá:

- Gerenciar usuários
- Gerenciar fotógrafos
- Gerenciar clientes
- Visualizar estatísticas
- Emitir relatórios
- Moderar conteúdo

---

# Indicadores Administrativos

O sistema poderá apresentar:

## Usuários

- Total cadastrados
- Usuários ativos
- Novos cadastros

---

## Fotógrafos

- Total de fotógrafos
- Portfólios ativos
- Fotografias publicadas

---

## Clientes

- Clientes ativos
- Pesquisas realizadas
- Mensagens enviadas

---

## Plataforma

- Acessos diários
- Tempo médio de uso
- Crescimento mensal

---

# Plano de Manutenção

## Preventiva

- Atualização do servidor
- Backup
- Limpeza de arquivos
- Verificação dos logs

---

## Corretiva

- Correção de bugs
- Ajustes de desempenho
- Correção de vulnerabilidades

---

## Evolutiva

- Novos módulos
- Melhorias na interface
- Novas integrações

---

# Plano de Backup

Recomendação

## Diário

Banco de Dados

## Semanal

Banco + Uploads

## Mensal

Backup completo da aplicação


# FAQ

## Como criar uma conta?

Acesse **Cadastrar**, preencha o formulário e confirme o cadastro.

---

## Como localizar fotógrafos?

Utilize a pesquisa aplicando filtros por cidade e especialidade.

---

## Posso alterar meus dados?

Sim. Pelo menu **Meu Perfil**.

---

## Posso excluir minha conta?

Sim. A exclusão poderá ser solicitada no painel do usuário.

---

## Quem pode publicar fotografias?

Somente usuários cadastrados como fotógrafos.

---

# Glossário

| Termo | Significado |
|--------|-------------|
| Cliente | Usuário que procura serviços fotográficos |
| Fotógrafo | Profissional cadastrado na plataforma |
| Portfólio | Coleção de trabalhos do fotógrafo |
| Dashboard | Painel principal do sistema |
| Upload | Envio de arquivos |
| CRUD | Criar, Consultar, Atualizar e Excluir registros |
| SaaS | Software disponibilizado como serviço |
| Micro SaaS | Software especializado em um nicho específico |

---

# Referências

- HTML5
- CSS3
- JavaScript
- PHP
- MySQL
- Git
- GitHub

---

# Licença

Este projeto foi desenvolvido para fins acadêmicos no Curso Técnico Integrado em Informática.

Seu uso para fins educacionais é permitido, respeitando os créditos dos autores e da instituição de ensino.

---

# Equipe do Projeto

## Desenvolvedoras

- Lavínia Coimbra Correa
- Natasha Brasil Abreu

---

# Histórico de Versões

| Versão | Data | Descrição |
|---------|------|-----------|
| 1.0 | 2026 | Documento inicial |
---

# 13. API REST

## 13.1 Introdução

A API REST do **Carpe Diem** foi desenvolvida para atuar como camada intermediária entre o banco de dados e a interface da aplicação, disponibilizando serviços responsáveis pelo gerenciamento das informações da plataforma de fotografia.

Sua implementação segue os princípios da arquitetura **REST (Representational State Transfer)**, utilizando requisições HTTP e comunicação baseada no formato **JSON**, garantindo interoperabilidade entre diferentes clientes consumidores da API.

Além disso, a aplicação adota o padrão arquitetural **MVC (Model-View-Controller)**, proporcionando separação das responsabilidades entre as camadas de apresentação, regras de negócio e persistência de dados, favorecendo a organização, manutenção e escalabilidade do sistema.

Entre os principais recursos disponibilizados pela API estão:

- Cadastro e autenticação de usuários;
- Gerenciamento de fotógrafos;
- Gerenciamento de portfólios;
- Gerenciamento de fotografias;
- Gerenciamento de avaliações;
- Envio e recebimento de mensagens;
- Gerenciamento de contatos;
- Gerenciamento de especialidades;
- Administração das perguntas frequentes (FAQ);
- Controle de autenticação utilizando JSON Web Token (JWT).

Toda a comunicação entre cliente e servidor é realizada através de requisições HTTP e respostas em formato JSON, seguindo um padrão padronizado de retorno para facilitar a integração entre a API e o front-end da aplicação.

---

# 13.2 Arquitetura da API

A arquitetura da API foi projetada utilizando uma abordagem em camadas, permitindo que cada componente possua responsabilidades bem definidas.

O fluxo de processamento de uma requisição ocorre conforme ilustrado abaixo.

```text
                     Cliente (Front-end)

                              │
                     Requisição HTTP
                              │
                              ▼
                   CoffeeCode Router
                              │
                              ▼
                       Controller
                              │
                 Validação da Requisição
                              │
                              ▼
                           Model
                              │
                    Consulta ao Banco
                              │
                              ▼
                      Banco de Dados
                              │
                     Retorno dos Dados
                              │
                              ▼
                           Model
                              │
                              ▼
                       Controller
                              │
                 Conversão para JSON
                              │
                              ▼
                   Resposta ao Cliente
```

Cada camada possui responsabilidades específicas, tornando o projeto modular e de fácil manutenção.

---

## Componentes da Arquitetura

| Camada | Responsabilidade |
|---------|------------------|
| Cliente | Consome os serviços disponibilizados pela API. |
| Router | Recebe as requisições HTTP e direciona para o Controller correspondente. |
| Controller | Processa a requisição, valida os dados recebidos e executa as regras de negócio. |
| Model | Responsável pela comunicação com o banco de dados. |
| Banco de Dados | Armazena todas as informações persistentes da aplicação. |

Essa divisão reduz o acoplamento entre os componentes, facilitando futuras implementações.

---

# 13.3 Arquitetura MVC

O projeto foi desenvolvido utilizando o padrão arquitetural **Model-View-Controller (MVC)**.

Esse padrão organiza a aplicação em três camadas principais, permitindo que cada uma possua responsabilidades específicas.

```text
                 +---------------------+
                 |       Cliente       |
                 +----------+----------+
                            |
                            ▼
                 +---------------------+
                 |     Controller      |
                 +----------+----------+
                            |
            +---------------+---------------+
            |                               |
            ▼                               ▼
     Validação                    Regras de Negócio
            |                               |
            +---------------+---------------+
                            |
                            ▼
                 +---------------------+
                 |       Model         |
                 +----------+----------+
                            |
                            ▼
                 +---------------------+
                 |   Banco de Dados    |
                 +---------------------+
```

A utilização desse padrão proporciona diversas vantagens para o desenvolvimento da aplicação:

- Separação das responsabilidades;
- Melhor organização do código;
- Maior facilidade para manutenção;
- Reutilização de componentes;
- Escalabilidade da aplicação;
- Facilidade para testes e futuras implementações.

---

## Estrutura do Projeto

A API encontra-se organizada conforme a estrutura abaixo.

```text
api/

├── composer.json
├── composer.lock
├── index.php
├── vendor/
│
└── source/
    ├── Config/
    ├── Controllers/
    ├── Models/
    ├── Core/
    ├── Routes/
    ├── Helpers/
    └── Database/
```

### Descrição dos Diretórios

| Diretório | Função |
|------------|--------|
| Config | Arquivos de configuração da aplicação, banco de dados e autenticação JWT. |
| Controllers | Controladores responsáveis por receber as requisições HTTP. |
| Models | Classes responsáveis pela manipulação dos dados da aplicação. |
| Core | Componentes internos utilizados pela infraestrutura da API. |
| Routes | Arquivos responsáveis pelo registro das rotas disponíveis. |
| Helpers | Classes auxiliares utilizadas em diferentes módulos da aplicação. |
| Database | Componentes relacionados à persistência dos dados. |

---

# 13.4 Fluxo Geral da API

Todas as operações realizadas pelo sistema seguem um fluxo semelhante.

```text
Cliente

      │

      ▼

Requisição HTTP

      │

      ▼

CoffeeCode Router

      │

      ▼

Controller

      │

      ▼

Validação dos Dados

      │

      ▼

Model

      │

      ▼

Banco de Dados

      │

      ▼

Model

      │

      ▼

Controller

      │

      ▼

Resposta JSON

      │

      ▼

Cliente
```

Esse fluxo garante que todas as requisições sejam processadas de maneira padronizada, permitindo maior segurança, organização e facilidade de manutenção.

---

## Benefícios da Arquitetura

A arquitetura adotada durante o desenvolvimento da API proporciona diversos benefícios para o projeto, dentre eles:

- Organização do código em módulos independentes;
- Separação entre regras de negócio e acesso aos dados;
- Facilidade de manutenção;
- Escalabilidade da aplicação;
- Padronização das respostas da API;
- Facilidade de integração com aplicações web e dispositivos móveis;
- Reutilização dos componentes da aplicação;
- Melhor controle de autenticação e autorização dos usuários.

Essa estrutura torna a API preparada para futuras expansões, permitindo a implementação de novos recursos sem comprometer os módulos já existentes.
# 13.5 Organização das Rotas

A API do **Carpe Diem** disponibiliza seus recursos através de endpoints REST organizados por entidades.

Cada recurso possui um conjunto de rotas responsáveis pelas operações de consulta, cadastro, atualização e exclusão de registros.

A organização das rotas segue uma estrutura padronizada, facilitando a manutenção da aplicação e o consumo da API por aplicações clientes.

---

## Recursos Disponíveis

| Recurso | Endpoint Base | Descrição |
|----------|---------------|-----------|
| Users | `/users` | Gerenciamento de usuários da plataforma. |
| Portfolios | `/portfolios` | Gerenciamento dos portfólios dos fotógrafos. |
| Photos | `/photos` | Gerenciamento das fotografias pertencentes aos portfólios. |
| Reviews | `/reviews` | Avaliações realizadas pelos clientes. |
| Messages | `/messages` | Comunicação entre usuários da plataforma. |
| Contacts | `/contacts` | Mensagens enviadas pelo formulário de contato. |
| Specialties | `/specialties` | Especialidades dos fotógrafos. |
| FAQs | `/faqs` | Perguntas frequentes da plataforma. |
| FAQ Categories | `/faqscategories` | Categorias das perguntas frequentes. |

---

## Estrutura Geral das Rotas

A maior parte dos recursos disponibilizados pela API segue o padrão REST apresentado abaixo.

| Método HTTP | Endpoint | Operação |
|--------------|----------|----------|
| GET | `/recurso` | Listar registros |
| GET | `/recurso/{id}` | Buscar um registro específico |
| POST | `/recurso` | Criar um novo registro |
| PUT | `/recurso/{id}` | Atualizar um registro existente |
| DELETE | `/recurso/{id}` | Remover um registro |

Esse padrão proporciona maior organização e padronização na comunicação entre cliente e servidor.

---

# 13.6 Métodos HTTP

A API utiliza os principais métodos definidos pelo protocolo HTTP para representar as operações realizadas sobre cada recurso.

## GET

Responsável pela recuperação de informações armazenadas no banco de dados.

Exemplos:

```http
GET /users

GET /photos

GET /reviews/3
```

---

## POST

Responsável pela criação de novos registros.

Exemplo:

```http
POST /users/register
```

```http
POST /contacts
```

---

## PUT

Responsável pela atualização de registros previamente cadastrados.

Exemplo:

```http
PUT /users/5
```

---

## DELETE

Responsável pela remoção lógica dos registros da aplicação.

Exemplo:

```http
DELETE /photos/12
```

---

## Resumo dos Métodos

| Método | Finalidade |
|----------|------------|
| GET | Consultar informações |
| POST | Inserir novos registros |
| PUT | Atualizar registros existentes |
| DELETE | Remover registros |

---

# 13.7 Autenticação

A API utiliza autenticação baseada em **JSON Web Token (JWT)** para proteger os recursos privados da aplicação.

Após realizar o login com sucesso, o servidor gera um token contendo as informações necessárias para identificar o usuário autenticado.

Esse token deverá acompanhar todas as requisições destinadas aos endpoints protegidos.

---

## Fluxo da Autenticação

```text
Usuário

      │

      ▼

POST /users/login

      │

      ▼

Validação das Credenciais

      │

      ▼

JWT Gerado

      │

      ▼

Cliente Armazena o Token

      │

      ▼

Demais Requisições

      │

      ▼

Authorization: Bearer TOKEN
```

---

## Envio do Token

O token deve ser enviado através do cabeçalho HTTP.

```http
Authorization: Bearer eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9...
```

ou

```http
token: eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9...
```

---

## Informações contidas no Token

O JWT armazena informações que permitem identificar o usuário autenticado durante as requisições.

Entre elas:

- Identificador do usuário;
- Data de emissão;
- Data de expiração;
- Assinatura criptográfica.

---

## Vantagens da utilização do JWT

A utilização do JSON Web Token oferece diversos benefícios para a aplicação.

- Autenticação Stateless;
- Maior segurança;
- Facilidade de integração;
- Escalabilidade;
- Controle de sessões;
- Redução de consultas desnecessárias ao banco de dados.

---

## Rotas Públicas

As rotas públicas podem ser acessadas sem autenticação.

Exemplos:

- Login;
- Cadastro de usuários;
- Formulário de contato;
- Consulta de FAQs.

---

## Rotas Protegidas

As demais operações exigem um token JWT válido.

Exemplos:

- Atualização de usuários;
- Cadastro de portfólios;
- Cadastro de fotografias;
- Avaliações;
- Mensagens;
- Especialidades.

Caso o token esteja ausente, expirado ou inválido, a API retornará um erro de autenticação.

---

# 13.8 Padrão das Respostas

Todas as respostas retornadas pela API seguem um formato JSON padronizado.

Essa padronização facilita o desenvolvimento do front-end e torna o consumo da API mais consistente.

---

## Estrutura Geral

```json
{
    "code":200,
    "type":"success",
    "status":"success",
    "message":"Operação realizada com sucesso.",
    "data":{}
}
```

---

## Campos da Resposta

| Campo | Descrição |
|--------|-----------|
| code | Código HTTP da resposta |
| type | Tipo da resposta (`success` ou `error`) |
| status | Identificador textual da resposta |
| message | Mensagem descritiva da operação |
| data | Dados retornados pela operação |

---

## Exemplo de Resposta de Sucesso

```json
{
    "code":200,
    "type":"success",
    "status":"success",
    "message":"Usuário encontrado.",
    "data":{
        "id":3,
        "name":"João Silva",
        "email":"joao@email.com"
    }
}
```

---

## Exemplo de Erro

```json
{
    "code":401,
    "type":"error",
    "status":"unauthorized",
    "message":"Usuário não autenticado."
}
```

---

## Benefícios da Padronização

A utilização de respostas padronizadas proporciona diversas vantagens ao sistema.

- Facilita a integração entre API e Front-end;
- Simplifica o tratamento de erros;
- Melhora a manutenção da aplicação;
- Reduz inconsistências nas respostas;
- Permite maior reutilização de componentes.

---

## Organização dos Endpoints

Os próximos capítulos apresentam detalhadamente cada recurso disponibilizado pela API.

Cada entidade contém:

- descrição do recurso;
- estrutura dos dados;
- endpoints disponíveis;
- exemplos de requisição;
- exemplos de resposta;
- observações técnicas quando necessário.

A documentação foi organizada seguindo o padrão REST adotado durante o desenvolvimento da aplicação.
# 13.9 Endpoints da API

Este capítulo apresenta todos os recursos disponibilizados pela API do **Carpe Diem**.

Cada endpoint foi documentado contendo:

- objetivo da operação;
- método HTTP utilizado;
- URL da requisição;
- parâmetros;
- corpo da requisição (Body);
- exemplo de resposta;
- observações importantes.

---

# 13.9.1 Usuários

A entidade **Users** é responsável pelo gerenciamento das contas cadastradas na plataforma.

Ela controla os processos de autenticação, cadastro e atualização dos dados dos usuários, permitindo posteriormente o acesso aos demais recursos do sistema.

---

## Estrutura da Entidade

| Campo | Tipo | Descrição |
|--------|------|-----------|
| id | Integer | Identificador do usuário |
| name | String | Nome completo |
| email | String | Endereço de e-mail |
| password | String | Senha criptografada |
| photo | String | Foto de perfil |
| created_at | DateTime | Data de criação |
| updated_at | DateTime | Última atualização |

---

# POST `/users/register`

## Objetivo

Realizar o cadastro de um novo usuário na plataforma.

**Autenticação:** Não requerida.

---

### Body

```json
{
    "name":"João Silva",
    "email":"joao@email.com",
    "password":"123456"
}
```

---

### Resposta

```json
{
    "code":201,
    "type":"success",
    "status":"success",
    "message":"Usuário cadastrado com sucesso.",
    "data":{
        "id":1,
        "name":"João Silva",
        "email":"joao@email.com"
    }
}
```

---

# POST `/users/login`

## Objetivo

Realizar a autenticação do usuário.

Após validação das credenciais, um token JWT é gerado para utilização nas próximas requisições protegidas.

**Autenticação:** Não requerida.

---

### Body

```json
{
    "email":"joao@email.com",
    "password":"123456"
}
```

---

### Resposta

```json
{
    "code":200,
    "type":"success",
    "status":"success",
    "message":"Login realizado com sucesso.",
    "data":{
        "id":1,
        "name":"João Silva",
        "token":"eyJhbGciOi..."
    }
}
```

---

# GET `/users`

## Objetivo

Retornar todos os usuários cadastrados.

**Autenticação:** Obrigatória.

---

### Resposta

```json
{
    "code":200,
    "type":"success",
    "status":"success",
    "data":[
        {
            "id":1,
            "name":"João Silva"
        },
        {
            "id":2,
            "name":"Maria Oliveira"
        }
    ]
}
```

---

# GET `/users/{id}`

## Objetivo

Retornar um usuário específico.

### Parâmetro

| Nome | Tipo | Descrição |
|------|------|-----------|
| id | Integer | Identificador do usuário |

---

### Resposta

```json
{
    "code":200,
    "type":"success",
    "status":"success",
    "data":{
        "id":1,
        "name":"João Silva",
        "email":"joao@email.com"
    }
}
```

---

# PUT `/users/{id}`

## Objetivo

Atualizar os dados de um usuário.

**Autenticação:** Obrigatória.

---

### Body

```json
{
    "name":"João Silva",
    "email":"novo@email.com"
}
```

---

### Resposta

```json
{
    "code":200,
    "status":"success",
    "message":"Usuário atualizado com sucesso."
}
```

---

# DELETE `/users/{id}`

## Objetivo

Realizar a exclusão lógica do usuário.

---

### Resposta

```json
{
    "code":200,
    "status":"success",
    "message":"Usuário removido com sucesso."
}
```

---

# 13.9.2 Portfólios

A entidade **Portfolios** representa os trabalhos publicados pelos fotógrafos.

Cada fotógrafo poderá possuir um ou mais portfólios, contendo fotografias organizadas por categoria ou estilo fotográfico.

---

## Estrutura da Entidade

| Campo | Tipo | Descrição |
|--------|------|-----------|
| id | Integer |
| users_id | Integer |
| title | String |
| description | Text |
| cover | String |
| active | Boolean |

---

# POST `/portfolios`

## Objetivo

Cadastrar um novo portfólio.

**Autenticação:** Obrigatória.

---

### Body

```json
{
    "title":"Casamentos",
    "description":"Portfólio de eventos matrimoniais."
}
```

---

### Resposta

```json
{
    "code":201,
    "status":"success",
    "message":"Portfólio cadastrado com sucesso."
}
```

---

# GET `/portfolios`

## Objetivo

Listar todos os portfólios cadastrados.

---

### Resposta

```json
{
    "code":200,
    "status":"success",
    "data":[]
}
```

---

# GET `/portfolios/{id}`

Retorna um portfólio específico.

---

# PUT `/portfolios/{id}`

Atualiza um portfólio existente.

---

# DELETE `/portfolios/{id}`

Realiza a exclusão lógica do portfólio.

---

## Observações

- Cada portfólio pertence a um fotógrafo.
- Um fotógrafo pode possuir vários portfólios.
- Um portfólio pode conter diversas fotografias.

---

## Observação Geral

Todos os erros retornados pelos endpoints apresentados nesta seção seguem o padrão definido no capítulo **13.11 – Tratamento de Erros**.
# 13.9.3 Fotografias

A entidade **Photos** é responsável pelo gerenciamento das fotografias que compõem os portfólios dos fotógrafos cadastrados na plataforma.

Cada fotografia está obrigatoriamente vinculada a um portfólio e representa um dos trabalhos publicados pelo profissional.

As imagens cadastradas são utilizadas para apresentar o estilo fotográfico, qualidade do trabalho e áreas de atuação de cada fotógrafo.

---

## Estrutura da Entidade

| Campo | Tipo | Descrição |
|--------|------|-----------|
| id | Integer | Identificador da fotografia |
| portfolio_id | Integer | Identificador do portfólio |
| title | String | Título da fotografia |
| description | Text | Descrição da fotografia |
| image | String | Caminho da imagem |
| created_at | DateTime | Data de cadastro |
| updated_at | DateTime | Última atualização |
| active | Boolean | Situação do registro |

---

# POST `/photos`

## Objetivo

Cadastrar uma nova fotografia em um portfólio.

**Autenticação:** Obrigatória.

---

### Body

```json
{
    "portfolio_id":3,
    "title":"Ensaio Pré-Wedding",
    "description":"Fotografia realizada durante ensaio externo.",
    "image":"prewedding.jpg"
}
```

---

### Resposta

```json
{
    "code":201,
    "type":"success",
    "status":"success",
    "message":"Fotografia cadastrada com sucesso.",
    "data":{
        "id":12,
        "portfolio_id":3
    }
}
```

---

# GET `/photos`

## Objetivo

Retornar todas as fotografias cadastradas.

---

### Resposta

```json
{
    "code":200,
    "type":"success",
    "status":"success",
    "data":[]
}
```

---

# GET `/photos/{id}`

## Objetivo

Retornar uma fotografia específica.

### Parâmetro

| Nome | Tipo | Descrição |
|------|------|-----------|
| id | Integer | Identificador da fotografia |

---

### Resposta

```json
{
    "code":200,
    "status":"success",
    "data":{
        "id":12,
        "title":"Ensaio Pré-Wedding",
        "description":"Fotografia realizada durante ensaio externo."
    }
}
```

---

# PUT `/photos/{id}`

## Objetivo

Atualizar as informações de uma fotografia.

**Autenticação:** Obrigatória.

---

### Body

```json
{
    "title":"Novo título",
    "description":"Nova descrição."
}
```

---

### Resposta

```json
{
    "code":200,
    "status":"success",
    "message":"Fotografia atualizada com sucesso."
}
```

---

# DELETE `/photos/{id}`

## Objetivo

Realizar a exclusão lógica da fotografia.

**Autenticação:** Obrigatória.

---

### Resposta

```json
{
    "code":200,
    "status":"success",
    "message":"Fotografia removida com sucesso."
}
```

---

## Relacionamentos

A entidade **Photos** possui relacionamento direto com **Portfolios**, sendo que:

- Uma fotografia pertence a um único portfólio.
- Um portfólio pode conter diversas fotografias.
- A exclusão de um portfólio impacta diretamente suas fotografias associadas.

---

# 13.9.4 Especialidades

A entidade **Specialties** é responsável pelo gerenciamento das especialidades dos fotógrafos cadastrados na plataforma.

As especialidades permitem categorizar os profissionais conforme sua área de atuação, facilitando a busca por parte dos clientes.

Entre os exemplos de especialidades encontram-se:

- Casamentos;
- Ensaios;
- Gestantes;
- Formaturas;
- Eventos;
- Infantil;
- Corporativo;
- Gastronomia;
- Arquitetura;
- Produtos.

---

## Estrutura da Entidade

| Campo | Tipo | Descrição |
|--------|------|-----------|
| id | Integer | Identificador da especialidade |
| name | String | Nome da especialidade |
| description | Text | Descrição |
| active | Boolean | Situação do registro |

---

# POST `/specialties`

## Objetivo

Cadastrar uma nova especialidade.

**Autenticação:** Obrigatória.

---

### Body

```json
{
    "name":"Casamentos",
    "description":"Fotografia especializada em cerimônias matrimoniais."
}
```

---

### Resposta

```json
{
    "code":201,
    "type":"success",
    "status":"success",
    "message":"Especialidade cadastrada com sucesso."
}
```

---

# GET `/specialties`

## Objetivo

Retornar todas as especialidades cadastradas.

---

### Resposta

```json
{
    "code":200,
    "status":"success",
    "data":[]
}
```

---

# GET `/specialties/{id}`

## Objetivo

Retornar uma especialidade específica.

### Parâmetro

| Nome | Tipo | Descrição |
|------|------|-----------|
| id | Integer | Identificador da especialidade |

---

### Resposta

```json
{
    "code":200,
    "status":"success",
    "data":{
        "id":2,
        "name":"Casamentos",
        "description":"Fotografia para cerimônias e eventos matrimoniais."
    }
}
```

---

# PUT `/specialties/{id}`

## Objetivo

Atualizar uma especialidade.

**Autenticação:** Obrigatória.

---

### Body

```json
{
    "name":"Eventos",
    "description":"Cobertura fotográfica de eventos."
}
```

---

### Resposta

```json
{
    "code":200,
    "status":"success",
    "message":"Especialidade atualizada com sucesso."
}
```

---

# DELETE `/specialties/{id}`

## Objetivo

Realizar a exclusão lógica da especialidade.

---

### Resposta

```json
{
    "code":200,
    "status":"success",
    "message":"Especialidade removida com sucesso."
}
```

---

## Aplicação das Especialidades

As especialidades cadastradas são utilizadas para:

- Classificar fotógrafos conforme sua área de atuação;
- Facilitar pesquisas realizadas pelos clientes;
- Organizar os serviços oferecidos na plataforma;
- Melhorar a experiência de navegação e filtragem dos profissionais.

---

## Observação Geral

Todos os endpoints apresentados nesta seção seguem o padrão REST adotado pela API do **Carpe Diem**.

As respostas de erro relacionadas a esses recursos encontram-se documentadas na seção **13.11 – Tratamento de Erros**, evitando repetições ao longo da documentação.
# 13.9.5 Avaliações

A entidade **Reviews** é responsável pelo gerenciamento das avaliações realizadas pelos clientes após a contratação de um fotógrafo.

As avaliações permitem registrar a satisfação do cliente em relação ao atendimento, qualidade do serviço prestado e experiência geral durante a execução do trabalho fotográfico.

Além de contribuir para a credibilidade dos profissionais cadastrados, as avaliações auxiliam futuros clientes na tomada de decisão durante a contratação de um fotógrafo.

---

## Estrutura da Entidade

| Campo | Tipo | Descrição |
|--------|------|-----------|
| id | Integer | Identificador da avaliação |
| users_id | Integer | Usuário responsável pela avaliação |
| photographer_id | Integer | Fotógrafo avaliado |
| rating | Integer | Nota atribuída ao fotógrafo |
| comment | Text | Comentário da avaliação |
| created_at | DateTime | Data da avaliação |
| active | Boolean | Situação do registro |

---

# POST `/reviews`

## Objetivo

Cadastrar uma nova avaliação.

**Autenticação:** Obrigatória.

---

### Body

```json
{
    "photographer_id":5,
    "rating":5,
    "comment":"Excelente atendimento e ótima qualidade nas fotografias."
}
```

---

### Resposta

```json
{
    "code":201,
    "type":"success",
    "status":"success",
    "message":"Avaliação cadastrada com sucesso."
}
```

---

# GET `/reviews`

## Objetivo

Listar todas as avaliações cadastradas.

---

### Resposta

```json
{
    "code":200,
    "status":"success",
    "data":[]
}
```

---

# GET `/reviews/{id}`

## Objetivo

Consultar uma avaliação específica.

---

# PUT `/reviews/{id}`

## Objetivo

Atualizar uma avaliação.

---

# DELETE `/reviews/{id}`

## Objetivo

Realizar a exclusão lógica de uma avaliação.

---

## Aplicação

As avaliações são utilizadas para:

- medir a satisfação dos clientes;
- fortalecer a reputação dos fotógrafos;
- apresentar feedbacks públicos;
- auxiliar novos clientes durante a contratação.

---

# 13.9.6 Mensagens

A entidade **Messages** gerencia toda a comunicação realizada entre os usuários cadastrados na plataforma.

Esse recurso permite que clientes e fotógrafos mantenham contato antes, durante e após a contratação dos serviços.

As mensagens podem ser utilizadas para negociação, solicitação de orçamentos, esclarecimento de dúvidas e troca de informações referentes aos serviços fotográficos.

---

## Estrutura da Entidade

| Campo | Tipo | Descrição |
|--------|------|-----------|
| id | Integer | Identificador da mensagem |
| sender_id | Integer | Usuário remetente |
| receiver_id | Integer | Usuário destinatário |
| subject | String | Assunto da mensagem |
| message | Text | Conteúdo |
| created_at | DateTime | Data de envio |
| active | Boolean | Situação do registro |

---

# POST `/messages`

## Objetivo

Enviar uma mensagem para outro usuário.

**Autenticação:** Obrigatória.

---

### Body

```json
{
    "receiver_id":4,
    "subject":"Solicitação de orçamento",
    "message":"Gostaria de receber um orçamento para um ensaio fotográfico."
}
```

---

### Resposta

```json
{
    "code":201,
    "status":"success",
    "message":"Mensagem enviada com sucesso."
}
```

---

# GET `/messages`

## Objetivo

Retornar todas as mensagens do usuário autenticado.

---

### Resposta

```json
{
    "code":200,
    "status":"success",
    "data":[]
}
```

---

# GET `/messages/{id}`

## Objetivo

Consultar uma mensagem específica.

---

# PUT `/messages/{id}`

## Objetivo

Atualizar uma mensagem existente.

---

# DELETE `/messages/{id}`

## Objetivo

Realizar a exclusão lógica da mensagem.

---

## Fluxo de Comunicação

```text
Cliente

      │

      ▼

Mensagem

      │

      ▼

API

      │

      ▼

Banco de Dados

      │

      ▼

Fotógrafo
```

Esse fluxo garante o armazenamento seguro das mensagens trocadas entre os usuários da plataforma.

---

# 13.9.7 Contatos

A entidade **Contacts** é responsável pelo gerenciamento das mensagens enviadas através do formulário **Entre em Contato**, disponível na página institucional da plataforma.

Esse recurso permite que visitantes, clientes ou fotógrafos encaminhem dúvidas, sugestões, solicitações de suporte ou demais informações diretamente aos administradores do sistema.

---

## Estrutura da Entidade

| Campo | Tipo | Descrição |
|--------|------|-----------|
| id | Integer | Identificador |
| name | String | Nome do remetente |
| email | String | E-mail |
| subject | String | Assunto |
| message | Text | Conteúdo da mensagem |
| created_at | DateTime | Data de envio |
| active | Boolean | Situação do registro |

---

# POST `/contacts`

## Objetivo

Enviar uma mensagem através do formulário de contato.

**Autenticação:** Não obrigatória.

---

### Body

```json
{
    "name":"Maria Oliveira",
    "email":"maria@email.com",
    "subject":"Informações",
    "message":"Gostaria de obter mais informações sobre os serviços oferecidos."
}
```

---

### Resposta

```json
{
    "code":201,
    "status":"success",
    "message":"Mensagem enviada com sucesso."
}
```

---

# GET `/contacts`

## Objetivo

Listar todas as mensagens recebidas pelo formulário de contato.

---

# GET `/contacts/{id}`

## Objetivo

Consultar uma mensagem específica.

---

# PUT `/contacts/{id}`

## Objetivo

Atualizar uma mensagem cadastrada.

---

# DELETE `/contacts/{id}`

## Objetivo

Realizar a exclusão lógica da mensagem de contato.

---

## Aplicação

O módulo de contatos é utilizado para:

- atendimento ao usuário;
- suporte técnico;
- recebimento de sugestões;
- esclarecimento de dúvidas;
- comunicação institucional.

---

## Relacionamento entre as Entidades

As entidades apresentadas neste capítulo mantêm relacionamento com os usuários cadastrados na plataforma.

```text
                    Users
                       │
        ┌──────────────┼──────────────┐
        │              │              │
        ▼              ▼              ▼
    Reviews       Messages      Contacts
```

Enquanto **Reviews** registram a experiência dos clientes, **Messages** permitem a comunicação direta entre usuários e **Contacts** concentram as mensagens institucionais enviadas através do site.

---

## Observação Geral

Todos os endpoints apresentados nesta seção seguem o padrão REST definido para a API do **Carpe Diem**.

As possíveis respostas de erro encontram-se documentadas no capítulo **13.11 – Tratamento de Erros**, evitando repetições ao longo da documentação.
# 13.9.8 Perguntas Frequentes (FAQs)

A entidade **FAQs (Frequently Asked Questions)** é responsável pelo gerenciamento das perguntas frequentes disponibilizadas aos usuários da plataforma.

Seu principal objetivo é centralizar as dúvidas mais recorrentes sobre o funcionamento do sistema, contratação de fotógrafos, utilização da plataforma e demais funcionalidades disponíveis, reduzindo a necessidade de atendimento manual.

Cada pergunta pertence a uma categoria específica, permitindo uma melhor organização das informações.

---

## Estrutura da Entidade

| Campo | Tipo | Descrição |
|--------|------|-----------|
| id | Integer | Identificador da FAQ |
| category_id | Integer | Categoria à qual a pergunta pertence |
| question | String | Pergunta cadastrada |
| answer | Text | Resposta da pergunta |
| created_at | DateTime | Data de cadastro |
| updated_at | DateTime | Última atualização |
| active | Boolean | Situação do registro |

---

# POST `/faqs`

## Objetivo

Cadastrar uma nova pergunta frequente.

**Autenticação:** Obrigatória.

---

### Body

```json
{
    "category_id":1,
    "question":"Como contratar um fotógrafo?",
    "answer":"Acesse o perfil do fotógrafo desejado e envie uma solicitação através da plataforma."
}
```

---

### Resposta

```json
{
    "code":201,
    "type":"success",
    "status":"success",
    "message":"Pergunta cadastrada com sucesso."
}
```

---

# GET `/faqs`

## Objetivo

Retornar todas as perguntas cadastradas.

---

### Resposta

```json
{
    "code":200,
    "status":"success",
    "data":[]
}
```

---

# GET `/faqs/{id}`

## Objetivo

Consultar uma pergunta específica.

---

# PUT `/faqs/{id}`

## Objetivo

Atualizar uma pergunta cadastrada.

---

# DELETE `/faqs/{id}`

## Objetivo

Realizar a exclusão lógica da pergunta.

---

## Aplicação

As FAQs são utilizadas para:

- esclarecer dúvidas frequentes;
- reduzir solicitações de suporte;
- orientar novos usuários;
- melhorar a experiência de utilização da plataforma.

---

# 13.9.9 Categorias das FAQs

As categorias das FAQs são responsáveis por organizar as perguntas frequentes em grupos temáticos.

Essa organização facilita a localização das informações pelos usuários e melhora significativamente a navegação dentro da seção de ajuda da plataforma.

---

## Estrutura da Entidade

| Campo | Tipo | Descrição |
|--------|------|-----------|
| id | Integer | Identificador da categoria |
| name | String | Nome da categoria |
| description | Text | Descrição da categoria |
| active | Boolean | Situação do registro |

---

# POST `/faqscategories`

## Objetivo

Cadastrar uma nova categoria.

**Autenticação:** Obrigatória.

---

### Body

```json
{
    "name":"Contratação",
    "description":"Perguntas relacionadas ao processo de contratação dos fotógrafos."
}
```

---

### Resposta

```json
{
    "code":201,
    "status":"success",
    "message":"Categoria cadastrada com sucesso."
}
```

---

# GET `/faqscategories`

## Objetivo

Retornar todas as categorias cadastradas.

---

### Resposta

```json
{
    "code":200,
    "status":"success",
    "data":[]
}
```

---

# GET `/faqscategories/{id}`

## Objetivo

Consultar uma categoria específica.

---

# PUT `/faqscategories/{id}`

## Objetivo

Atualizar uma categoria existente.

---

# DELETE `/faqscategories/{id}`

## Objetivo

Realizar a exclusão lógica da categoria.

---

## Categorias sugeridas

As categorias podem ser utilizadas para organizar perguntas relacionadas a diferentes áreas da plataforma.

Exemplos:

- Cadastro;
- Login;
- Contratação;
- Portfólios;
- Fotógrafos;
- Pagamentos;
- Ensaios;
- Eventos;
- Suporte.

---

# Organização Geral dos Recursos

A API do **Carpe Diem** encontra-se organizada em nove recursos principais.

| Recurso | Finalidade |
|----------|------------|
| Users | Gerenciamento de usuários. |
| Portfolios | Gerenciamento dos portfólios dos fotógrafos. |
| Photos | Gerenciamento das fotografias. |
| Reviews | Avaliações realizadas pelos clientes. |
| Messages | Comunicação entre usuários. |
| Contacts | Mensagens enviadas pelo formulário de contato. |
| Specialties | Especialidades dos fotógrafos. |
| FAQs | Perguntas frequentes. |
| FAQ Categories | Organização das FAQs em categorias. |

---

## Integração entre os Recursos

Os módulos da aplicação trabalham de maneira integrada, compartilhando informações para oferecer uma experiência completa aos usuários da plataforma.

```text
                         Users
                            │
       ┌────────────────────┼────────────────────┐
       │                    │                    │
       ▼                    ▼                    ▼
 Portfolios             Reviews            Messages
       │
       ▼
    Photos

       │

       ▼

 Specialties


 FAQ Categories
        │
        ▼
      FAQs


 Contacts
```

Essa estrutura garante que as informações permaneçam organizadas, consistentes e relacionadas entre si, respeitando a arquitetura adotada pela aplicação.

---

## Considerações sobre os Endpoints

Todos os recursos apresentados neste capítulo seguem os princípios da arquitetura REST, utilizando:

- métodos HTTP padronizados;
- comunicação em formato JSON;
- autenticação baseada em JWT quando necessária;
- respostas estruturadas;
- organização modular dos recursos.

A documentação apresentada serve como referência para o consumo da API por aplicações web, dispositivos móveis ou outros sistemas que necessitem integrar-se ao **Carpe Diem**.

Com isso, conclui-se a documentação completa dos endpoints disponibilizados pela API.
# 13.10 Relacionamento entre as Entidades

O banco de dados da plataforma **Carpe Diem** foi desenvolvido seguindo o modelo relacional, garantindo a integridade das informações e permitindo o relacionamento entre as entidades da aplicação.

Cada entidade representa um módulo específico do sistema e se comunica com as demais através de chaves primárias e estrangeiras, assegurando consistência e organização dos dados.

---

## Diagrama Simplificado

```text
                              USERS
                                │
               ┌────────────────┼─────────────────┐
               │                │                 │
               ▼                ▼                 ▼
         PORTFOLIOS         REVIEWS          MESSAGES
               │                │
               ▼                │
            PHOTOS              │
                                │
                                ▼
                          PHOTOGRAPHERS

               │
               ▼

         SPECIALTIES



       FAQ CATEGORIES
              │
              ▼
            FAQS



          CONTACTS
```

---

## Relacionamentos

### Users

A entidade **Users** representa todos os usuários cadastrados na plataforma.

Ela possui relacionamento com diversos módulos da aplicação.

Um usuário pode:

- possuir diversos portfólios;
- realizar avaliações;
- enviar mensagens;
- receber mensagens.

---

### Portfolios

Cada portfólio pertence a um fotógrafo.

Um fotógrafo pode possuir diversos portfólios.

Cada portfólio contém diversas fotografias.

Relacionamento:

```text
Users

1 ─────────────── N

Portfolios
```

---

### Photos

Cada fotografia pertence a apenas um portfólio.

Relacionamento:

```text
Portfolios

1 ─────────────── N

Photos
```

---

### Reviews

As avaliações são realizadas por usuários para fotógrafos.

Relacionamento:

```text
Users

1 ─────────────── N

Reviews
```

---

### Messages

As mensagens estabelecem comunicação entre usuários cadastrados.

Relacionamento:

```text
Users

1 ─────────────── N

Messages
```

---

### Contacts

As mensagens enviadas através da página de contato são armazenadas independentemente da autenticação do usuário.

---

### FAQs

Cada pergunta pertence obrigatoriamente a uma categoria.

Relacionamento:

```text
FAQ Categories

1 ─────────────── N

FAQs
```

---

## Benefícios do Modelo Relacional

A estrutura adotada oferece diversas vantagens para a aplicação.

- Organização dos dados;
- Redução de redundâncias;
- Integridade referencial;
- Facilidade de manutenção;
- Maior escalabilidade;
- Melhor desempenho nas consultas.

---

# 13.11 Tratamento de Erros

A API do **Carpe Diem** utiliza respostas padronizadas para informar falhas ocorridas durante o processamento das requisições.

Independentemente do endpoint acessado, todos os erros seguem o mesmo padrão de resposta JSON, permitindo que aplicações clientes realizem o tratamento adequado das exceções.

---

## Estrutura da Resposta

```json
{
    "code":400,
    "type":"error",
    "status":"bad_request",
    "message":"Descrição do erro."
}
```

---

## Campos da Resposta

| Campo | Descrição |
|--------|-----------|
| code | Código HTTP retornado pela API |
| type | Tipo da resposta (`success` ou `error`) |
| status | Identificador textual do erro |
| message | Mensagem explicativa |

---

## 400 — Bad Request

Ocorre quando a requisição enviada apresenta informações inválidas ou obrigatórias ausentes.

### Exemplos

- Campos obrigatórios não enviados;
- Formato inválido de e-mail;
- Senha incompatível;
- Dados inconsistentes;
- Identificador inválido.

### Exemplo

```json
{
    "code":400,
    "type":"error",
    "status":"bad_request",
    "message":"O campo email é obrigatório."
}
```

---

## 401 — Unauthorized

Retornado quando o usuário não está autenticado ou quando o token JWT informado é inválido.

### Situações comuns

- Token não enviado;
- Token expirado;
- Token inválido.

### Exemplo

```json
{
    "code":401,
    "type":"error",
    "status":"unauthorized",
    "message":"Usuário não autenticado."
}
```

---

## 403 — Forbidden

Indica que o usuário está autenticado, porém não possui permissão para acessar determinado recurso.

### Exemplo

```json
{
    "code":403,
    "type":"error",
    "status":"forbidden",
    "message":"Acesso negado."
}
```

---

## 404 — Not Found

O recurso solicitado não foi localizado.

### Situações comuns

- Registro inexistente;
- Endpoint inexistente;
- Identificador inválido.

### Exemplo

```json
{
    "code":404,
    "type":"error",
    "status":"not_found",
    "message":"Registro não encontrado."
}
```

---

## 500 — Internal Server Error

Representa um erro inesperado ocorrido durante o processamento da requisição.

Normalmente está relacionado a problemas internos da aplicação ou falhas de comunicação com o banco de dados.

### Exemplo

```json
{
    "code":500,
    "type":"error",
    "status":"internal_server_error",
    "message":"Erro interno do servidor."
}
```

---

## Padronização das Respostas

A utilização de um formato único para todas as respostas de erro proporciona diversos benefícios.

- Facilidade de integração com aplicações clientes;
- Padronização do tratamento de exceções;
- Melhor organização da documentação;
- Redução de inconsistências;
- Facilidade de manutenção futura.

Dessa forma, não é necessário documentar os mesmos erros em cada endpoint individualmente, tornando a documentação mais objetiva e organizada.

---

# 13.12 Códigos HTTP Utilizados

A API utiliza os códigos de status definidos pelo protocolo HTTP para indicar o resultado das operações realizadas.

Esses códigos permitem que a aplicação cliente identifique rapidamente o resultado de cada requisição.

---

## Tabela de Códigos

| Código | Nome | Utilização |
|---------|------|------------|
| 200 | OK | Requisição executada com sucesso. |
| 201 | Created | Novo recurso criado com sucesso. |
| 400 | Bad Request | Dados inválidos enviados na requisição. |
| 401 | Unauthorized | Usuário não autenticado. |
| 403 | Forbidden | Usuário sem permissão para acessar o recurso. |
| 404 | Not Found | Recurso solicitado não encontrado. |
| 500 | Internal Server Error | Erro interno da aplicação. |

---

## Fluxo Geral das Respostas

```text
Cliente

      │

      ▼

Requisição HTTP

      │

      ▼

API REST

      │

      ▼

Processamento

      │

      ├────────────► Sucesso
      │                 │
      │                 ▼
      │          HTTP 200 / 201
      │
      ▼

Erro

      │

      ▼

HTTP 400
HTTP 401
HTTP 403
HTTP 404
HTTP 500
```

---

## Considerações

A utilização dos códigos HTTP padronizados permite maior interoperabilidade entre sistemas e facilita a integração da API com aplicações web, dispositivos móveis e outros consumidores dos serviços disponibilizados pelo **Carpe Diem**.

Além disso, a padronização das respostas torna o processo de desenvolvimento mais organizado, reduzindo ambiguidades durante a comunicação entre cliente e servidor.
# 13.13 Como Executar a API

Esta seção descreve os procedimentos necessários para executar a API do **Carpe Diem** em ambiente de desenvolvimento.

---

## Requisitos

Antes de iniciar a execução do projeto, é necessário possuir os seguintes softwares instalados:

- PHP 8.1 ou superior;
- Composer;
- Servidor Web (Apache ou Nginx);
- MySQL 8.0 ou superior;
- Git.

---

## Clonando o Projeto

Clone o repositório utilizando o comando:

```bash
git clone https://github.com/usuario/carpe-diem.git
```

Após o download, acesse a pasta da API.

```bash
cd carpe-diem/api
```

---

## Instalação das Dependências

O projeto utiliza o **Composer** como gerenciador de dependências.

Execute o comando:

```bash
composer install
```

Esse processo instalará automaticamente todas as bibliotecas utilizadas pela API.

---

## Configuração do Banco de Dados

Crie um banco de dados MySQL.

Exemplo:

```sql
CREATE DATABASE carpe_diem;
```

Após a criação, importe o arquivo SQL disponibilizado junto ao projeto.

---

## Configuração da Aplicação

Configure os parâmetros de conexão com o banco de dados no arquivo correspondente.

Informações normalmente configuradas:

- Host;
- Porta;
- Nome do banco;
- Usuário;
- Senha.

Também deverá ser configurada a chave utilizada para autenticação JWT.

---

## Inicializando o Servidor

O projeto poderá ser executado utilizando Apache (XAMPP, Laragon ou WAMP) ou através do servidor interno do PHP.

Exemplo:

```bash
php -S localhost:8000
```

Após a inicialização, a API estará disponível para consumo através do endereço configurado.

---

## Testando os Endpoints

Os endpoints podem ser testados utilizando ferramentas específicas para APIs, como:

- Postman;
- Insomnia;
- Thunder Client (Visual Studio Code).

Nas rotas protegidas, o token JWT deverá ser enviado no cabeçalho da requisição.

Exemplo:

```http
Authorization: Bearer eyJhbGc...
```

---

# 13.14 Estrutura da API

A organização dos diretórios da API segue o padrão MVC, promovendo separação das responsabilidades entre as diferentes camadas da aplicação.

```text
api/

│

├── composer.json

├── composer.lock

├── index.php

├── vendor/

│

└── source/

      ├── Config/

      ├── Controllers/

      ├── Models/

      ├── Routes/

      ├── Core/

      ├── Helpers/

      └── Database/
```

---

## Descrição dos Diretórios

| Diretório | Finalidade |
|------------|------------|
| Config | Configurações gerais da aplicação. |
| Controllers | Processamento das requisições HTTP. |
| Models | Comunicação com o banco de dados. |
| Routes | Registro das rotas da API. |
| Core | Componentes principais da infraestrutura da aplicação. |
| Helpers | Funções auxiliares utilizadas durante o desenvolvimento. |
| Database | Componentes relacionados à persistência dos dados. |
| Vendor | Dependências instaladas pelo Composer. |

Essa organização facilita a manutenção e expansão da aplicação.

---

# 13.15 Tecnologias Utilizadas

A API foi desenvolvida utilizando tecnologias amplamente empregadas no desenvolvimento de aplicações web modernas.

| Tecnologia | Finalidade |
|------------|------------|
| PHP | Linguagem principal da aplicação. |
| MySQL | Sistema Gerenciador de Banco de Dados Relacional. |
| Composer | Gerenciamento das dependências do projeto. |
| CoffeeCode Router | Gerenciamento das rotas da API. |
| Firebase PHP-JWT | Implementação da autenticação JWT. |
| JSON | Formato utilizado para comunicação entre cliente e servidor. |
| HTTP | Protocolo utilizado para comunicação das requisições. |

---

# 13.16 Segurança da Aplicação

A API foi desenvolvida adotando mecanismos que visam garantir maior segurança durante o processamento das requisições.

Entre as principais medidas implementadas destacam-se:

- autenticação utilizando JSON Web Token (JWT);
- utilização de requisições HTTP padronizadas;
- validação dos dados recebidos;
- controle de acesso às rotas protegidas;
- comunicação baseada em respostas JSON estruturadas;
- organização da aplicação utilizando arquitetura MVC.

Essas práticas contribuem para reduzir vulnerabilidades e facilitar a manutenção futura do sistema.

---

# 13.17 Escalabilidade

A arquitetura utilizada permite que novos módulos sejam incorporados à API sem grandes alterações na estrutura existente.

Novos recursos poderão ser implementados seguindo o mesmo padrão adotado durante o desenvolvimento, preservando a organização da aplicação.

Exemplos de futuras funcionalidades incluem:

- upload de imagens diretamente para armazenamento em nuvem;
- sistema de notificações em tempo real;
- integração com gateways de pagamento;
- agenda de disponibilidade dos fotógrafos;
- chat em tempo real;
- painel administrativo;
- estatísticas e relatórios.

---

# 13.18 Considerações Técnicas

A API REST do **Carpe Diem** foi desenvolvida seguindo boas práticas de desenvolvimento de software, utilizando arquitetura MVC e comunicação baseada no padrão REST.

Sua organização em módulos independentes facilita a manutenção, reutilização e evolução do sistema.

A utilização de autenticação baseada em JSON Web Token (JWT) garante maior segurança durante o acesso aos recursos protegidos, enquanto a padronização das respostas em JSON simplifica a integração com aplicações clientes.

A divisão da aplicação em camadas proporciona baixo acoplamento entre os componentes, favorecendo futuras expansões e reduzindo a complexidade do projeto.

Dessa forma, a API encontra-se preparada para atender às necessidades atuais da plataforma e para receber novas funcionalidades conforme a evolução do sistema.

---

# 13.19 Considerações Finais

O desenvolvimento da API do **Carpe Diem** possibilitou a construção de uma base sólida para a plataforma de fotografia, oferecendo serviços responsáveis pelo gerenciamento dos usuários, fotógrafos, portfólios, fotografias, avaliações, mensagens, contatos e demais recursos do sistema.

A arquitetura adotada, aliada ao padrão REST e ao modelo MVC, proporcionou uma organização consistente do código-fonte, favorecendo a manutenção, escalabilidade e integração com diferentes aplicações consumidoras.

Além disso, a utilização de autenticação baseada em JWT, respostas padronizadas em JSON e organização modular dos componentes torna a aplicação preparada para futuras evoluções, garantindo maior segurança, desempenho e facilidade de desenvolvimento.

A documentação apresentada neste README tem como objetivo facilitar a compreensão da estrutura da API, servir como referência para sua utilização e apoiar futuras manutenções e ampliações do projeto.





