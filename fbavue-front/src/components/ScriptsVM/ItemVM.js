/**
 * Created by nilse on 5/18/2016.
 */
var modal = require('vue-strap/dist/vue-strap.min').modal
var alert = require('vue-strap/dist/vue-strap.min').alert
var sidebar = require('vue-strap/dist/vue-strap.min').aside
var spinner = require('vue-strap/dist/vue-strap.min').spinner

function ItemVM () {
  return {
    el: function () {
      return '#ItemController'
    },
    watch: function () {
      return {
        items: {
          handler: function (val, oldVal) {
            console.log('items changed')
          },
          deep: true
        }
      }
    },
    data () {
      return {
        msg: 'item',
        query: '',
        newItem: {
          id: '',
          type: '',
          weight: ''
        },
        items: [],
        props: ['items'],
        remove: false,
        // notify edit data
        succ: false,
        // notify add data
        success: false,
        edit: false,
        basket: true,
        showModal: false,
        isReadyToUpdateCollection: false,
        showForm: false,
        showContents: false,
        shouldValidate: false,
        validate: { required: true },
        isValid: false,
        validation: {
          type: true,
          weight: true
        }
      }
    },
    twoWay: true,
    ready: function () {
      this.isReadyToUpdateCollection = true
      this.getData()
    },
    events: {
      'deleted-msg': function (item) {
        // `this` in event callbacks are automatically bound
        // to the instance that registered it
        this.items.$remove(item)
      },
      'created-msg': function (item) {
        // `this` in event callbacks are automatically bound
        // to the instance that registered it
        var newItem = JSON.parse(item)
        this.items.push(newItem)
      }
    },
    methods: {
      getData: function () {
        this.getCollection()
      },
      Search: function () {
        this.$http.post('http://fbavue.app/api/search', {query: this.query}, function (response) {
          console.log(response)
        })
      },
      getCollection: function () {
        this.$http.get('http://fbavue.app/api/item', function (response) {
          if (response.data) {
            this.$set('items', response.data)
          } else {
            this.$set('items', response)
          }
        })
      },
      GetItemContent: function (id) {
        if (this.showContents) {
          this.showContents = false
        } else {
          this.showContents = true
        }
      },
      showCreateItem: function (id) {
        this.showForm = true
        this.edit = false
        this.newItem = {id: '', type: '', weight: ''}
      },
      AddNewItem: function () {
        // INPUT
        var item = this.newItem
        this.newItem = {type: '', weight: ''}
        var self = this
        this.$http.post('http://fbavue.app/api/item/', item).then(
          function (response) {
            // show success message
            self.success = true
            window.setTimeout(function () {
              self.success = false
            }, 1000)
            self.showForm = false
            self.edit = false
            self.getData()
          }, function (response) {
            // error callback
          console.log('Error Appeared not created')
        })
      },
      showSidebarContents: function () {
        if (this.showContents) {
          this.showContents = false
        } else {
          this.showContents = true
          this.getCollection()
        }
      },
      showEditItem: function (id) {
        this.showForm = true
        this.edit = true
        this.$http.get('http://fbavue.app/api/item/' + id, function (data) {
          this.newItem.id = data.id
          this.newItem.type = data.type
          this.newItem.weight = data.weight
        })
      },
      // item edit
      EditItem: function (id) {
        var item = this.newItem
        var self = this
        this.newItem = {id: '', type: '', weight: ''}
        this.$http.patch('http://fbavue.app/api/item/' + id, item).then(
          function (response) {
            self.succ = true
            window.setTimeout(function () {
              self.succ = false
            }, 1000)
            self.showForm = false
            self.edit = false
            self.getData()
          }, function (response) {
          console.log('Error! not Edited')
        })
      },
      ShowItem: function (id) {
        this.edit = true
        this.$http.get('http://fbavue.app/api/item/' + id, function (data) {
          this.newItem.id = data.id
          this.newItem.type = data.type
          this.newItem.weight = data.weight
        })
      }
    },
    isValid: function () {
      var validation = this.validation
      return Object.keys(validation).every(function (key) {
        return validation[key]
      })
    },
    computed: {
    },
    components: {
      modal,
      alert,
      sidebar,
      spinner
    }
  }
}

export default ItemVM
