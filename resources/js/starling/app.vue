<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form>
                    <div class="form-group">
                        <input
                            class="form-control"
                            type="text"
                            v-model="inputHashTags"
                        />
                    </div>
                    <div class="form-group">
                        <textarea
                            class="form-control"
                            v-model="inputStatus"
                            @keydown.ctrl.enter="submitTweet"
                        ></textarea>
                    </div>
                </form>
            </div>
        </div>
        <div id="previewStatus">
            {{ status }}
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
            return this.inputHashTags.split(' ');
        },
        status: function () {
            return `${this.inputStatus} ${this.hashTags.map(t => `#${t}`).join(' ')}`
        }
    },
    methods: {
        submitTweet: async function() {
            const status = await axios.post('/api/tweets', {
                status: this.status
            });
            console.log(status);
            this.inputStatus = '';
        }
    }
}
</script>

