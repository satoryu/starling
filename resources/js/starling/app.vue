<template>
    <div class="container">
        <div class="row">
            <h2>Tweet</h2>
            <div class="col-12">
                <form>
                    <div class="input-group row">
                        <div class="input-group-prepend">
                            <i class="input-group-text fas fa-hashtag"></i>
                        </div>
                        <input
                            class="form-control"
                            type="text"
                            id="input-hash-tags"
                            v-model="inputHashTags"
                        />
                    </div>
                    <div class="input-group row">
                        <textarea
                            class="form-control"
                            placeholder="What are u feeling?"
                            v-model="inputStatus"
                            @keydown.ctrl.enter="submitTweet"
                        ></textarea>
                    </div>
                </form>
            </div>
        </div>
        <div id="previewStatus">
            <h2>Preview</h2>
            <pre>{{ status }}</pre>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

import store from './store'

export default {
    store,
    data: function() {
        return {
            inputStatus: '',
            inputHashTags: ''
        }
    },
    computed: {
        hashTags: function() {
            return this.inputHashTags.split(' ').filter(t => t.length > 0);
        },
        status: function () {
            return `${this.inputStatus} ${this.hashTags.map(t => `#${t}`).join(' ')}`
        }
    },
    methods: {
        submitTweet: async function() {
            this.$store.dispatch('tweet', this.status);
            this.inputStatus = '';
        }
    }
}
</script>
