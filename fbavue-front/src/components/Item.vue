<template>
  <div id="ItemController">
    <div class="row">
      <button class="btn btn-small btn-default pull-left" role="button"
              @click="showCreateItem()"
      >Create Item
      </button>
    </div>

    <br>

    <div class="row">
      <router-view></router-view>
      <modal :show.sync="showForm" effect="zoom">
        <div slot="modal-header" class="modal-header">
          <h4 class="modal-title" v-if="edit">Edit the item</h4>
          <h4 class="modal-title" v-if="!edit">Add new item</h4>
        </div>
        <div slot="modal-body" class="modal-body" effect="zoom">
          <form action="#" @submit.prevent="AddNewItem" method="POST" novalidate>
            <div class="alert alert-danger" style="padding: 0; margin: 0">
            <ul>
            <li v-show="!validation.newItem.type">Name is not provided</li>
            <li v-show="!validation.newItem.weight">Weight is not provided in kg</li>
            </ul>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
              <label for="type">Type:</label>
              <input v-model="newItem.type" type="text" id="type" name="type" placeholder="type the type"
                     class="form-control">
            </div>
            <div class="form-group">
              <label for="weight">Weight:</label>
              <input v-model="newItem.weight" v-show="true" type="number" id="weight"
                     name="weight"
                     step="any"
                     v-text="newItem.weight | isDecimal "
                     placeholder="add the weight (in kg):" class="form-control">
              </div>
            <div class="form-group">
              <button :disabled="!isValid" class="btn btn-success" type="submit" v-if="!edit"
                      @click="AddNewItem(newItem)">Add Item
              </button>
              <button :disabled="isValid" class="btn btn-danger" type="submit" v-if="edit"
                      @click="EditItem(newItem.id)">Update Item
              </button>
            </div>
          </form>
        </div>
      </modal>
      <div v-show="$route.path==='/item'">
        <div class="list-group">
          <div class="list-group-item" v-for="(index, item) in items">
            <div class="col-md-4"><strong>item:</strong>
              <br> {{ item.attributes.type }}
              <span>
                  <button class="btn btn-default" type="submit"
                          @click="GetItemContent(item.id)">+
                </button>
              </span>
            </div>
            <div class="col-md-4">
              <span class="col-md-12 text-center">
              <strong>weight: </strong>
              </span>
              <div class="clearfix"></div>
              <span class="col-md-12 text-center">
                    <h1 class="label label-primary">
                      weight : <span class="badge">{{ item.attributes.weight }}</span> <strong>(kg)</strong>
                    </h1>
              </span>

            </div>
            <div class="col-md-4 text-right">
              <strong>action: </strong>
              <br>
              <a @click="showEditItem(item.id)" class="btn btn-small btn-default"
                 role="button">Edit
                Item</a>
              <div class="edit" transition="getEdit" v-if="getEdit">
                <div class="col-md-12">
                  <div class="alert alert-info" transition="succ" v-if="succ"> Edit Item success
                  </div>
                </div>
              </div>
              <button class="btn btn-danger btn-sm" @click="deleteItem(item)">Remove</button>
            </div>
            <div class="clearfix"></div>

          </div>
        </div>
      </div>
      <div class="col-md-12" v-if="items.length == 0"><h3 class="text-warning">no data</h3></div>
    </div>
  </div>


  <sidebar :show.sync="showContents" placement="right" header="Add item to Basket" :width="500">
    Existing Baskets
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
                          @click="AddItemToBasket(basket.id)">+
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
  </sidebar>
</template>
<style>

</style>
<script>
  import ItemVM from '../components/ScriptsVM/ItemVM.js'
  export default ItemVM.call()
</script>