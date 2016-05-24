<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		{{-- <meta name="token" id="token" value="{{ csrf_token() }}"> --}}
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Title Page</title>

		<!-- Bootstrap CSS -->
		{!! Html::style('/loading/vue-loading-bar.css')!!}
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<style>
		.success-transition {
			transition: all .5s ease-in-out;
		}
		.success-enter, .success-leave {
			opacity: 0;
		}
	</style>


	</head>
	<body>
	<loading-bar :progress.sync="progress" :direction="direction ? 'left' : 'right'" :error.sync="error"></loading-bar>
	<div class="main">
		<h1 align="center">Vue JS</h1>
	</div>
	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/')}}">CRUD VUE LARAVEL5.2</a>
			</div>
	
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
				</ul>
				
			</div><!-- /.navbar-collapse -->
		</div>
	</nav>
		
		<div class="container">
			@yield('content')
		</div>

		

		{!! Html::script('/js/vue.min.js')	!!}
		{!! Html::script('/js/vue-resource.js')	!!}
		{!! Html::script('/loading/vue-loading-bar.min.js')!!}
		{!! Html::script('/js/vue-bootstrap-pagination.js')!!}
		

		
		@stack('scripts')
		<script>
		new Vue({
			el: 'body',
			data: function(){
				return {
					progress: 0,
					status: "doesn't start yet",
					error: false,
					direction: false
				};
			},
			methods: {
				progressTo: function(val){
					this.progress = val;
				},
				setToError: function(bol){
					this.error = bol;
					this.status = "Error";
				},
				changeDirection: function(direction){
					if(this.progress > 0){
						this.progress = 100;
					}
					this.direction = !this.direction;
				}
			},
			events: {
				/**
				*	Global Loading Callback Event
				*
				*	@event-name loading-bar:{event-name}
				*/
				// Loading Bar on started
				'loading-bar:started': function (){
					console.log('started');
					this.status = "started";
				},
				// Loading Bar on loading
				'loading-bar:loading': function (){
					console.log('loading');
					this.status = "loading";
				},
				// Loading Bar on loaded
				'loading-bar:loaded': function (){
					console.log('loaded');
					this.status = "loaded";
				},
				// Loading Bar on error
				'loading-bar:error': function (){
					console.log('error');
					this.status = "error";
				},
			},
			ready: function(){
				var self = this;
					self.progress = 10;
					for (var i = 0; i < 30; i++) {
						if(i > 20 && i < 29){
							setTimeout(function () {
								self.progress += 5;
							},50*i);
						}else{
							setTimeout(function () {
								self.progress ++;
							},10*i);
						}
					}
					setTimeout(function () {
						self.progress = 100;
					},1500);
			}
		});

	</script>




		<script src="http://code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		
	</body>
</html>