
/*
 * Storage Utility
 * Responsibility: centralize localStorage operations.
 */

// Salvar qualquer informação
function saveToStorage(key, value) {
    localStorage.setItem(key, JSON.stringify(value));
}

// Recuperar informações
function getFromStorage(key, fallback = null) {

    const value = localStorage.getItem(key);

    if (!value) {
        return fallback;
    }

    try {
        return JSON.parse(value);

    } catch (error) {
        return fallback;
    }
}

// Remover informação
function removeFromStorage(key) {
    localStorage.removeItem(key);
}

// =====================================================
// SESSÃO DO USUÁRIO
// =====================================================

// Salvar os dados do usuário após o login
function salvarSessao(user) {

    saveToStorage('user', user);

    localStorage.setItem('token', user.token);
}

// Recuperar os dados do usuário
function obterSessao() {

    return getFromStorage('user');
}

// Recuperar o token
function obterToken() {

    return localStorage.getItem('token');
}

// Encerrar a sessão
function removerSessao() {

    removeFromStorage('user');

    removeFromStorage('token');
}
