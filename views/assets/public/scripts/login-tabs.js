
document.addEventListener('DOMContentLoaded', () => {

    // Endereço da API do Carpe Diem
    const API_BASE = 'http://localhost:8080/carpe-diem/api';

    // =====================================================
    // TROCA DAS ABAS
    // =====================================================

    const tabs = document.querySelectorAll('.aba');
    const panels = document.querySelectorAll('.painel');

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
        tab.addEventListener('click', () => {
            activateTab(tab.dataset.alvo);
        });
    });

    // =====================================================
    // ABA VINDO PELA URL
    // =====================================================

    const params = new URLSearchParams(window.location.search);

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
    // MENSAGENS
    // =====================================================

    function mostrarMensagem(mensagem) {

        if (typeof mostrarAviso === 'function') {
            mostrarAviso(mensagem);

        } else if (typeof showWarning === 'function') {
            showWarning(mensagem);

        } else {
            alert(mensagem);
        }
    }

    // =====================================================
    // COMUNICAÇÃO COM A API
    // =====================================================

  
async function enviarRequisicao(url, data) {

    const response = await fetch(url, {
        method: 'POST',

        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'Accept': 'application/json'
        },

        body: new URLSearchParams(data).toString()
    });

    const responseText = await response.text();

    let result;

    try {
        result = JSON.parse(responseText);

    } catch (error) {
        console.error('Resposta recebida:', responseText);

        throw new Error(
            'A API retornou uma resposta inválida.'
        );
    }

    if (!response.ok) {
        throw new Error(
            result.message ||
            'Não foi possível concluir a operação.'
        );
    }

    return result;
}


    // =====================================================
    // CARREGAR ESPECIALIDADES
    // =====================================================

    const photographerForm = document.querySelector(
        '.formulario[data-tipo="fotografo"][data-acao="cadastro"]'
    );

    if (photographerForm) {

        const specialtySelect =
            photographerForm.querySelector('select');

        if (specialtySelect) {

            fetch(`${API_BASE}/specialties/list`, {
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(response => {

                    if (!response.ok) {
                        throw new Error(
                            'Não foi possível carregar as especialidades.'
                        );
                    }

                    return response.json();
                })
                .then(result => {

                    if (!Array.isArray(result.data)) {
                        throw new Error(
                            'Formato inválido de especialidades.'
                        );
                    }

                    specialtySelect.innerHTML =
                        '<option value="">Selecione...</option>';

                    result.data.forEach(specialty => {

                        const option =
                            document.createElement('option');

                        option.value = specialty.id;
                        option.textContent = specialty.type;

                        specialtySelect.appendChild(option);
                    });
                })
                .catch(error => {

                    console.error(
                        'Erro ao carregar especialidades:',
                        error
                    );

                    mostrarMensagem(error.message);
                });
        }
    }

    // =====================================================
    // CADASTRO
    // =====================================================

    document.querySelectorAll(
        '.formulario[data-acao="cadastro"]'
    ).forEach(form => {

        form.addEventListener('submit', async event => {

            event.preventDefault();

            const tipo = form.dataset.tipo;

            const nameInput = form.querySelector('[name="name"]');
const emailInput = form.querySelector('[name="email"]');
const passwordInput = form.querySelector('[name="password"]');

            const name = nameInput?.value.trim() || '';
            const email = emailInput?.value.trim() || '';
            const password = passwordInput?.value || '';

            const button = form.querySelector(
                'button[type="submit"]'
            );

            // Validar campos obrigatórios
            if (!name || !email || !password) {

                mostrarMensagem(
                    'Preencha nome, e-mail e senha.'
                );

                return;
            }

            if (password.length < 6) {

                mostrarMensagem(
                    'A senha deve possuir pelo menos 6 caracteres.'
                );

                return;
            }

            // Dados básicos do cadastro
            const data = {
                name: name,
                email: email,
                password: password
            };

            // Campos adicionais opcionais
            const cityInput =
                form.querySelector('[name="city"]');

            const stateInput =
                form.querySelector('[name="state"]');

            const phoneInput =
                form.querySelector('[name="phone_number"]');

            if (cityInput?.value.trim()) {
                data.city = cityInput.value.trim();
            }

            if (stateInput?.value.trim()) {
                data.state = stateInput.value.trim();
            }

            if (phoneInput?.value.trim()) {
                data.phone_number = phoneInput.value.trim();
            }

            let endpoint;

            if (tipo === 'cliente') {

                endpoint = `${API_BASE}/users/client`;

            } else if (tipo === 'fotografo') {

                endpoint = `${API_BASE}/users/photographer`;

                // Especialidade opcional
                const specialtySelect =
                    form.querySelector('select');

                const specialtyId =
                    specialtySelect?.value;

                if (specialtyId) {
                    data.speciality_id = Number(specialtyId);
                }

            } else {

                mostrarMensagem(
                    'Tipo de cadastro inválido.'
                );

                return;
            }

            // Estado do botão
            if (button) {
                button.disabled = true;
                button.textContent = 'Cadastrando...';
            }

            console.log('Dados enviados:', data);
            console.log('Endpoint:', endpoint);

            try {

                const result = await enviarRequisicao(
                    endpoint,
                    data
                );

                mostrarMensagem(
                    result.message ||
                    (
                        tipo === 'fotografo'
                            ? 'Requisição enviada com sucesso!'
                            : 'Cadastro realizado com sucesso!'
                    )
                );

                setTimeout(() => {
                    window.location.replace(
                        `login.html?tipo=${encodeURIComponent(tipo)}`
                    );
                }, 1000);

            } catch (error) {

                console.error(
                    'Erro no cadastro:',
                    error
                );

                mostrarMensagem(error.message);

                if (button) {
                    button.disabled = false;

                    button.textContent =
                        tipo === 'cliente'
                            ? 'Criar conta de cliente'
                            : 'Enviar requisição';
                }
            }
        });
    });

    // =====================================================
    // LOGIN
    // =====================================================

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

    document.querySelectorAll(
        '.formulario[data-acao="login"]'
    ).forEach(form => {

        form.addEventListener('submit', async event => {

            event.preventDefault();

            const emailInput =
                form.querySelector('input[type="email"]');

            const passwordInput =
                form.querySelector('input[type="password"]');

            const button = form.querySelector(
                'button[type="submit"]'
            );

            const email = emailInput?.value.trim() || '';
            const password = passwordInput?.value || '';

            const tipo = form.dataset.tipo;
            const typeId = typeByForm[tipo];

            if (!email || !password) {

                mostrarMensagem(
                    'Preencha o e-mail e a senha.'
                );

                return;
            }

            if (!typeId) {

                mostrarMensagem(
                    'Tipo de usuário inválido.'
                );

                return;
            }

            if (button) {
                button.disabled = true;
                button.textContent = 'Entrando...';
            }

            const loginData = {
                email: email,
                password: password,
                type_id: typeId
            };

            try {

                const result = await enviarRequisicao(
                    `${API_BASE}/users/login`,
                    loginData
                );

                const user = result.data;

                if (!user || !user.token) {
                    throw new Error(
                        'A API não retornou os dados do login corretamente.'
                    );
                }

                if (Number(user.type_id) !== typeId) {
                    throw new Error(
                        'Esta conta não pertence a esta área.'
                    );
                }

                // Salvar sessão
                if (typeof salvarSessao === 'function') {

                    salvarSessao(user);

                } else {

                    localStorage.setItem(
                        'token',
                        user.token
                    );

                    localStorage.setItem(
                        'user',
                        JSON.stringify(user)
                    );
                }

                // Verificar página de retorno
                const returnParam =
                    new URLSearchParams(
                        window.location.search
                    ).get('return');

                const allowedReturn =
                    returnParam &&
                    !returnParam.includes('://') &&
                    !returnParam.startsWith('//') &&
                    !returnParam.includes('\\');

                const targetPage = allowedReturn
                    ? returnParam
                    : redirectByType[typeId];

                if (!targetPage) {
                    throw new Error(
                        'Tipo de usuário não reconhecido.'
                    );
                }

                mostrarMensagem(
                    'Login realizado com sucesso!'
                );

                setTimeout(() => {
                    window.location.replace(targetPage);
                }, 500);

            } catch (error) {

                console.error(
                    'Erro no login:',
                    error
                );

                mostrarMensagem(
                    error.message ||
                    'Erro ao realizar login.'
                );

                if (button) {

                    button.disabled = false;

                    if (tipo === 'cliente') {

                        button.textContent =
                            'Entrar como cliente';

                    } else if (tipo === 'fotografo') {

                        button.textContent =
                            'Entrar como fotógrafo';

                    } else {

                        button.textContent =
                            'Entrar no painel';
                    }
                }
            }
        });
    });

});
