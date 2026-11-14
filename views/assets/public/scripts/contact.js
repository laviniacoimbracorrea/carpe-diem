document.getElementById('form-contato').addEventListener('submit', function(e) {
      e.preventDefault();
      // Por enquanto exibe aviso visual. Quando o backend estiver pronto,
      // aqui entra um fetch POST para /api/contato com os dados do formulário.
      mostrarAviso('Mensagem enviada! Retornaremos em breve.');
      this.reset();
    });
