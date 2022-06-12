
import axios from "axios";

export default {
    async get(url, data = {}, headers = {}) {
        return await axios.get(url, {data, headers});
    },
    async post(url, data = {}, headers = {}) {
        return await axios.post(url, data, {headers: headers})
    },
    async destroy(url, data = {}, headers = {}) {
        return await axios.delete(url, data, {headers: headers})
    },
    async put(url, data = {}, headers = {}) {
        return await axios.put(url, data, {headers: headers})
    },

}
