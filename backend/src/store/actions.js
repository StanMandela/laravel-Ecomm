import axiosClient from "../axios";


export function getUser({commit}){
  return axiosClient.get('/user')
  .then(({data}) =>{
    commit('setUser', data)
    return data;
  })
}

export function login({commit}, data) {
    return axiosClient.post('/login', data)
      .then(({data}) => {
        commit('setUser', data.user);
        commit('setToken', data.token)
        return data;
      })
}

 export function logout({commit}) {
    return axiosClient.post('/logout')
      .then((response) => {
        commit('setToken', null)
  
        return response;
      })
  }

  export function getProducts({commit},{url=null, search='', perPage=10,sort_field, sort_direction}={}){
    commit('setProducts', [true])
    url =url ||'/product'
    return axiosClient.get(url,{
      params:{
        search,
        per_page:perPage,
        sort_field,
        sort_direction
  }
    })
    .then(res=>{
      commit('setProducts', [false,res.data])
    })
    .catch(()=>{
      commit('setProducts', [false])
    })
  
  }

  export function  createProduct({commit}, product) {
    if (product.image instanceof File) {
      const form = new FormData();
      form.append('title', product.title);
      form.append('image', product.image);
      form.append('description', product.description);
      form.append('price', product.price);
      product = form;
    }
    return axiosClient.post('/product', product)
  }

  export function updateProduct({commit}, product) {
    const id = product.id
    //check if Image if loaded
    if (product.image instanceof File) {
      const form = new FormData();
      form.append('id', product.id);
      form.append('title', product.title);
      form.append('image', product.image);
      form.append('description', product.description);
      form.append('price', product.price);
      form.append('_method', 'PUT');
      product = form;
    }
    return axiosClient.post(`/product/${id}`, product)
  }

  export function deleteProduct({commit}, id) {
    return axiosClient.delete(`/product/${id}`)
  }