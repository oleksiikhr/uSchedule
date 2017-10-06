export default {
    state: {
        token: null,
        user: null,
    },
    initialize() {
        this.state.token = localStorage.getItem('token');
        this.state.user = localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : null;
    },
    set(token, user) {
        localStorage.setItem('token', token);
        localStorage.setItem('user', JSON.stringify(user));
        this.initialize();
    },
    remove() {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        this.initialize();
    },
}