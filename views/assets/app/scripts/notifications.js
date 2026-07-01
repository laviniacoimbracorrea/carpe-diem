/*
 * Authenticated Notification Helper
 * Responsibility: show small feedback messages inside app/admin areas.
 */
function notifyUser(message, type = 'sucesso') {
  if (typeof mostrarAviso === 'function') {
    mostrarAviso(message, type);
    return;
  }

  console.log(`[${type}] ${message}`);
}
