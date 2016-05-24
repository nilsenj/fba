@extends('layouts.app')

@section('content')

	<div id="ArtikelController">

	<div class="col-md-4">
	<form action="#" @submit.prevent="AddNewUser" method="POST">

	<div class="alert alert-danger" v-if="!isValid">
		<ul>
			<li v-show="!validation.title">Title tidak boleh kosong </li>
			<li v-show="!validation.body">Body tidak boleh kosong </li>
			<li v-show="!validation.description">Description tidak boleh kosong</li>
		</ul>
		
	</div>
		
		<div class="form-group">
			<label for="title">Title:</label>
			<input v-model="newArtikel.title" type="text" id="title" name="title" placeholder="masukan title" class="form-control">
		</div>

		<div class="form-group">
			<label for="description">Description:</label>
			<input v-model="newArtikel.description" type="text" id="description" name="description" placeholder="masukan description" class="form-control">
		</div>

		<div class="form-group">
			<label for="body">Body:</label>
			<textarea v-model="newArtikel.body" name="body" id="body" class="form-control"></textarea>
		</div>

		<div class="form-group">
			<button :disabled="!isValid" class="btn btn-success" type="submit"  v-if="!edit">Add Artikel</button>
			<button :disabled="!isValid" class="btn btn-danger" type="submit" v-if="edit" @click="EditArtikel(newArtikel.id)">Update Artikel</button>
		</div>

	</form>
	</div>

	<div class="col-md-8">

	<div class="alert alert-success" transition="success" v-if="success">Add new artikel success
	</div>

	<div class="alert alert-danger" transition="succ" v-if="succ"> Edit Artikel success
	</div>

	<div class="alert alert-danger" transition="remove" v-if="remove"> Delete Artikel success
	</div>

	<div class="row">
	  <table class="table table-bordered table-hover">
	  	<thead>
	  		<tr>
	  			<th>id</th>
	  			<th>title</th>
	  			<th>description</th>
	  			<th>body</th>
	  			{{-- <th>Update_at</th>
	  			<th>Create_at</th> --}}
	  			<th>action</th>
	  		</tr>
	  	</thead>
	  	<tbody>
	  		<tr v-for="(index, artikel) in artikels">
	  			{{-- <td>@{{ index }}</td> --}}
	  			<td>@{{ artikel.id }}</td>
	  			<td>@{{ artikel.title }}</td>
	  			<td>@{{ artikel.description }}</td>
	  			<td>@{{ artikel.body }}</td>
	  			{{-- <td>@{{ artikel.updated_at}}</td>
	  			<td>@{{ artikel.created_at}}</td> --}}
	  			<td>
	  				<button class="btn btn-default btn-sm" v-on:click="ShowArtikel(artikel.id)">Edit</button>
					<button class="btn btn-danger btn-sm" v-on:click="RemoveArtikel(artikel.id)">Remove</button>
	  			</td>
	  			 <div v-if="newArtikel.length -- 0">no data</div>

	  		</tr>
	  	</tbody>
	  </table>
	   <pagination :pagination="pagination" :callback="getData" :offset="3"></pagination>
	  </div>
	</div>
</div>
	
@endsection

@push('scripts')
	
	{!! Html::script('/js/app.js')	!!}

@endpush