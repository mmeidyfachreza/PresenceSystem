// initial state
const state = {
    size:200,
    qrcode: "loading",
    location:{
        coords:{
            latitude:'',
            longitude:''
        }
    },
    status:false,
    gettingLocation: false,
    errorStr:null,
    lokasi:false,
    statLink: [],
    time: 0,
}

// getters
const getters = {
    qrcode: state => {
        return state.qrcode
    },
}

// actions
const actions = {
    getQRCode ({commit},link) {
        link = link.split('/validasi/')
        axios.get('/api/qrcode-link2/'+link[1]).then(res => {
            console.log(res.data)

            commit('setQRCode', res.data.qrcode)
            commit('setTimeActive', res.data.time)
            state.status = true
        });
    },
    newQRCode ({commit},qrcode) {
        console.log("baru")
        commit('setQRCode', qrcode)
    },
    getLocation ({commit}) {
        state.gettingLocation = true;
        // get position
        navigator.geolocation.getCurrentPosition(pos => {
            state.gettingLocation = false;
            state.location = pos;
            state.lokasi = true;
        }, err => {
            state.gettingLocation = false;
            state.errorStr = err.message;

        })
    },
    activeQRCode({commit}){
        let link = window.location.pathname
        link = link.split('/validasi/')

        axios.get('/api/qrcode-status/'+link[1]).then(res => {
            console.log(res.data)
            commit('setTimeActive', res.data)
            state.status = true
        });
    },

}

// mutations
const mutations = {
  setQRCode (state, qrcode) {
    state.qrcode = qrcode
  },
  setTimeActive(state, time){
      state.time = time
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
