var modal = require('vue-strap/dist/vue-strap.min').modal
var alert = require('vue-strap/dist/vue-strap.min').alert
var sidebar = require('vue-strap/dist/vue-strap.min').aside
var BounceLoader = require('vue-spinner/dist/vue-spinner.min').BounceLoader
var pagination = require('vue-laravel-pagination')

function BasketVM () {
  return {
    el: function () {
      return '#BasketController'
    },
    watch: function () {
      return {
        baskets: {
          handler: function (val, oldVal) {
            console.log('baskets changed')
          },
          deep: true
        }
      }
    },
    data: function () {
      return {
        query: '',
        newBasket: {
          id: '',
          name: '',
          max_capacity: '',
          contents: ''
        },
        baskets: [],
        items: [],
        props: ['baskets', 'items'],
        pagination: {
          total: undefined,  // total number of elements or items
          per_page: undefined, // items per page
          current_page: undefined, // current page (it will be automatically updated when users clicks on some page number).
          total_pages: undefined, // total pages in record,
          next_page_url: null,
          prev_page_url: null,
          to: null
        },
        paginationItems: {
          total: undefined,  // total number of elements or items
          per_page: undefined, // items per page
          current_page: undefined, // current page (it will be automatically updated when users clicks on some page number).
          total_pages: undefined, // total pages in record,
          next_page_url: null,
          prev_page_url: null,
          to: null
        },
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
        showSideLoader: false,
        activeBasketId: undefined,
        selectedBasket: undefined,
        isSideSuccess: false,
        isSuccess: false,
        isErrorAppeared: false,
        isSideErrorAppeared: false,
        successSideMsg: undefined,
        errorSideMsg: undefined,
        successMsg: undefined,
        errorMsg: undefined,
        showLoader: false
      }
    },
    twoWay: true,
    ready: function () {
      this.isReadyToUpdateCollection = true
      this.getData()
    },
    events: {
      'deleted-msg': function (basket) {
        // `this` in event callbacks are automatically bound
        // to the instance that registered it
        this.baskets.$remove(basket)
      },
      'created-msg': function (basket) {
        // `this` in event callbacks are automatically bound
        // to the instance that registered it
        var newBask = JSON.parse(basket)
        this.baskets.push(newBask)
      }
    },
    methods: {
      getData: function () {
        this.getCollection()
      },
      Search: function () {
        this.$http.post('http://fbavue.app/api/search', {query: this.query}, function (response) {
          console.log(response)
        }, function (response) {
          this.sideErrorAppeared(response)
        })
      },
      getItemsCollectionAttached: function (activeBasketId) {
        var data = {
          paginate: this.paginationItems.per_page,
          page: this.paginationItems.current_page
        }
        var self = this
        if (typeof activeBasketId === 'undefined') {
          this.$http.get('http://fbavue.app/api/item', data, function (response) {
            if (response.data) {
              this.$set('items', response.data)
              this.$set('paginationItems', response.meta.pagination)
              self.paginationItems.to = response.meta.pagination.links.next
            } else {
              this.$set('items', response)
              this.$set('paginationItems', response.meta.pagination)
              self.paginationItems.to = response.meta.pagination.links.next
            }
          }, function (response) {
            this.sideErrorAppeared(response)
          })
        } else {
          this.$http.get('http://fbavue.app/api/basket/items/' + activeBasketId, function (response) {
            if (response.data) {
              this.$set('items', response.data)
            } else {
              this.$set('items', response)
            }
          }, function (response) {
            this.sideErrorAppeared(response)
          })
        }
      },
      GetBasketContent: function (basket) {
        if (this.showContents) {
          this.showContents = false
          this.selectedBasket = undefined
        } else {
          this.showLoader = true
          this.showContents = true
          this.selectedBasket = basket
          this.activeBasketId = basket.id
          this.$set('activeBasketId', basket.id)
          this.getItemsCollectionAttached(this.activeBasketId)
          this.showLoader = false
        }
      },
      EditBasketPage: function (id) {
        this.edit = true
      },
      deleteBasket: function (basket) {
        var self = this
        this.$http.delete('http://fbavue.app/api/basket/' + basket.id).then(
          function (response) {
            self.baskets.$remove(basket)
            self.remove = true
            window.setTimeout(function () {
              self.remove = false
              self.getData()
            }, 1000)
          }, function (response) {
          self.sideErrorAppeared(response)
        })
      },
      deleteItem: function (item) {
        var self = this
        this.$http.delete('http://fbavue.app/api/basket/' + this.selectedBasket.id + '/items/delete/' + item.id).then(
          function (response) {
            self.remove = true
            self.showSideLoader = true
            window.setTimeout(function () {
              self.remove = false
              self.showSideLoader = false
            }, 1000)
            self.getData()
            self.getItemsCollectionAttached(self.selectedBasket.id)
            self.sideSuccess('Item deleted successfully')
          }, function (response) {
          console.log(response)
          self.sideErrorAppeared(response)
        })
      },
      addItem: function (item) {
        var self = this
        this.$http.patch('http://fbavue.app/api/basket/' + this.selectedBasket.id + '/items/add/' + item.id).then(
          function (response) {
            self.succ = true
            self.showSideLoader = true
            window.setTimeout(function () {
              self.showSideLoader = false
            }, 1000)
            self.getData()
            self.getItemsCollectionAttached(self.selectedBasket.id)
            this.sideSuccess('Item Added successfully')
          }, function (response) {
          this.sideErrorAppeared(response)
          self.succ = false
        })
      },
      created: function () {
        this.$set('baskets', JSON.parse(this.baskets))
      },
      updated: function () {
        this.$set('baskets', JSON.parse(this.baskets))
      },
      deleted: function () {
        this.$set('baskets', JSON.parse(this.baskets))
      },
      showEditBasket: function (id) {
        this.showForm = true
        this.edit = true
        var self = this
        this.$http.get('http://fbavue.app/api/basket/' + id, function (data) {
          this.newBasket.id = data.id
          this.newBasket.name = data.name
          this.newBasket.max_capacity = data.max_capacity
          this.newBasket.contents = data.contents
        }, function (data) {
          self.ErrorAppeared(data)
          console.log(data)
        })
      },
      showCreateBasket: function (id) {
        this.showForm = true
        this.edit = false
        this.newBasket = {id: '', name: '', max_capacity: '', contents: ''}
      },
      AddNewBasket: function () {
        // INPUT
        var basket = this.newBasket
        this.newBasket = {name: '', max_capacity: '', contents: ''}
        var self = this
        this.$http.post('http://fbavue.app/api/basket/', basket).then(
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
          self.ErrorAppeared(response)
          console.log('Error Appeared not created')
        })
      },
      // basket edit
      EditBasket: function (id) {
        var basket = this.newBasket
        var self = this
        this.newBasket = {id: '', name: '', max_capacity: '', contents: ''}
        this.$http.patch('http://fbavue.app/api/basket/' + id, basket).then(
          function (response) {
            self.succ = true
            window.setTimeout(function () {
              self.succ = false
            }, 1000)
            self.showForm = false
            self.edit = false
            self.getData()
          }, function (response) {
          self.ErrorAppeared(response)
        })
      },
      ShowBasket: function (id) {
        this.edit = true
        this.$http.get('http://fbavue.app/api/basket/' + id, function (data) {
          this.newBasket.id = data.id
          this.newBasket.name = data.name
          this.newBasket.max_capacity = data.max_capacity
          this.newBasket.contents = data.contents
        })
      },
      getCollection: function () {
        var self = this
        var data = {
          paginate: this.pagination.per_page,
          page: this.pagination.current_page
        }
        this.$http.get('http://fbavue.app/api/basket', data, function (response) {
          if (response.data) {
            self.showLoaderWhen(self)
            this.$set('baskets', response.data)
            this.$set('pagination', response.meta.pagination)
            self.pagination.to = response.meta.pagination.links.next
          } else {
            self.showLoaderWhen(self)
            this.$set('baskets', response)
            this.$set('pagination', response.meta.pagination)
            self.pagination.to = response.meta.pagination.links.next
          }
        }, function (response) {
          self.showLoaderWhen(self)
        })
      },
      showLoaderWhen: function (self) {
        self.showLoader = true
        window.setTimeout(function () {
          self.showLoader = false
        }, 1000)
      },
      isSucc: function () {
        if (this.succ || this.remove) {
          return true
        }
        return false
      },
      errorAppeared: function () {
        if (this.validation.name || this.validation.max_capacity || this.validation.contents) {
          return true
        }
        return false
      },
      sideSuccess: function (msg) {
        if (this.isSideSuccess) {
          this.isSideSuccess = false
          this.successSideMsg = msg
        } else {
          this.isSideSuccess = true
          this.successSideMsg = undefined
        }
      },
      sideErrorAppeared: function (response) {
        if (this.isSideErrorAppeared) {
          this.isSideErrorAppeared = false
          this.errorSideMsg = undefined
        } else {
          this.isSideErrorAppeared = true
          this.errorSideMsg = response.data.responseJSON
        }
      },
      Success: function (msg) {
        if (this.isSuccess) {
          this.isSuccess = false
          this.successMsg = msg
        } else {
          this.isSideSuccess = true
          this.successMsg = undefined
        }
      },
      ErrorAppeared: function (response) {
        if (this.isErrorAppeared) {
          this.isErrorAppeared = false
          this.errorMsg = undefined
        } else {
          this.isSideErrorAppeared = true
          this.errorMsg = response.data.message !== undefined ? response.data.message : response.data
        }
      }
    },
    computed: {
      validation: function () {
        if (!this.newBasket) {
          this.newBasket = {name: '', max_capacity: ''}
        }
        return {
          name: !!this.newBasket.name.trim(),
          max_capacity: !!this.newBasket.max_capacity.trim() && !isNaN(this.newBasket.max_capacity)
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
      modal,
      alert,
      sidebar,
      BounceLoader,
      pagination
    }
  }
}
export default BasketVM
