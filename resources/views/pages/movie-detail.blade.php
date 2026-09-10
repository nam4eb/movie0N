@extends('layout')
@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="movie-main-content">
			<div class="container d-flex">
				<div class="col-7 text-left">
					<h1>Story of Our Life (2000)</h1>
					<div class="d-flex">
						<div class="rate d-flex">
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star-half"></i>
							<p>4.9(Imdb)</p>
						</div>
						<div class="time ml-3">
							<p>2hr:29mins</p>
						</div>
					</div>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perspiciatis nulla quos, nihil veniam, qui eveniet. Blanditiis temporibus eligendi nam, amet, dicta ipsam magni quia necessitatibus itaque sequi, sed atque!</p>
					<ul>
						<li><span>Starring:</span> You guys</li>
						<li><span>Genres:</span> Adventure</li>
						<li><span>Tag:</span> Action, Adventure, Comedy</li>
					</ul>
					<a href="{{URL::to('watch-movie')}}"><button class="btn btn-outline-light"><i class="fas fa-play mr-2"></i>Play now</button></a>
				</div>
				<div class="col-5 text-right">
					<a href="">
						<h1><i class="far fa-play-circle mr-3"></i>Watch trailer</h1>
					</a>
				</div>
			</div>

		</div>
		<div class="container">
			<div class="movie-relate">
				<div class="d-flex">
					<div class="movie-info col-3">
						<img src="img/wall-e.jpg" alt="">
						<div class="movie-name">
							<h2>Wall-e</h2>
							<h4>(2009)</h4>
						</div>
						<div class="movie-feature d-flex">
							<button class="btn btn-md btn-light"><a href="index.php?module=movie-detail">Watch <i class="fas fa-play"></i></a></button>
							<button class="btn btn-md btn-danger"><i class="far fa-heart"></i></button>
							<button class="btn btn-md btn-success">Add list <i class="far fa-plus-square"></i></button>
						</div>
					</div>
					<div class="movie-info col-3">
						<img src="img/star-wars.jpg" alt="">
						<div class="movie-name">
							<h2>Star wars</h2>
							<h4>(1973)</h4>
						</div>
						<div class="movie-feature d-flex">
							<button class="btn btn-md btn-light"><a href="index.php?module=movie-detail">Watch <i class="fas fa-play"></i></a></button>
							<button class="btn btn-md btn-success">Add list <i class="far fa-plus-square"></i></button>
							<button class="btn btn-md btn-danger"><i class="far fa-heart"></i></button>
						</div>
					</div>
					<div class="movie-info col-3">
						<img src="img/peaky-blinders.jpg" alt="">
						<div class="movie-name">
							<h2>Peaky blinders</h2>
							<h4>(2015)</h4>
						</div>
						<div class="movie-feature d-flex">
							<button class="btn btn-md btn-light"><a href="index.php?module=movie-detail">Watch <i class="fas fa-play"></i></a></button>
							<button class="btn btn-md btn-success">Add list <i class="far fa-plus-square"></i></button>
							<button class="btn btn-md btn-danger"><i class="far fa-heart"></i></button>
						</div>
					</div>
					<div class="movie-info col-3">
						<img src="img/arcane.jpg" alt="">
						<div class="movie-name">
							<h2>Arcane</h2>
							<h4>(2021)</h4>
						</div>
						<div class="movie-feature d-flex">
							<button class="btn btn-md btn-light"><a href="index.php?module=movie-detail">Watch <i class="fas fa-play"></i></a></button>
							<button class="btn btn-md btn-success">Add list <i class="far fa-plus-square"></i></button>
							<button class="btn btn-md btn-danger"><i class="far fa-heart"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
