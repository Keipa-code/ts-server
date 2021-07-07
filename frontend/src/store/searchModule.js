import axios from 'axios'

export default {
  state: {
    phoneList: [],
    query: null,
  },
  mutations: {
    setPhoneList(state, payload) {
      state.phoneList = payload
    },
    setQuery(state, payload) {
      state.query = payload
    }
  },
  getters: {
    getQuery(state) {
      return state.query
    },
    getPhoneList(state) {
      return state.phoneList
    }
  },
  actions: {
    fetchListByNumber(context) {
      axios.post('/api/find', context.getters.getQuery)
        .then(response => context.commit("setPhoneList", response.data))
    },
    fetchListByFIO(context) {
      axios.post('/api/find' + context.getters.getQuery, )
        .then(response => context.commit("setPhoneList", response.data))
    },
    fetchListByOrgName(context) {
      axios.post('/api/find' + context.getters.getQuery, )
        .then(response => context.commit("setPhoneList", response.data))
    },
  }
}