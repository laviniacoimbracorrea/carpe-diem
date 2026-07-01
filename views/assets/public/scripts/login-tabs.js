/*
 * Authentication tabs
 * Responsibility: switch between client, photographer and admin panels.
 */
document.addEventListener('DOMContentLoaded', () => {
  const tabs = document.querySelectorAll('.aba');
  const panels = document.querySelectorAll('.painel');

  function activateTab(target) {
    tabs.forEach(tab => tab.classList.toggle('ativa', tab.dataset.alvo === target));
    panels.forEach(panel => panel.classList.toggle('ativo', panel.dataset.painel === target));
  }

  tabs.forEach(tab => {
    tab.addEventListener('click', () => activateTab(tab.dataset.alvo));
  });

  const params = new URLSearchParams(window.location.search);
  const selectedTab = params.get('aba') || params.get('tipo');

  if (selectedTab && document.querySelector(`.aba[data-alvo="${selectedTab}"]`)) {
    activateTab(selectedTab);
  }
});
