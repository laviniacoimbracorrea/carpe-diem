/*
 * Storage Utility
 * Responsibility: centralize localStorage read/write operations.
 */
function saveToStorage(key, value) {
  localStorage.setItem(key, JSON.stringify(value));
}

function getFromStorage(key, fallback = null) {
  const value = localStorage.getItem(key);
  if (!value) return fallback;

  try {
    return JSON.parse(value);
  } catch (error) {
    return fallback;
  }
}

function removeFromStorage(key) {
  localStorage.removeItem(key);
}
