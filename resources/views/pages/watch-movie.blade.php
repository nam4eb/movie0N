@extends('layout')
@section('content')

<div class="container">
	<div class="row">
		<div class="main-watch-detail text-center">
			<div class="media-player box-player" id="media-player-box" data-thumbnail="https://cdn.statically.io/img/img.zingvntv.net/uploads/2016/05/625131-vo-si-gi-87372.jpg" data-poster="https://img.zingvntv.net/uploads/2016/05/838626-gladiator-2000_20441374547358.jpg"><div class="btn-server-in-jwplayer p2p-ios-quality" style="position:absolute;top: 8px;left: 8px;padding: 4px 2px;border-radius:3px;background:rgba(0, 0, 0, 0.5);z-index: 11;"><label title="Show Server" style="background: url(/wp-content/themes/jwplayer/icon/server.png) no-repeat center center;background-size: 100%;font-size: 10px;padding: 5px 10px;margin: 0 5px;display: inline;cursor:copy;"></label></div> <div id="media-player" class="jwplayer jw-reset jw-state-paused jw-stretch-uniform jw-flag-aspect-mode jw-breakpoint-4 jw-floating-dismissible jw-flag-ads jw-flag-user-inactive" tabindex="0" aria-label="Trình phát video" role="application" style="width: 100%;"><iframe a="end" class="mb-iframe" onload="countViewSSB()" src="https://short.ink/1f10Q2O8r" frameborder="0" scrolling="no" allowfullscreen=""></iframe></div> <div id="preroll-player"></div> <div class="loading-container"> <div class="loading-player jw-icon"></div> </div> </div>
			<div class="feature d-flex">
				<div class="col-6 text-left">
					<button class="btn btn-outline-light"><i class="fas fa-expand-arrows-alt"></i> Expand</button>
					<button class="btn btn-outline-light"><i class="fas fa-share-alt"></i> Share</button>
				</div>
				<div class="col-6 text-right">
					<button class="btn btn-outline-light"><i class="fas fa-ban"></i> Block Ads</button>
					<button class="btn btn-outline-light"><i class="fas fa-step-forward"></i> Next</button>
					<button class="btn btn-outline-light"><i class="fa fa-warning"></i> Report</button>
				</div>
			</div>
			<div class="server d-flex">
				<h4><i class="fas fa-database"></i> Server</h4>
				<button class="btn btn-outline-light ml-4">#HK</button>
				<button class="btn btn-outline-light">#JP</button>
				<button class="btn btn-outline-light">#SING</button>
				<button class="btn btn-outline-light">#TW</button>
			</div>
			<div class="episode d-flex">
				<h4><i class="far fa-list-alt"></i> Episode</h4>
				<button class="btn btn-outline-light ml-4">1</button>
				<button class="btn btn-outline-light">2</button>
				<button class="btn btn-outline-light">3</button>
				<button class="btn btn-outline-light">4</button>
				<button class="btn btn-outline-light">5</button>
				<button class="btn btn-outline-light">6</button>
			</div>
			<div class="desc">
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
				<hr>
				<div class="d-flex mt-4 mb-4">
					<div class="col-2">
						<img src="img/ads3.png" alt="" width="100%">
					</div>
					<div class="desc-content col-10 text-left">
						<h2>Story of Our Life (2000)</h2>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iste tempora veniam commodi iusto laboriosam nostrum, impedit, fuga explicabo debitis hic enim ad facere. Cupiditate alias sunt iusto consequatur placeat!
						<br>
						Lorem ipsum dolor sit amet, consectetur, adipisicing elit. Harum facere, voluptates molestiae tempora voluptas, doloribus.</p>
					</div>
				</div>
			</div>
			<hr>
			<div class="review">

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
</div>

@endsection
