export function logout () {
    if (localStorage.getItem('authHeader')) {
        localStorage.removeItem('authHeader');
    }
    if (localStorage.getItem('authHeaderExpire')) {
        localStorage.removeItem(('authHeaderExpire'));
    }
}
