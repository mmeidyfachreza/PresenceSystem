import Vue from 'vue'
import Vuex from 'vuex'
import showqr from './modules/showqr'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        showqr,
    }
})
