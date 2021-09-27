import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);
export default new Vuex.Store({
    state: {
        memos: [],
        pagenationData: {}
    },
    mutations: {
        serMemos(state, memos) {
            state.memos = memos
        },
        serPagenationData(state, pagenationData) {
            state.pagenationData = pagenationData
        }
    },
    actions: {
        memoGet({commit}) {
            let page = 1
            axios.get("api/get_memos?page=" + page)
            .then((res) => {
                commit('serMemos', res.data.data)
                commit('serPagenationData', res.data)
            })
        },
        // async memoGet(page = 1) {
        //     console.log(1111);
        //     const res = await this.callApi("get", "api/get_memos?page=" + page);
        //     if (res.status === 200) {
        //         commit('serMemos', res.data.data)
        //         commit('serPagenationData', res.data)
        //     } else {
        //         this.swr();
        //     }
        // },
    },
    getters: {

    }
})