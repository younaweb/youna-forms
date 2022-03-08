import { createStore} from 'vuex'
import axiosClient from '../axios';

const store= createStore({
    state:{
        user:{
            data:{
               
              },
            token:sessionStorage.getItem("TOKEN"),
        }
    },
    getters:{},
    actions:{
        register({commit},user){
            return axiosClient.post('/register',user)
            .then(({data})=>{
                // console.log(data);
                commit('setUser',data.user);
                commit('setToken',data.token)


            });
        },
        login({commit},user){
            return axiosClient.post('/login',user)
            .then(({data})=>{
                // console.log(data);
                commit('setUser',data.user);
                commit('setToken',data.token)


            });
        }
    },
    mutations:{
        setUser(state,userdata){
            state.user.data=userdata
        },
        setToken(state,usertoken){
            state.user.token=usertoken;
            sessionStorage.setItem('TOKEN', usertoken);

        },
        logout(state){
            state.user.data={};
            state.user.token=null;
        }
    },
    modules:{},
});
export default store;