export function checkAuth () {
    if (localStorage.getItem('authHeader') && localStorage.getItem('authHeaderExpire')) {
        const now = Math.trunc(Date.now() / 1000);
        if (localStorage.getItem('authHeaderExpire') > now) {
            return true;
        }
    }
    return false;
}
