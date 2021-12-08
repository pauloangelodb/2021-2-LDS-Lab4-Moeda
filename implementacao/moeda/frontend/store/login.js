// import router from './router'
export const state = () => ({
    token: null,
    me: {
        name: null,
        tipo: null
    }
})

export const mutations = {
    LOGIN(state, token) {
        state.token = token
    },
    LOGOUT(state) {
        state.token = null
    },
    ME(state, user) {
        state.me = user
    }
}

export const actions = {
    userLogin({ commit }, { loginData, router, axios }) {
        commit('LOGIN', loginData)
        axios.get('/me').then(res => {
            commit('ME', res.data)
        })
        router.push('/')

    },
    async userLogout({ commit }, { router }) {
        if (router) await router.push('/login')
        commit('LOGOUT')
    },
    setToken({ commit }, token) {
        return commit('LOGIN',`Bearer ${token}`)
    },
    refresh({ commit }, { loginData, router, axios }){
        axios.post('/refresh').then(res => {
            return commit('LOGIN', `Bearer ${token}`)
        })
    }
}

export const getters = {
    token(state) {
        return state.token
    },
    me(state) {
        return state.me
    }
}
