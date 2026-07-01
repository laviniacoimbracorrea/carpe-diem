const faqs = [
      {
        categoria: 'Para clientes',
        itens: [
          {
            p: 'Preciso criar uma conta para ver os portfólios?',
            r: 'Não. Todos os portfólios são acessíveis sem cadastro. A conta é necessária apenas para enviar mensagens aos fotógrafos e deixar avaliações.'
          },
          {
            p: 'Como entro em contato com um fotógrafo?',
            r: 'Dentro de cada portfólio há um formulário de mensagem. Você precisará estar logado como cliente para enviá-la. O fotógrafo recebe a mensagem na sua área de aplicação.'
          },
          {
            p: 'As avaliações são verificadas?',
            r: 'Sim. Apenas usuários com conta de cliente podem deixar avaliações. Cada avaliação passa por moderação antes de ser exibida publicamente.'
          },
          {
            p: 'O Carpe Diem intermedia o pagamento?',
            r: 'Não. A plataforma conecta clientes e fotógrafos, mas o contrato e pagamento são negociados diretamente entre as partes.'
          }
        ]
      },
      {
        categoria: 'Para fotógrafos',
        itens: [
          {
            p: 'Como cadastro meu portfólio na plataforma?',
            r: 'Acesse a página de Cadastro, selecione "Sou fotógrafo" e preencha o formulário com suas informações, especialidade e fotos. Sua solicitação será revisada pela nossa equipe em até 5 dias úteis.'
          },
          {
            p: 'Posso editar meu portfólio depois de aprovado?',
            r: 'Sim. Após aprovação e login, você terá acesso à sua área de aplicação onde poderá atualizar fotos, descrição, especialidades e dados de contato a qualquer momento.'
          },
          {
            p: 'Quais regiões são atendidas atualmente?',
            r: 'No momento atendemos fotógrafos da região Sul do Brasil: Paraná, Santa Catarina e Rio Grande do Sul. A expansão para outras regiões está prevista para fases futuras do projeto.'
          }
        ]
      },
      {
        categoria: 'Conta e acesso',
        itens: [
          {
            p: 'Esqueci minha senha. Como recupero o acesso?',
            r: 'Na página de login, utilize a opção "Esqueci minha senha". Você receberá um e-mail com um link de redefinição válido por 24 horas.'
          },
          {
            p: 'Posso ter uma conta de cliente e de fotógrafo ao mesmo tempo?',
            r: 'Não. Cada e-mail está vinculado a um único tipo de conta. Caso precise de ambos os acessos, utilize e-mails diferentes para cada cadastro.'
          },
          {
            p: 'Como excluo minha conta?',
            r: 'Acesse seu perfil na área de aplicação e vá até "Configurações da conta". Lá você encontrará a opção de solicitar a exclusão permanente dos seus dados.'
          }
        ]
      }
    ];

    const lista = document.getElementById('faq-lista');
    let contadorCliques = {};

    faqs.forEach((bloco, bi) => {
      const catEl = document.createElement('span');
      catEl.className = 'faq-categoria';
      catEl.textContent = bloco.categoria;
      lista.appendChild(catEl);

      bloco.itens.forEach((item, ii) => {
        const id = `${bi}-${ii}`;
        contadorCliques[id] = 0;

        const div = document.createElement('div');
        div.className = 'faq-item';
        div.innerHTML = `
          <button class="faq-pergunta" aria-expanded="false" data-id="${id}">
            <span>${item.p}</span>
            <span class="faq-icone">+</span>
          </button>
          <div class="faq-resposta"><p>${item.r}</p></div>
        `;
        lista.appendChild(div);

        div.querySelector('.faq-pergunta').addEventListener('click', function() {
          // Lógica de clique par/ímpar
          contadorCliques[id]++;
          const aberto = contadorCliques[id] % 2 !== 0;

          // Fecha todos os outros
          document.querySelectorAll('.faq-item.aberto').forEach(el => {
            const outroId = el.querySelector('.faq-pergunta').dataset.id;
            if (outroId !== id) {
              contadorCliques[outroId] = 0; // reseta o contador do fechado
              el.classList.remove('aberto');
              el.querySelector('.faq-pergunta').setAttribute('aria-expanded', 'false');
            }
          });

          div.classList.toggle('aberto', aberto);
          this.setAttribute('aria-expanded', aberto);
        });
      });
    });
