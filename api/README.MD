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
11. Tecnologias
12. Estrutura Inicial do Projeto

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

# Considerações Finais

O **Carpe Diem** foi concebido para atender uma necessidade real do mercado regional de fotografia, oferecendo uma plataforma especializada para divulgação de portfólios e aproximação entre fotógrafos e clientes.

A documentação apresentada descreve a estrutura do sistema, os requisitos, as regras de negócio, a arquitetura, a modelagem de dados e os processos necessários para orientar o desenvolvimento e facilitar futuras manutenções e evoluções da plataforma.

---

## Estrutura Final do README

-  1 – Introdução e visão geral
-  2 – Arquitetura, requisitos e regras de negócio
-  3 – Banco de dados e modelagem
-  4 – Documentação funcional e fluxos
-  5 – Instalação, configuração, segurança e deploy
-  6 – Diagramas, manuais, roadmap, FAQ e anexos

---



