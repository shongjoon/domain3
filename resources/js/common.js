export default {
    data() {
        return {

        }
    },
    methods: {
        async callApi(method, url, dataobj) {
            console.log('callApi in');
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataobj,
                });
            } catch (e) {
                return e.response
            }
        },
        i(desc, title="hey") {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        s(desc, title ="success") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        w(desc, title = "Oops") {
            this.$Notice.warning({
                title: title,
                desc: desc

            });
        },
        e(desc, title = "error") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
        swr(desc='something went wrong!', title = "Oops") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        }
    }
}