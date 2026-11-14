# Autenticação, sessão e perfis - Carpe Diem

## 1. Banco de dados

Antes de testar a nova versão, execute no phpMyAdmin:

`data-base/auth-session-migration.sql`

Esse script adiciona à tabela `users`:

- `active`: 1 = conta ativa, 0 = conta desativada.
- `last_login_at`: data e hora do último login real.

O arquivo `admin-logins.sql` também contém essa atualização e os dois administradores fixos.

## 2. Administradores

- nat@gmail.com / 406080
- lav@gmail.com / 204060

Os dois possuem `type_id = 1` e são armazenados com hash de senha.

## 3. O que foi implementado

### Sessão persistente

O token JWT fica no `localStorage` e é validado pela API em `/users/me`. Assim, navegar para Início, Portfólios, Sobre, Contato ou FAQ não apaga a sessão.

### Retorno à página anterior

Se o usuário clicar em Entrar em uma página pública, depois do login ele retorna para aquela página. Se entrar diretamente na página de login, vai para o painel correspondente.

### Perfil real

Cliente, fotógrafo e administrador podem alterar dados que existem na tabela `users`:

- nome
- e-mail
- cidade
- estado
- telefone
- senha
- especialidade do fotógrafo

As alterações são feitas por `PUT` na API e salvas no MySQL.

### Administração real

O painel administrativo consulta a tabela `users` diretamente. Mostra:

- nome
- e-mail
- tipo
- cidade/estado
- especialidade do fotógrafo
- status da conta
- último login

O administrador pode ativar/desativar outras contas.

## 4. Arquivos principais alterados

- `api/index.php`
- `api/source/Controller/Api.php`
- `api/source/Controller/Users.php`
- `api/source/Models/User.php`
- `api/source/Core/JWTToken.php`
- `views/assets/_common/scripts/global.js`
- `views/assets/public/scripts/login-redirect.js`
- `views/assets/app/scripts/client-dashboard.js`
- `views/assets/app/scripts/photographer-dashboard.js`
- `views/assets/admin/scripts/admin-dashboard.js`
- `views/app-client.html`
- `views/app-fotografo.html`
- `views/admin.html`
- `views/login.html`
- `data-base/admin-logins.sql`
- `data-base/auth-session-migration.sql`

## 5. Observação sobre foto e biografia

A tabela `users` fornecida no projeto não possui colunas para foto ou biografia. Por isso, nesta etapa os campos realmente persistidos são os dados existentes no banco. Para tornar foto e biografia persistentes também será necessário criar as colunas/tabelas e endpoints correspondentes.


### Aprovação de fotógrafos

Novos fotógrafos são cadastrados com `approval_status = 0` e ficam aguardando o administrador. Clientes e administradores entram com `approval_status = 1`. O painel administrativo lê os fotógrafos pendentes diretamente da tabela `users`. Ao aprovar, o status passa para `1`; ao recusar, passa para `2` e a conta fica inativa.
