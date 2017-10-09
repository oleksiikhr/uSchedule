import axios from 'axios';
import Auth from '../store/auth';

export function get(url, params) {
    return axios({
        method: 'GET',
        url: url,
        params: params,
        headers: {
            'Authorization': 'Bearer ' + Auth.state.token
        }
    });
}

export function post(url, data) {
    return axios({
        method: 'POST',
        url: url,
        data: data,
        headers: {
            'Authorization': 'Bearer ' + Auth.state.token
        }
    })
}

export function del(url) {
    return axios({
        method: 'DELETE',
        url: url,
        headers: {
            'Authorization': 'Bearer ' + Auth.state.token
        }
    })
}

export function put(url, data) {
    return axios({
        method: 'PUT',
        url: url,
        data: data,
        headers: {
            'Authorization': 'Bearer ' + Auth.state.token
        }
    })
}
