import axios from "axios";
import axiosClient from "../axios";

export function setUser(state, user){
    state.user.data= user;
}
// mutations.js
export const setToken = (state, token) => {
    state.user.token = token;
    if (token) {
      sessionStorage.setItem('TOKEN', token); // Store in sessionStorage
    } else {
      sessionStorage.removeItem('TOKEN'); // Remove from sessionStorage
    }
  
}

export function setProducts(state, [loading, data = null]) {

  if (data) {
    state.products = {
      ...state.products,
      data: data.data,
      links: data.meta?.links,
      page: data.meta.current_page,
      limit: data.meta.per_page,
      from: data.meta.from,
      to: data.meta.to,
      total: data.meta.total,
    }
  }
  state.products.loading = loading;
}