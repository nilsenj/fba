<template>
  <div class="col-md-12">
    <div id="BasketController">
      <div style="margin: 10px 0">
      <div class="row">
          <button class="btn btn-small btn-default pull-left" role="button"
                  @click="showCreateBasket()"
          >Create Basket
          </button>
          <div style="margin: 0 46.4%; text-align: center"><bounce-loader v-if="showLoader" :loading="loading" :color="color" :size="size"></bounce-loader></div>
        </div>
      </div>
      <div class="row">
        <router-view></router-view>
        <modal :show.sync="showForm" effect="zoom">
          <div slot="modal-header" class="modal-header">
            <h4 class="modal-title" v-if="edit">Edit the basket</h4>
            <h4 class="modal-title" v-if="!edit">Add new basket</h4>
          </div>
          <div slot="modal-body" class="modal-body" effect="zoom">
            <alert
              :show.sync="isSuccess"
              :duration="4000"
              type="success"
              width="400px"
              placement="top"
              dismissable
            >
              <span class="icon-ok-circled alert-icon-float-left"></span>
              <strong>Well Done!</strong>
              <p>{{successMsg}}</p>
            </alert>
            <alert
              :show.sync="isSideErrorAppeared"
              :duration="4000"
              type="danger"
              width="400px"
              placement="top"
              dismissable>
              <span class="icon-info-circled alert-icon-float-left"></span>
              <strong>Error appeared!</strong>
              <div class="list-group-item" v-for="(index, error) in errorMsg">
                <srong class="text-danger">{{error}}</srong>
              </div>
            </alert>

            <form action="#" @submit.prevent="AddNewBasket" method="POST">
              <div class="clearfix"></div>
              <div class="form-group">
                <label for="name">Name:</label>
                <input v-model="newBasket.name" type="text" id="name" name="name" placeholder="type the name"
                       class="form-control">
              </div>
              <div class="form-group">
                <label for="max_capacity">Max Contents (in kg):</label>
                <input type="number" v-model="newBasket.max_capacity" step="any"
                       v-text="newBasket.max_capacity | isDecimal "
                       name="max_capacity" id="max_capacity" class="form-control"/>
              </div>
            </form>
          </div>
          <div slot="modal-footer" class="modal-footer">
            <div class="form-group">
              <button :disabled="!isValid" class="btn btn-success" data-dismiss="modal" type="submit" v-if="!edit"
                      @click="AddNewBasket(newBasket)">Add Basket
              </button>
              <button :disabled="!isValid" class="btn btn-danger" data-dismiss="modal" type="submit" v-if="edit"
                      @click="EditBasket(newBasket.id)">Update Basket
              </button>
              <button type="button" class="btn btn-default" @click='showForm = false'>Exit</button>
            </div>
          </div>
        </modal>

        <div v-show="$route.path==='/basket'">
          <div class="list-group">
            <div class="list-group-item" v-for="(index, basket) in baskets">
                <div class="col-md-2"><strong>basket:</strong>
                  <br> {{ basket.attributes.name }}
                </div>
              <div class="col-md-4">
                <strong>contents: </strong>
                <br>

                <span class="col-md-10">
                  <span v-for="(index, item) in basket.attributes.contents.items">
                  <span class="col-md-12">
                    <span class="label label-default">
                      {{ item[0].type }}
                    </span>
                    <span class="label label-primary">
                      weight : {{ item[0].weight }}
                    </span>
                  </span>
                </span>
                </span>
                <span class="col-md-2">
                  <button class="btn btn-default" type="submit"
                          @click="GetBasketContent(basket)">+
                </button>
                </span>
              </div>

              <div class="col-md-3">
                <strong>max_capacity: </strong>
                <br>
                {{ basket.attributes.max_capacity }}
                <br>
                <span class="text-info"><strong>current weight: </strong>{{basket.attributes.current_basket_sum}}</span>
              </div>
              <div class="col-md-3">
                <strong>action: </strong>
                <br>
                <a @click="showEditBasket(basket.id)" class="btn btn-small btn-default pull-left"
                   role="button">Edit
                  Basket</a>
                <div class="edit" transition="getEdit" v-if="getEdit">
                  <div class="col-md-12">
                    <div class="alert alert-info" transition="succ" v-if="succ"> Edit Basket success
                    </div>
                  </div>
                </div>
                <button class="btn btn-danger btn-sm" @click="deleteBasket(basket)">Remove</button>
              </div>
                <div class="col-md-3" v-if="newBasket.length == 0">no data</div>
                <div class="clearfix"></div>
              </div>
            </div>
        </div>
        <pagination :pagination="pagination" nav-class="nav" size="pagination-sm" :callback="getCollection" :offset="2"></pagination>
      </div>
    </div>
  </div>

  <sidebar :show.sync="showContents" placement="right" header="Select Basket items" :width="500">
    Content items
    <alert
      :show.sync="isSideSuccess"
      :duration="4000"
      type="success"
      width="470px"
      placement="top-left"
      dismissable
    >
      <span class="icon-ok-circled alert-icon-float-left"></span>
      <strong>Well Done!</strong>
      <p>{{successSideMsg}}.</p>
    </alert>
    <alert
      :show.sync="isSideErrorAppeared"
      :duration="4000"
      type="danger"
      width="470px"
      placement="top-left"
      dismissable>
      <span class="icon-info-circled alert-icon-float-left"></span>
      <strong>Error appeared!</strong>
      <p>{{errorSideMsg}}</p>
    </alert>
    <bounce-loader v-if="showSideLoader" :loading="loading" :color="color" :size="size"></bounce-loader>
      <div class="row">
        <h3>{{ selectedBasket.attributes.max_capacity - items.attributes.current_basket_sum }}<span class="text-primary"> kgs free left in basket</span></h3>
        <div class="list-group">

          <div class="list-group-item" v-for="(index, item) in items.attributes.items.active">
            <div class="col-md-4">
              <span class="label label-info">in basket</span>
              <strong>item:</strong>
              <br> {{ item.type }}
            </div>
            <div class="col-md-4">
              <span class="col-md-12 text-center">
              <strong>weight: </strong>
              </span>
              <div class="clearfix"></div>
              <span class="col-md-12 text-center">
                    <h1 class="label label-primary">
                      <span class="text-default" style="color: white">weight</span> : <span class="badge">{{ item.weight }}</span> <strong>(kg)</strong>
                    </h1>
              </span>
            </div>
            <div class="col-md-4 text-right">
              <strong>action: </strong>
              <br>
              <button class="btn btn-danger btn-sm" @click="deleteItem(item)">Remove</button>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="list-group-item" v-for="(index, item) in items.attributes.items.non_active">
            <div class="col-md-4">
              <span class="label label-warning">not in basket</span>
              <strong>item:</strong>
              <br> {{ item.type }}
            </div>
            <div class="col-md-4">
              <span class="col-md-12 text-center">
              <strong>weight: </strong>
              </span>
              <div class="clearfix"></div>
              <span class="col-md-12 text-center">
                    <h1 class="label label-primary">
                      <span class="text-default" style="color: white">weight</span> : <span class="badge">{{ item.weight }}</span> <strong>(kg)</strong>
                    </h1>
              </span>
            </div>
            <div class="col-md-4 text-right">
              <strong>action: </strong>
              <br>
              <button class="btn btn-default" type="submit"
                      @click="addItem(item)">+ to basket
              </button>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="col-md-12" v-if="items.length == 0"><h3 class="text-warning">no data</h3></div>
      </div>
  </sidebar>

</template>
<script>
import BasketVM from '../components/ScriptsVM/BasketVM.js'
export default BasketVM()
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  h1 {
    /*color: #42b983;*/
  }
</style>
