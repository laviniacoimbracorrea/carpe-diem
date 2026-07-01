/*
 * Section Navigation Component
 * Responsibility: switch visible dashboard sections when a navigation item is clicked.
 */
function initializeSectionNavigation(options = {}) {
  const linkSelector = options.linkSelector || '.nav-link';
  const sectionSelector = options.sectionSelector || '.app-secao-pagina';
  const sectionPrefix = options.sectionPrefix || 'secao-';
  const activeClass = options.activeClass || 'ativo';
  const displayMode = options.displayMode || 'class';

  const links = document.querySelectorAll(linkSelector);
  const sections = document.querySelectorAll(sectionSelector);

  if (!links.length || !sections.length) return;

  links.forEach(link => {
    link.addEventListener('click', event => {
      event.preventDefault();
      const target = link.dataset.secao;
      if (!target) return;

      links.forEach(item => item.classList.remove(activeClass));
      link.classList.add(activeClass);

      sections.forEach(section => {
        if (displayMode === 'style') section.style.display = 'none';
        else section.classList.remove(activeClass);
      });

      const activeSection = document.getElementById(sectionPrefix + target);
      if (!activeSection) return;

      if (displayMode === 'style') activeSection.style.display = 'block';
      else activeSection.classList.add(activeClass);
    });
  });

  links[0].click();
}
