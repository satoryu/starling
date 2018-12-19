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
export default {
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
            const status = this.status;
            this.inputStatus = '';

            const resultStatus = await axios.post('/api/tweets', {
                status: status
            });
            console.log(resultStatus);
        }
    }
}
</script>

