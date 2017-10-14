import axios from 'axios'

export function get(url, params) {
    return axios({
        method: 'GET',
        url: url,
        params: params,
        headers: {
            'Authorization': 'Bearer ' + window.localStorage.getItem('token')
        }
    })
}

export function post(url, data) {
    return axios({
        method: 'POST',
        url: url,
        data: data,
        headers: {
            'Authorization': 'Bearer ' + window.localStorage.getItem('token')
        }
    })
}

export function del(url) {
    return axios({
        method: 'DELETE',
        url: url,
        headers: {
            'Authorization': 'Bearer ' + window.localStorage.getItem('token')
        }
    })
}

export function put(url, data) {
    return axios({
        method: 'PUT',
        url: url,
        data: data,
        headers: {
            'Authorization': 'Bearer ' + window.localStorage.getItem('token')
        }
    })
}
