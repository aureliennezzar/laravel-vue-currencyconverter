import axios from "axios";
import store from "../store";

const axiosInstance = axios.create({
    baseURL: "http://127.0.0.1:8000/api",
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
})

axiosInstance.interceptors.request.use(config => {
    config.headers['Authorization'] = `Bearer ${store.state.user.token}`;
    return config;
})

export default axiosInstance;
