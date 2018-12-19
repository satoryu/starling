<template>
    <div class="container">
        <div class="row">
            <h2>Tweet</h2>
            <div class="col-12">
                <form>
                    <div class="form-group row">
                        <label class="col-1 col-sm-1 align-self-center" for="input-hash-tags">
                            <i class="h3 fas fa-hashtag"></i>
                        </label>
                        <input
                            class="form-control col-11 col-sm-11"
                            type="text"
                            id="input-hash-tags"
                            v-model="inputHashTags"
                        />
                    </div>
                    <div class="form-group row">
                        <textarea
                            class="form-control col-12"
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

