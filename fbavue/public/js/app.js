var vm = new Vue({

    el: '#ArtikelController',

    data: {

        query: '',

        newArtikel: {

            title: '',
            body: '',
            description: ''
        },
        // pagination: {
        //     total: 0, per_page: 12,
        //     from: 1, to: 0,
        //     current_page: 1
        // },

        // notife remove data
        remove: false,
        // notife edit data
        succ: false,
        // notife add data
        success: false,

        edit: false

    },

    ready: function () {
        this.getData();
    },
    methods: {

        getData: function () {
            // var data = {
            //     paginate: this.pagination.per_page,
            //     page: this.pagination.current_page,
            //     /* additional parameters */
            // };

            this.$http.get('api/artikel', function (events) {
                // console.log(events)
                this.$set('artikels', events)
                // this.$set('pagination', events.data.pagination);
            })

        },

        Search: function () {
            this.$http.post('/api/search', {query: this.query}, function (response) {
                console.log(response)
            })
        },

        // remove artikel

        RemoveArtikel: function (id) {

            var ConfirmBox = confirm("Apakah anda yakin ingin menghapus data ini?")

            if (ConfirmBox) this.$http.delete('/api/artikel/' + id)

            self = this

            this.remove = true
            setTimeout(function () {
                self.remove = false
            }, 5000)

            this.getData()
        },

        // artile edit

        EditArtikel: function (id) {

            var artikel = this.newArtikel

            this.newArtikel = {id: '', title: '', body: '', description: ''}

            this.$http.patch('api/artikel/' + id, artikel, function (data) {
                console.log(data)
            })

            self = this

            this.succ = true
            setTimeout(function () {
                self.succ = false
            }, 5000)

            this.getData()

            this.edit = false
        },


        ShowArtikel: function (id) {
            this.edit = true

            this.$http.get('/api/artikel/' + id, function (data) {
                this.newArtikel.id = data.id
                this.newArtikel.title = data.title
                this.newArtikel.body = data.body
                this.newArtikel.description = data.description
            })
        },

        AddNewUser: function () {

            //INPUT
            var artikel = this.newArtikel

            this.newArtikel = {title: '', body: '', description: ''}
            this.$http.post('/api/artikel/', artikel)

            // show success message
            self = this
            this.success = true
            setTimeout(function () {
                self.success = false
            }, 5000)
            //reload page
            //
            this.getData()
        }

    },


    computed: {

        validation: function () {
            return {
                title: !!this.newArtikel.title.trim(),
                body: !!this.newArtikel.body.trim(),
                description: !!this.newArtikel.description.trim(),

            }
        },

        isValid: function () {
            var validation = this.validation
            return Object.keys(validation).every(function (key) {
                return validation[key]
            })

        }
    },
    components: {
        // pagination: require('vue-bootstrap-pagination')
    }
});