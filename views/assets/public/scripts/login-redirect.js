/*
 * LOGIN
 *
 * 1 = Administrador
 * 2 = Fotógrafo
 * 3 = Cliente
 */

document.addEventListener('DOMContentLoaded', () => {
  const API_URL = '../api/users/login';

  const typeByForm = {
    administrador: 1,
    admin: 1,
    fotografo: 2,
    cliente: 3
  };

  const redirectByType = {
    1: 'admin.html',
    2: 'app-fotografo.html',
    3: 'app-client.html'
  };

  document.querySelectorAll('.formulario[data-acao="login"]').forEach(form => {
    form.addEventListener('submit', async event => {
      event.preventDefault();

      const emailInput = form.querySelector('input[type="email"]');
      const passwordInput = form.querySelector('input[type="password"]');
      const button = form.querySelector('button[type="submit"]');

      const email = emailInput ? emailInput.value.trim() : '';
      const password = passwordInput ? passwordInput.value : '';
      const tipo = form.dataset.tipo;
      const typeId = typeByForm[tipo];

      if (!email || !password) {
        mostrarMensagem('Preencha o e-mail e a senha.');
        return;
      }

      if (!typeId) {
        mostrarMensagem('Tipo de usuário inválido.');
        return;
      }

      if (button) {
        button.disabled = true;
        button.textContent = 'Entrando...';
      }

      const loginData = {
        email: email,
        password: password,
        type_id: Number(typeId)
      };

      console.log('Dados enviados no login:', loginData);

      try {
        const response = await fetch(API_URL, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify(loginData)
        });

        const responseText = await response.text();

        console.log('Status login:', response.status);
        console.log('Resposta login:', responseText);

        let result;

        try {
          result = JSON.parse(responseText);
        } catch (error) {
          console.error('A API não retornou JSON válido:', responseText);
          throw new Error('A API retornou uma resposta inválida.');
        }

        if (!response.ok) {
          throw new Error(
            result.message || 'Não foi possível realizar o login.'
          );
        }

        const user = result.data;

        if (!user || !user.token) {
          throw new Error(
            'A API não retornou os dados do login corretamente.'
          );
        }

        if (Number(user.type_id) !== Number(typeId)) {
          throw new Error('Esta conta não pertence a esta área.');
        }

        if (typeof salvarSessao === 'function') {
          salvarSessao(user);
        } else {
          localStorage.setItem('token', user.token);
          localStorage.setItem('user', JSON.stringify(user));
        }

        const returnParam = new URLSearchParams(window.location.search).get('return');
        const allowedReturn = returnParam && !returnParam.includes('://') && !returnParam.startsWith('//') && !returnParam.includes('\\');
        const targetPage = allowedReturn ? returnParam : redirectByType[Number(user.type_id)];

        if (!targetPage) {
          throw new Error('Tipo de usuário não reconhecido.');
        }

        mostrarMensagem('Login realizado com sucesso!');

        setTimeout(() => {
          window.location.replace(targetPage);
        }, 500);

      } catch (error) {
        console.error('Erro no login:', error);
        mostrarMensagem(error.message || 'Erro ao realizar login.');

        if (button) {
          button.disabled = false;

          if (tipo === 'cliente') {
            button.textContent = 'Entrar como cliente';
          } else if (tipo === 'fotografo') {
            button.textContent = 'Entrar como fotógrafo';
          } else {
            button.textContent = 'Entrar no painel';
          }
        }
      }
    });
  });

  function mostrarMensagem(mensagem) {
    if (typeof showWarning === 'function') {
      showWarning(mensagem);
    } else if (typeof mostrarAviso === 'function') {
      mostrarAviso(mensagem);
    } else {
      alert(mensagem);
    }
  }
});
