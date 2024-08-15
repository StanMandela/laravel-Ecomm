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