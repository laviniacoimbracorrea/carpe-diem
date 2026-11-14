document.addEventListener('DOMContentLoaded', carregarFAQs);

async function carregarFAQs() {
  const lista = document.getElementById('list-faqs');
  if (!lista) return;
  lista.innerHTML = '<li class="faq-carregando">Carregando perguntas...</li>';
  try {
    const response = await fetch('../api/faqs/list', { headers: { Accept: 'application/json' } });
    const result = await response.json();
    if (!response.ok) throw new Error(result.message || 'Não foi possível carregar as perguntas.');
    const faqs = Array.isArray(result.data) ? result.data : [];
    lista.replaceChildren();
    if (!faqs.length) {
      lista.innerHTML = '<li class="faq-carregando">Ainda não há perguntas cadastradas.</li>';
      return;
    }
    faqs.forEach(faq => {
      const item = document.createElement('li');
      item.className = 'faq-item';
      const button = document.createElement('button');
      button.className = 'faq-question';
      button.type = 'button';
      button.setAttribute('aria-expanded', 'false');
      const question = document.createElement('span');
      question.textContent = faq.question || '';
      const icon = document.createElement('span');
      icon.className = 'faq-icon';
      icon.textContent = '+';
      button.append(question, icon);
      const answer = document.createElement('p');
      answer.className = 'faq-answer';
      answer.textContent = faq.answer || '';
      button.addEventListener('click', () => {
        const wasOpen = item.classList.contains('active');
        lista.querySelectorAll('.faq-item').forEach(other => {
          other.classList.remove('active');
          other.querySelector('.faq-question')?.setAttribute('aria-expanded', 'false');
        });
        if (!wasOpen) {
          item.classList.add('active');
          button.setAttribute('aria-expanded', 'true');
        }
      });
      item.append(button, answer);
      lista.appendChild(item);
    });
  } catch (error) {
    console.error('Erro ao carregar FAQs:', error);
    lista.innerHTML = '<li class="faq-carregando">Não foi possível carregar as perguntas agora. Tente novamente mais tarde.</li>';
  }
}
