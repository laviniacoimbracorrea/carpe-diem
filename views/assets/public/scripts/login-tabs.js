document.addEventListener('DOMContentLoaded', () => {
  const tabs = document.querySelectorAll('.aba');

  const panels = document.querySelectorAll('.painel');

  const API_BASE = '../api';

  // TROCA DAS ABAS

  function activateTab(target) {

    tabs.forEach(tab => {

      tab.classList.toggle(
        'ativa',
        tab.dataset.alvo === target
      );

    });

    panels.forEach(panel => {

      panel.classList.toggle(
        'ativo',
        panel.dataset.painel === target
      );

    });
  }


  tabs.forEach(tab => {

    tab.addEventListener(
      'click',
      () => {

        activateTab(
          tab.dataset.alvo
        );

      }
    );

  });


  // =====================================================
  // ABA VINDO PELA URL
  // =====================================================

  const params =
    new URLSearchParams(
      window.location.search
    );

  const selectedTab =
    params.get('aba') ||
    params.get('tipo');


  if (
    selectedTab &&
    document.querySelector(
      `.aba[data-alvo="${selectedTab}"]`
    )
  ) {

    activateTab(selectedTab);

  }


  // =====================================================
  // CARREGAR ESPECIALIDADES
  // =====================================================

  const photographerForm =
    document.querySelector(
      '.formulario[data-tipo="fotografo"][data-acao="cadastro"]'
    );


  if (photographerForm) {

    const specialtySelect =
      photographerForm.querySelector('select');


    if (specialtySelect) {

      fetch(
        `${API_BASE}/specialties/list`
      )
        .then(response => {

          if (!response.ok) {
            throw new Error(
              'Não foi possível carregar as especialidades.'
            );
          }

          return response.json();

        })
        .then(result => {

          if (
            !result ||
            !Array.isArray(result.data)
          ) {

            throw new Error(
              'Formato inválido de especialidades.'
            );
          }

          specialtySelect.innerHTML =
            '<option value="">Selecione...</option>';

          result.data.forEach(
            specialty => {

              const option =
                document.createElement('option');

              option.value =
                specialty.id;

              option.textContent =
                specialty.type;

              specialtySelect.appendChild(
                option
              );

            }
          );

        })
        .catch(error => {

          console.error(
            'Erro ao carregar especialidades:',
            error
          );

        });

    }

  }


  // =====================================================
  // CADASTRO
  // =====================================================

  document
    .querySelectorAll(
      '.formulario[data-acao="cadastro"]'
    )
    .forEach(form => {

      form.addEventListener(
        'submit',
        async event => {

          event.preventDefault();

          const tipo =
            form.dataset.tipo;

          // =================================================
          // CAMPOS
          // =================================================

          const inputs =
            form.querySelectorAll('input');

          const name =
            inputs[0]?.value.trim();

          const email =
            inputs[1]?.value.trim();

          const password =
            inputs[2]?.value;

          const city =
            inputs[3]?.value.trim();

          const state =
            inputs[4]?.value.trim();

          const phone =
            inputs[5]?.value.trim();

          const button =
            form.querySelector(
              'button[type="submit"]'
            );


          // =================================================
          // VALIDAÇÃO
          // =================================================

          if (
            !name ||
            !email ||
            !password ||
            !city ||
            !state ||
            !phone
          ) {

            mostrarMensagem(
              'Preencha todos os campos obrigatórios.'
            );

            return;
          }


          if (password.length < 6) {

            mostrarMensagem(
              'A senha deve possuir pelo menos 6 caracteres.'
            );

            return;
          }


          // =================================================
          // BOTÃO
          // =================================================

          if (button) {

            button.disabled = true;

            button.textContent =
              'Cadastrando...';

          }


          // =================================================
          // DADOS
          // =================================================

          const data = {

            name: name,

            email: email,

            password: password,

            city: city,

            state: state,

            phone_number: phone

          };


          let endpoint;


          // =================================================
          // CLIENTE
          // =================================================

          if (tipo === 'cliente') {

            endpoint =
              `${API_BASE}/users/client`;

          }


          // =================================================
          // FOTÓGRAFO
          // =================================================

          else if (
            tipo === 'fotografo'
          ) {

            endpoint =
              `${API_BASE}/users/photographer`;

            const specialtySelect =
              form.querySelector('select');


            if (!specialtySelect) {

              throw new Error(
                'Campo de especialidade não encontrado.'
              );
            }


            const specialtyId =
              specialtySelect.value;


            if (!specialtyId) {

              mostrarMensagem(
                'Selecione uma especialidade.'
              );

              if (button) {

                button.disabled = false;

                button.textContent =
                  'Enviar requisição';

              }

              return;
            }


            data.specialty_id =
              Number(specialtyId);

          }


          else {

            mostrarMensagem(
              'Tipo de cadastro inválido.'
            );

            if (button) {

              button.disabled = false;

            }

            return;
          }


          // =================================================
          // ENVIA PARA API
          // =================================================

          try {

            console.log(
              'Endpoint:',
              endpoint
            );

            console.log(
              'Dados enviados:',
              data
            );


            const response =
              await fetch(
                endpoint,
                {
                  method: 'POST',

                  headers: {
                    'Content-Type':
                      'application/json',

                    'Accept':
                      'application/json'
                  },

                  body:
                    JSON.stringify(data)
                }
              );


            const responseText =
              await response.text();


            console.log(
              'Status:',
              response.status
            );

            console.log(
              'Resposta:',
              responseText
            );


            let result;


            try {

              result =
                JSON.parse(responseText);

            } catch (error) {

              throw new Error(
                'A API retornou uma resposta inválida.'
              );

            }


            // =================================================
            // ERRO
            // =================================================

            if (!response.ok) {

              throw new Error(
                result.message ||
                'Não foi possível realizar o cadastro.'
              );
            }


            // =================================================
            // SUCESSO
            // =================================================

            mostrarMensagem(
              result.message ||
              'Cadastro realizado com sucesso!'
            );


            setTimeout(() => {

              window.location.replace(
                `login.html?tipo=${tipo}`
              );

            }, 1000);

          } catch (error) {

            console.error(
              'Erro no cadastro:',
              error
            );

            mostrarMensagem(
              error.message
            );


            if (button) {

              button.disabled = false;

              if (
                tipo === 'cliente'
              ) {

                button.textContent =
                  'Criar conta de cliente';

              } else {

                button.textContent =
                  'Enviar requisição';

              }

            }

          }

        }
      );

    });


  // =====================================================
  // MENSAGEM
  // =====================================================

  function mostrarMensagem(
    mensagem
  ) {

    if (
      typeof mostrarAviso === 'function'
    ) {

      mostrarAviso(mensagem);

    } else if (
      typeof showWarning === 'function'
    ) {

      showWarning(mensagem);

    } else {

      alert(mensagem);

    }

  }

});