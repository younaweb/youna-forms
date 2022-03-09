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
                
                commit('setUser',data.user);
                commit('setToken',data.token)


            });
        },
        logoutAction({commit}){
            return axiosClient.post('/logout')
            .then((response)=>{
                // console.log(response)
                 commit('logout')
            }).catch(er=>{
                console.log(er.response)
            })
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
            sessionStorage.removeItem("TOKEN");
        }
    },
    modules:{},
});
export default store;