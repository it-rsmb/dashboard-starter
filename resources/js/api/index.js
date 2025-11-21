export function authHeader(xhr) {
    xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('auth_token'));
}
