import { createStore} from 'vuex'
import axiosClient from '../axios';

const store= createStore({
    state:{
        user:{
            data:{
               
              },
            token:sessionStorage.getItem("TOKEN"),
        },
        questionTypes:["text", "select", "radio", "checkbox", "textarea"],
        currentForm: {
          data: {},
          loading: false,
        },
        forms:{
          loading:false,
          links:[],
          data:{}
        },
        dashboard: {
          loading: false,
          data: {}
        },
        update:false,
        
    },
    getters:{},
    actions:{
      getAllForms({commit}, {url = null} = {}){
        url = url || "/forms";
        commit('setFormsLoading',true);
        return axiosClient.get(url)
        .then(res=>{
          commit('setFormsLoading',false);
          commit('setAllForms',res.data);
          
        })
      },
      viewCurrentForm({commit},slug){
        commit("setCurrentFormLoading", true);
        return axiosClient
          .get(`/public-form/${slug}`)
          .then((res) => {
            commit("setCurrentForm", res.data);
            commit("setCurrentFormLoading", false);
            return res;
          })
          .catch((err) => {
            commit("setCurrentFormLoading", false);
            throw err;
          });
      },
      getCurrentForm({ commit }, id) {
        commit("setCurrentFormLoading", true);
        return axiosClient
          .get(`/forms/${id}`)
          .then((res) => {
            commit("setCurrentForm", res.data);
            commit("setCurrentFormLoading", false);
            return res;
          })
          .catch((err) => {
            commit("setCurrentFormLoading", false);
            throw err;
          });
      },
      saveSurvey({ commit, dispatch }, survey) {

      delete survey.image_url;

      let response;
      if (survey.id) {
        response = axiosClient
          .put(`/survey/${survey.id}`, survey)
          .then((res) => {
            commit('setCurrentSurvey', res.data)
            return res;
          });
      } else {
        response = axiosClient.post("/survey", survey).then((res) => {
          commit('setCurrentSurvey', res.data)
          return res;
        });
      }

      return response;
    },

    saveFormAnswer({commit}, {formId, answers}) {
      return axiosClient.post(`/form/${formId}/answer`, {answers});
    },
    getDashboardData({commit}) {
      commit('dashboardLoading', true)
      return axiosClient.get(`/dashboard`)
      .then((res) => {
        commit('dashboardLoading', false)
        commit('setDashboardData', res.data)
        return res;
      })
      .catch(error => {
        commit('dashboardLoading', false)
        return error;
      })

    },







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
        },

        saveFormInfo({commit},model){
          delete model.image_url; 
          if(model.id){
            this.state.update=true;
            return axiosClient.put('/forms/'+model.id,model)
            .then((response)=>{
  
              commit('setCurrentForm',response.data)
              return response.data;
            })
          }else{
            // debugger;
            this.state.update=false;
            return axiosClient.post('/forms',model)
            .then((response)=>{
              // console.log('reponse attendu :',response);
              // debugger;
              commit('setCurrentForm',response.data)
              
              return response.data;
              
            }).catch(er=>{
              console.log(er);
            })

          }
        },
        deleteForm({commit},id){
          return axiosClient.delete('/forms/'+id);
      
        }
    },
    mutations:{
      setCurrentFormLoading: (state, loading) => {
        state.currentForm.loading = loading;
      },
      setCurrentForm: (state, form) => {
        state.currentForm.data = form.data;
      },
      setFormsLoading: (state, loading) => {
        state.forms.loading = loading;
      },
      setAllForms: (state, form) => {
        state.forms.data = form.data;
        state.forms.links = form.meta.links;
      },
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
        },
        syncForms(state,id){
          state.forms.data=state.forms.data.filter(f=>f.id !==id);
         
        },
        dashboardLoading: (state, loading) => {
          state.dashboard.loading = loading;
        },
        setDashboardData: (state, data) => {
          state.dashboard.data = data
        }
      
    },
    modules:{},
});
export default store;