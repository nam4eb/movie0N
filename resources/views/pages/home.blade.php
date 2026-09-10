@extends('layout')
@section('content')

<div id="main">
		<div class="col-9 main-body">
			<div class="favorite-movie">
				<div id="myCarousel" class="carousel slide" data-ride="carousel">
					<div class="carousel-inner">
						<div class="item active">
							<img src="img/fav-film-1.jpg" alt="">
							<div class="carousel-caption joker text-left">
								<div class="col-6">
									<h4><u>Top favorite movie in this month</u> <i class="glyphicon glyphicon-fire"></i></h4>
									<p>JOKER</p>
									<h3>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ad eaque quisquam, officia sunt nesciunt, quas nobis amet natus nemo vel explicabo aliquid nam, numquam est expedita totam quasi porro.</h3>
									<div class="d-flex">
										<a href="{{URL::to('movie-detail')}}"><button class="btn btn-lg btn-light">Play</button></a>
										<button class="btn btn-lg btn-dark">Add your library</button>
									</div>
								</div>
							</div>
						</div>
						<div class="item">
							<img src="{{asset('img/fav-film-2.jpg')}}" alt="">
							<div class="carousel-caption godfather text-right d-flex">
								<div class="col-5"></div>
								<div class="col-7">
									<h4><u>Top favorite movie in this month</u> <i class="glyphicon glyphicon-fire"></i></h4>
									<h3>Lorem ipsum, dolor, sit amet consectetur adipisicing elit. Quam fuga laudantium suscipit cumque laboriosam voluptatem!</h3>
									<div class="d-flex">
									<a href="index.php?module=movie-detail"><button class="btn btn-lg btn-light">Play</button></a>
										<button class="btn btn-lg btn-dark">Add your library</button>
									</div>
								</div>

							</div>
						</div>
						<div class="item">
							<img src="{{asset('img/fav-film-3.png')}}" alt="">
							<div class="carousel-caption spirderman">
								<h4><u>Top favorite movie in this month</u> <i class="glyphicon glyphicon-fire"></i></h4>
								<p>SPIDERMAN</p>
								<h3>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Modi non commodi veritatis repudiandae quae quod dicta, vero nesciunt aut nam aspernatur consectetur iure, odio quia saepe libero veniam ut rerum. Incidunt, quo accusamus nisi, quisquam qui asperiores voluptate id quos.</h3>
								<div class="d-flex justify-content-center">
									<a href="index.php?module=movie-detail"><button class="btn btn-lg btn-light">Play</button></a>
									<button class="btn btn-lg btn-dark">Add your library</button>
								</div>
							</div>
						</div>
						<div class="item">
							<img src="{{asset('img/fav-film-4.jpg')}}" alt="">
							<div class="carousel-caption lotr">
								<h4><u>Top favorite movie in this month</u> <i class="glyphicon glyphicon-fire"></i></h4>
								<p>LORD OF THE RING</p>
								<h3>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae nulla, maxime, cupiditate dicta, accusantium recusandae magni aliquam, at cumque mollitia rem eaque tempore distinctio quaerat.</h3>
								<div class="d-flex justify-content-center">
									<a href="index.php?module=movie-detail"><button class="btn btn-lg btn-light">Play</button></a>
									<button class="btn btn-lg btn-dark">Add your library</button>
								</div>
							</div>
						</div>
						<div class="item">
							<img src="{{asset('img/fav-film-5.jpg')}}" alt="">
							<div class="carousel-caption harry text-left">
								<div class="col-6">
									<h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Error at quae qui, dolorum rerum ipsa, natus ad beatae, tenetur dolor eaque minus omnis aut, pariatur blanditiis quibusdam perferendis voluptates.</h3>
									<div class="d-flex">
										<button class="btn btn-lg btn-light">Play</button>
										<button class="btn btn-lg btn-dark">Add your library</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container movie-list">
				<h2>TOP MOVIE THIS WEEK <i class="glyphicon glyphicon-fire"></i></h2>
				<div class="d-flex">
					<div class="movie-info col-3">
						<img src="img/wall-e.jpg" alt="">
						<div class="movie-name">
							<h2>Wall-e</h2>
							<h4>(2009)</h4>
						</div>
						<div class="movie-feature d-flex">
							<button class="btn btn-md btn-light"><a href="index.php?module=movie-detail">Watch <i class="fas fa-play"></i></a></button>
							<button class="btn btn-md btn-success">Add list <i class="far fa-plus-square"></i></button>
							<button class="btn btn-md btn-danger"><i class="far fa-heart"></i></button>
						</div>
					</div>
					<div class="movie-info col-3">
						<img src="{{asset('img/captain-america.jpg')}}" alt="">
						<div class="movie-name">
							<h2>Captain America</h2>
							<h4>(2017)</h4>
						</div>
						<div class="movie-feature d-flex">
							<button class="btn btn-md btn-light"><a href="index.php?module=movie-detail">Watch <i class="fas fa-play"></i></a></button>
							<button class="btn btn-md btn-success">Add list <i class="far fa-plus-square"></i></button>
							<button class="btn btn-md btn-danger"><i class="far fa-heart"></i></button>
						</div>
					</div>
					<div class="movie-info col-3">
						<img src="img/interstellar.jpg" alt="">
						<div class="movie-name">
							<h2>Interstellar</h2>
							<h4>(2015)</h4>
						</div>
						<div class="movie-feature d-flex">
							<button class="btn btn-md btn-light"><a href="index.php?module=movie-detail">Watch <i class="fas fa-play"></i></a></button>
							<button class="btn btn-md btn-success">Add list <i class="far fa-plus-square"></i></button>
							<button class="btn btn-md btn-danger"><i class="far fa-heart"></i></button>
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
				</div>
			</div>
			<div class="container tv-series">
				<h2>TOP TV SERIES THIS WEEK <i class="glyphicon glyphicon-fire"></i></h2>
				<div class="d-flex">
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
					<div class="movie-info col-3">
						<img src="img/the-boys.jpg" alt="">
						<div class="movie-name">
							<h2>The boys</h2>
							<h4>(2019)</h4>
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
						<img src="img/sherlock-holmes.jpg" alt="">
						<div class="movie-name">
							<h2>Sherlock holmes</h2>
							<h4>(2016)</h4>
						</div>
						<div class="movie-feature d-flex">
							<button class="btn btn-md btn-light"><a href="index.php?module=movie-detail">Watch <i class="fas fa-play"></i></a></button>
							<button class="btn btn-md btn-success">Add list <i class="far fa-plus-square"></i></button>
							<button class="btn btn-md btn-danger"><i class="far fa-heart"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div class="container korean-tv-series">
				<h2>TOP KOREAN TV SERIES THIS WEEK <i class="glyphicon glyphicon-fire"></i></h2>
				<div class="d-flex">
					<div class="movie-info col-3">
						<img src="img/squid-game.jpg" alt="">
						<div class="movie-name">
							<h2>Squid Game</h2>
							<h4>(2021)</h4>
						</div>
						<div class="movie-feature d-flex">
							<button class="btn btn-md btn-light"><a href="index.php?module=movie-detail">Watch <i class="fas fa-play"></i></a></button>
							<button class="btn btn-md btn-success">Add list <i class="far fa-plus-square"></i></button>
							<button class="btn btn-md btn-danger"><i class="far fa-heart"></i></button>
						</div>
					</div>
					<div class="movie-info col-3">
						<img src="img/vagabond.jpg" alt="">
						<div class="movie-name">
							<h2>Vagabond</h2>
							<h4>(2020)</h4>
						</div>
						<div class="movie-feature d-flex">
							<button class="btn btn-md btn-light"><a href="index.php?module=movie-detail">Watch <i class="fas fa-play"></i></a></button>
							<button class="btn btn-md btn-success">Add list <i class="far fa-plus-square"></i></button>
							<button class="btn btn-md btn-danger"><i class="far fa-heart"></i></button>
						</div>
					</div>
					<div class="movie-info col-3">
						<img src="img/vincenzo.jpg" alt="">
						<div class="movie-name">
							<h2>Vincenzo</h2>
							<h4>(2019)</h4>
						</div>
						<div class="movie-feature d-flex">
							<button class="btn btn-md btn-light"><a href="index.php?module=movie-detail">Watch <i class="fas fa-play"></i></a></button>
							<button class="btn btn-md btn-success">Add list <i class="far fa-plus-square"></i></button>
							<button class="btn btn-md btn-danger"><i class="far fa-heart"></i></button>
						</div>
					</div>
					<div class="movie-info col-3">
						<img src="img/itewon-class.jpg" alt="">
						<div class="movie-name">
							<h2>Itewon class</h2>
							<h4>(2018)</h4>
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
		<div class="col-3 right-body">
			<div class="movie-coming-soon">
				<h1>Movie coming soon <i class="fab fa-algolia"></i></h1>
				<div class="movie-info">
					<img src="img/black-panther.jpg" alt="">
					<div class="content-info">
						<h2><a href="">BlackPanther: Wakanda forever</a></h2>
						<h4>(13/07/2022)</h4>
					</div>
				</div>
				<div class="movie-info">
					<img src="img/avatar.jpg" alt="">
					<div class="content-info">
						<h2><a href="">Avatar 2</a></h2>
						<h4>(16/12/2022)</h4>
					</div>
				</div>
				<div class="movie-info">
					<img src="img/thor.jpg" alt="">
					<div class="content-info">
						<h2><a href="">Thor 3: Love and thunder</a></h2>
						<h4>(22/10/2022)</h4>
					</div>
				</div>
				<div class="movie-info">
					<img src="img/dr-stranger.jpg" alt="">
					<div class="content-info">
						<h2><a href="">Doctor Stranger 3</a></h2>
						<h4>(06/07/2022)</h4>
					</div>
				</div>
				<div class="movie-info">
					<img src="img/spiderman.png" alt="">
					<div class="content-info">
						<h2><a href="">Spiderman 2: Across the spiderverse</a></h2>
						<h4>(02/09/2022)</h4>
					</div>
				</div>
			</div>
			<div class="ads">
				<img src="img/ads3.png" alt="">
			</div>
			<div class="your-movie-list">
				<h1>Your movie's list <i class="fas fa-list-alt"></i></h1>
				<div class="movie-info">
					<img src="img/dune.jpg" alt="">
					<div class="content-info">
						<h2><a href="">Dune</a></h2>
						<h4>(16/04/2021)</h4>
					</div>
				</div>
				<div class="movie-info">
					<img src="img/alien.jpg" alt="">
					<div class="content-info">
						<h2><a href="">Alien</a></h2>
						<h4>(27/06/2017)</h4>
					</div>
				</div>
				<div class="movie-info">
					<img src="img/man-of-steel.jpg" alt="">
					<div class="content-info">
						<h2><a href="">Man of steel</a></h2>
						<h4>(21/12/2012)</h4>
					</div>
				</div>
				<div class="movie-info">
					<img src="img/the-hobbit.jpg" alt="">
					<div class="content-info">
						<h2><a href="">The hobbit</a></h2>
						<h4>(23/09/2018)</h4>
					</div>
				</div>
				<div class="movie-info">
					<img src="img/avenger.jpg" alt="">
					<div class="content-info">
						<h2><a href="">Avenger: Endgame</a></h2>
						<h4>(22/10/2020)</h4>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
