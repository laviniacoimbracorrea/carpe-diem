# 📸 Carpe Diem
### Plataforma web para divulgação de fotógrafos e seus portfólios

**Versão acadêmica:** Etapas 06 e 07 | **Estado:** em desenvolvimento e testes locais  
**Desenvolvedoras:** Lavínia Coimbra Correa e Natasha Brasil Abreu  
**Curso:** Técnico Integrado em Informática

> Este README documenta o conteúdo do projeto incluído neste pacote. Recursos descritos como implementados foram identificados no código; isso não equivale a homologação completa com Apache e MySQL.

## 1. Sobre o projeto

O Carpe Diem aproxima fotógrafos e clientes em uma plataforma regional de fotografia. Fotógrafos podem criar perfis e organizar trabalhos em portfólios; clientes podem descobrir profissionais, consultar seus trabalhos e interagir com a plataforma. Administradores dispõem de recursos para gestão de usuários e aprovação de fotógrafos.

O projeto foi desenvolvido como atividade acadêmica e utiliza uma API PHP para persistência em MySQL e páginas HTML/CSS/JavaScript no frontend.

## 2. Perfis e funcionalidades

| Perfil | Funcionalidades identificadas no código |
|---|---|
| Cliente | Cadastro, login, visualização de fotógrafos e portfólios, edição de perfil, foto de perfil e integração com mensagens |
| Fotógrafo | Cadastro, login condicionado à aprovação, edição de perfil, foto de perfil, criação/edição/exclusão lógica de portfólios, upload de fotos e capa, visualização e gestão de mensagens |
| Administrador | Listagem e alteração de situação de usuários, aprovação de fotógrafos e rotas de administração |

Também existem controllers e rotas para **avaliações (`reviews`)**, **contatos (`contacts`)**, **especialidades (`specialties`)** e **perguntas frequentes (`faqs`, `faqscategories`)**. A presença de rotas não garante que todas as interfaces e todos os fluxos estejam completos.

### Recursos ainda não comprovados nesta versão

- Recuperação de senha por e-mail.
- Favoritos persistidos em banco e agenda de disponibilidade.
- Pagamentos, assinaturas, contratação ou negociação automatizada.
- Álbuns independentes *dentro* de cada portfólio. Atualmente, o relacionamento implementado é **portfólio → várias fotos**.
- Notificações em tempo real e marcação de mensagens como lidas. O esquema de mensagens deste pacote não possui coluna `lida`; um contador de mensagens não equivale necessariamente a mensagens não lidas.
- Estatísticas completas, auditoria e relatórios administrativos avançados.
- Garantia de tempo de carregamento inferior a três segundos ou compatibilidade comprovada com todos os navegadores.

## 3. Tecnologias e arquitetura

- **Frontend:** HTML5, CSS3 e JavaScript, com scripts públicos, comuns e das áreas autenticadas.
- **Backend:** PHP, Composer, CoffeeCode Router e API HTTP com respostas JSON.
- **Persistência:** MySQL, com acesso ao banco por componentes PHP do projeto.
- **Autenticação:** JWT, utilizado nas rotas protegidas.
- **Ambiente de desenvolvimento:** XAMPP (Apache + MySQL) e navegador.
- **Organização:** controllers, models, classes de infraestrutura e scripts de interface separados por responsabilidade; princípios de MVC.

Fluxo geral: `Navegador → JavaScript/fetch → API PHP/Router → Controller → Model → MySQL → JSON → interface`.

## 4. Estrutura real do repositório

```text
carpe-diem-etapa07-botao-remover-estilizado/
├── api/
│   ├── index.php                 # Definição de rotas
│   ├── composer.json
│   ├── vendor/                   # Dependências presentes no pacote
│   ├── source/
│   │   ├── Config/Config.php
│   │   ├── Controller/
│   │   ├── Core/
│   │   ├── Models/
│   │   └── Support/Upload.php
│   └── uploads/
│       ├── profiles/             # Fotos de perfil enviadas
│       └── portfolio/            # Fotos e capas enviadas
├── views/
│   ├── login.html
│   ├── register.html
│   ├── app-client.html
│   ├── app-fotografo.html
│   ├── admin.html
│   ├── portfolios.html
│   ├── portfolio.html
│   └── assets/
│       ├── _common/
│       ├── app/
│       └── public/
├── banco-carpe-diem-integracao.sql
├── etapa07.sql
├── data-base/
└── README.MD
```

A árvore é resumida. O projeto também contém arquivos auxiliares e instruções de etapas anteriores.

## 5. Banco de dados

**Nome configurado:** `projeto`, em `api/source/Config/Config.php`.

O arquivo `banco-carpe-diem-integracao.sql` descreve a integração das etapas 06 e 07 e inclui, entre outras, as seguintes tabelas:

| Tabela | Função e campos relevantes |
|---|---|
| `users_types` | Tipos de usuário |
| `users` | Usuários, `type_id`, `specialty_id`, `photo`, `active`, `approval_status` |
| `specialty` | Especialidades |
| `portfolios` | Portfólios, `user_id`, `title`, `description`, `cover_link`, `active` |
| `photos` | Fotos de cada portfólio, `portfolio_id`, `link`, `active` |
| `message` | Mensagens entre usuário e fotógrafo; não há campo de leitura no SQL fornecido |
| `reviews` | Avaliações |
| `contacts` | Contatos |
| `faqs`, `faqs_categories` | Perguntas frequentes e categorias |

**Relacionamentos centrais:** `users.id → portfolios.user_id` e `portfolios.id → photos.portfolio_id` (1:N). O banco usa identificadores e nomes de colunas em inglês; os exemplos antigos com `usuarios`, `fotografos` e `fotos` não correspondem a este código.

**Importante:** faça backup antes de importar ou executar migrações. O arquivo `etapa07.sql` contém alterações específicas de imagens; o SQL de integração deve ser revisado conforme o estado do banco já existente. Não execute migrações repetidamente sem verificar a estrutura atual.

## 6. Rotas REST encontradas em `api/index.php`

O prefixo de acesso é `<URL_DO_PROJETO>/api`. A tabela registra **rotas declaradas** no Router; autorização e validação dependem de cada controller.

| Recurso | Métodos e caminhos declarados |
|---|---|
| Usuários | `POST /users/login`, `GET /users/me`, `POST /users/photo`, `GET /users/photographers` |
| Cadastro/edição | `POST /users/client`, `PUT /users/client`, `DELETE /users/client`; equivalentes `/users/photographer`; `PUT` e `DELETE /users/admin` |
| Administração | `GET /users/admin/users`, `PUT /users/admin/user-status`, `PUT /users/admin/photographer-approval` |
| Portfólios | `GET /portfolios/list`, `GET /portfolios/mine`, `GET /portfolios/select/{id}`, `POST /portfolios/insert`, `PUT /portfolios/update`, `DELETE /portfolios/delete/{id}` |
| Fotos | `GET /photos/list`, `GET /photos/portfolio/{portfolio_id}`, `GET /photos/select/{id}`, `POST /photos/upload`, `POST /photos/cover`, `POST /photos/insert`, `PUT /photos/update`, `DELETE /photos/delete/{id}` |
| Avaliações | `GET /reviews/list`, `GET /reviews/list/{review_id}`, `POST /reviews/`, `PUT /reviews/{review_id}`, `DELETE /reviews/{review_id}` |
| Mensagens | `GET /messages/list`, `GET /messages/list/{message_id}`, `POST /messages/`, `PUT /messages/{message_id}`, `DELETE /messages/{message_id}` |
| Contatos | `GET /contacts/list`, `GET /contacts/list/{contact_id}`, `POST /contacts/`, `PUT /contacts/{contact_id}`, `DELETE /contacts/{contact_id}` |
| FAQs | `GET /faqs/list`, `GET /faqs/admin/list`, `GET /faqs/select/{id}`, `POST /faqs/insert`, `PUT /faqs/update`, `DELETE /faqs/delete/{id}` |
| Categorias FAQ | `GET /faqscategories/list`, `GET /faqscategories/select/{id}`, `POST /faqscategories/insert`, `PUT /faqscategories/update`, `DELETE /faqscategories/delete/{id}` |
| Especialidades | `GET /specialties/list`, `GET /specialties/select/{id}`, `POST /specialties/insert`, `PUT /specialties/update`, `DELETE /specialties/delete/{id}` |

**Observação técnica:** `api/index.php` ainda declara rotas didáticas de `/products` que apontam para `Products`, mas não foi identificado um controller `Products.php` neste pacote. Elas não fazem parte das funcionalidades documentadas do Carpe Diem e precisam de revisão antes de serem utilizadas.

### Autenticação

Após o login, a API utiliza JWT. Para requisições protegidas, o cliente deve enviar o token no formato esperado pelo controller, normalmente `Authorization: Bearer <TOKEN>`. A autorização deve ser verificada no backend, não apenas escondendo botões no frontend.

## 7. Upload de imagens (Etapa 07)

| Operação | Rota | Persistência |
|---|---|---|
| Foto de perfil | `POST /users/photo` | Arquivo em `api/uploads/profiles/` e caminho em `users.photo` |
| Foto do portfólio | `POST /photos/upload` | Arquivo em `api/uploads/portfolio/` e registro em `photos.link` |
| Capa do portfólio | `POST /photos/cover` | Arquivo em `api/uploads/portfolio/` e caminho em `portfolios.cover_link` |
| Fotos de um portfólio | `GET /photos/portfolio/{portfolio_id}` | Consulta dos registros persistidos |
| Exclusão de foto | `DELETE /photos/delete/{id}` | Exclusão conforme a lógica implementada pelo controller |

O upload utiliza `multipart/form-data`. **Não defina manualmente `Content-Type` ao enviar `FormData` com `fetch`**, pois o navegador precisa definir o `boundary`.

A documentação específica `api/ETAPA07-README.md` informa JPEG/PNG/WEBP, foto de perfil até **5 MB** e persistência das imagens de portfólio, com verificações de autenticação e propriedade. Consulte também `COMO-TESTAR-UPLOAD-XAMPP.md`.

A interface usa a imagem padrão `views/assets/_common/images/default-profile.jpg` quando não existe uma foto válida definida para o usuário. Isso não restaura arquivos antigos ausentes no servidor.

**Preservação obrigatória:** atualizar o ZIP ou substituir o código não pode apagar `api/uploads/`. Os caminhos armazenados no MySQL não contêm os bytes das imagens. Faça backup **do banco e da pasta `api/uploads/` juntos**.

## 8. Como executar localmente

1. Instale e inicie **Apache** e **MySQL** no XAMPP.
2. Extraia o projeto para `C:\xampp\htdocs\carpe-diem-etapa07-botao-remover-estilizado` (ou outra pasta, anotando o nome).
3. Crie ou confira o banco `projeto` no phpMyAdmin. Utilize os SQLs incluídos conforme o estado atual do banco, sempre após backup.
4. Confira os dados de conexão em `api/source/Config/Config.php`. A configuração atual do pacote usa `localhost`, banco `projeto`, usuário `root`, porta `3306` e senha vazia, configuração típica **apenas para ambiente local**.
5. Se as dependências não estiverem presentes, execute `composer install` dentro de `api/`. O pacote já inclui `vendor/`.
6. Confira no `php.ini` se `file_uploads` está habilitado e se `upload_max_filesize` e `post_max_size` suportam os arquivos enviados; reinicie o Apache após mudanças.
7. Acesse `http://localhost/carpe-diem-etapa07-botao-remover-estilizado/views/login.html` (ajuste o nome da pasta, se diferente).
8. Use o cadastro/login para testar os perfis. Para fotógrafos novos, confira o fluxo de aprovação administrativa.

O `Config.php` deste pacote calcula a URL-base a partir do caminho do script, para acomodar diferentes nomes de pasta no XAMPP.

## 9. Testes recomendados antes da apresentação

- [ ] Cadastrar cliente e fotógrafo, testar credenciais corretas/incorretas e aprovação.
- [ ] Verificar que usuários de tipos diferentes não acessam ações privadas de outros perfis.
- [ ] Editar informações de perfil e confirmar persistência após `Ctrl + F5`.
- [ ] Enviar nova foto de perfil e conferir arquivo em `api/uploads/profiles/`.
- [ ] Criar portfólio, editar título e descrição, alterar capa e conferir arquivo em `api/uploads/portfolio/`.
- [ ] Enviar duas fotos ao portfólio, recarregar a página e confirmar que continuam visíveis.
- [ ] Excluir uma foto sem excluir a outra; verificar atualização no banco e na interface.
- [ ] Enviar/consultar mensagens; confirmar se os indicadores exibem contagem real ou valor fixo.
- [ ] Testar arquivo inválido, tamanho excedido e tentativa de upload sem autorização.
- [ ] Fazer backup de `api/uploads/` e do banco antes de substituir arquivos do projeto.

**Limite da revisão:** este README foi alinhado à estrutura e às rotas do ZIP fornecido. Não houve execução da aplicação com MySQL/Apache neste ambiente; os testes acima precisam ser realizados localmente.

## 10. Segurança e manutenção

- Use validação no servidor, consultas parametrizadas e hash seguro de senhas.
- Restrinja operações de alteração aos usuários autenticados e autorizados.
- Valide tipo MIME, tamanho e conteúdo de arquivos recebidos.
- Evite divulgar tokens, senhas e segredos de configuração; **o segredo JWT presente no `Config.php` deve ser substituído por um segredo privado antes de qualquer publicação externa**.
- Faça backup periódico do banco e dos uploads. O projeto acadêmico não deve ser considerado pronto para produção sem auditoria de segurança e testes.

## 11. Evoluções planejadas

Recuperação de senha, favoritos, álbuns independentes dentro de portfólios, agenda, notificações com controle de leitura, relatórios e recursos comerciais poderão ser desenvolvidos posteriormente. Eles **não são anunciados como concluídos** nesta versão.

## 12. Créditos e licença

Projeto acadêmico desenvolvido por **Lavínia Coimbra Correa** e **Natasha Brasil Abreu**, para fins educacionais. O uso de imagens e de dependências de terceiros deve respeitar suas licenças e direitos.

---

**Documento atualizado para refletir o pacote Carpe Diem da Etapa 07, com base em inspeção estática do código e dos arquivos SQL fornecidos.**
