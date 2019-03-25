import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

const state = {
    lastTweet: null
}

const mutations = {
    setLastTweet(state, tweet) {
        state.lastTweet = tweet
    }
}

const actions = {
    async tweet({commit}, status) {
        axios.post('/api/tweets', {
            status: status
        }).then((response) => {
            commit('setLastTweet', status);
            console.log(response);
        }).catch((error) => console.log(error));
    }
}

export default new Vuex.Store({
    state, mutations, actions
});
