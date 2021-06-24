import { createStore } from 'vuex'

const state = {
    auth: false
}

const mutations = {
    login (state) {
        state.auth = true;
    },
    logout (state) {
        state.auth = false;
    }
}

const actions = {
    login: ({ commit }) => commit('login'),
    logout: ({ commit }) => commit('logout'),
}

export default createStore({
    state,
    actions,
    mutations
})
