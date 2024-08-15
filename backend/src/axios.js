import axios from "axios";
import store from "./store";
import router from "./router";

 const axiosClient = axios.create({

    baseURL: `${import.meta.env.VITE_API_BASE_URL}/api`

 })
 axiosClient.interceptors.request.use(
    config=>{
      const token = store.state.user.token; // Access token from Vuex state

        config.headers.Authorization= `Bearer ${token}`
        return config;
    },
    error=>{
      return Promise.reject(error)
    }
 )

 axiosClient.interceptors.response.use(
  response => response,
  error => {
    if (error.response && error.response.status === 401) {
      store.commit('setToken', null);
      router.push({ name: 'login' });
    }
    return Promise.reject(error); // Make sure to return a rejected promise
  }
);

  export default axiosClient;