/*
 * Login redirect controller
 * Responsibility: simulate authentication and send each user type to the correct area.
 */
document.addEventListener('DOMContentLoaded', () => {
  const redirectByUserType = {
    administrador: 'admin.html',
    admin: 'admin.html',
    fotografo: 'app-fotografo.html',
    cliente: 'app-client.html'
  };

  document.querySelectorAll('.formulario').forEach(form => {
    form.addEventListener('submit', event => {
      event.preventDefault();

      const userType = form.dataset.tipo || 'cliente';
      const targetPage = redirectByUserType[userType] || 'app-client.html';

      if (typeof mostrarAviso === 'function') {
        mostrarAviso(`Login realizado como ${userType}!`);
      }

      window.location.replace(targetPage);
    });
  });
});
