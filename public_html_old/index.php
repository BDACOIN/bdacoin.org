﻿<!DOCTYPE html>
<!--nobanner-->
<html lang="en">
<?php
// 現在アクセスしてるフルURL
function GetCurrentURL() {
    return $_SERVER["HTTP_HOST"];
}

function GetPriorityLanguage() {
	$languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
	$languages = array_reverse($languages);
	 
	$result = '';
	 
	foreach ($languages as $language) {
		if (preg_match('/^ja/i', $language)) {
			$result = 'ja';
		} elseif (preg_match('/^en/i', $language)) {
			$result = 'en';
		} elseif (preg_match('/^zh/i', $language)) {
			$result = 'zh';
		}
	}
}



// 表示対象の言語(URL基準で決まる)
function GetCurrentLanguage() {
    $selfURL =  GetCurrentURL();

	if ( stripos($selfURL , "ja.") === 0 ) {
	   return "ja";
	} else if ( stripos($selfURL , "en.") === 0 ) {
	   return "en";
	}

    return "ja";
}

// Jsonを経由して、PHPハッシュデータとして取得
function GetLocalizeHash() {
	$localize_json = file_get_contents("./localize/localize.json");

	// BOM除去
	if (preg_match("/^efbbbf/", bin2hex($localize_json[0] . $localize_json[1] . $localize_json[2])) === 1) {
	    $localize_json = substr($localize_json, 3);
	}

	// 改行除去
	$localize_json = str_replace("\n", "", $localize_json );

	// UTF8としてデコード。
	$localize_json = mb_convert_encoding($localize_json, 'UTF8');

	// echo($localize_json);

	// JSONとしてデコード
	$localize_array = json_decode($localize_json, true);

	// あまりいい形ではないので、アクセスしやすいように整えておく。
	foreach($localize_array as $value) {
	    // echo($value["SIMBOL"]);
	    $localize_hash[$value["SIMBOL"]] = $value;
	}

    return $localize_hash;
}


$language = GetCurrentLanguage();

$localize_hash = GetLocalizeHash();

// echo($localize_hash["TOP_DETAIL_01"][$language]);
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="">
    <title>BLACK DIA COIN | <?php echo($language); ?></title>
    <meta name="description" content="BDA(BLACK DIA COIN) is a cryptocurrency token made to connect restaurant and customer.">
    <meta name="keywords" content="BDA,BLACK DIA COIN,CRYPTOCURRENCY,仮想通貨,ビットコイン,BITCOIN,イーサ,ETHEREUM,ETHER,ERC20,ERC223,AIRDROP,エアドロ">
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
    <!-- Custom styles for this template -->
    <link href="css/agency.css??v=201809100027" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./font-awesome/css/font-awesome-plugin.css?v=201809100249">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>
</head>
<body id="page-top">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" style="font-family: 'Droid Serif', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-style: italic;" href="#page-top"><i class="fa fa-bda4"></i>BLACK DIA</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ml-auto">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#about">ABOUT</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#whitepaper">WHITEPAPER</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#roadmap">ROADMAP</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#spec">SPEC</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#team">TEAM</a>
                    </li>
                    <li class="nav-item">
                        <?php
                        if ($language=="ja") {
                            echo("<a class='nav-link js-scroll-trigger' href='http://en.bdacoin.org'>ENGLISH</a>");
                        } else {
                            echo("<a class='nav-link js-scroll-trigger' href='http://ja.bdacoin.org'>JAPANESE</a>");
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Header -->
    <header class="masthead">
        <div class="container">
            <div class="intro-text">
                <div class="intro-lead-in"><i class="fa fa-bda4"></i>BLACK DIA COIN</div>
                <div class="intro-lead-detail">
                    <div style="font-size:0.8em"><?php echo($localize_hash["TOP_DETAIL_01"][$language]); ?></div>
                </div>
                <!-- a class="btn btn-primary btn-xl text-uppercase js-scroll-trigger" href="#about">もっと知る</a -->
            </div>
        </div>
    </header>
    <!-- Services -->
    <section id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading text-uppercase">ABOUT</h2>
                    <h3 class="section-subheading text-muted" style="font-size:1.3em">
                    <p class="block-left-txt">
                    <?php echo($localize_hash["ABOUT_DETAIL_01"][$language]); ?>
                    </p>
                    </h3>
                </div>
            </div>
        </div>
    </section>
    <!-- Whitepaper Grid -->
    <section class="bg-light" id="whitepaper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading text-uppercase">WHITEPAPER</h2>
                    <h3 class="section-subheading text-muted" style="font-size:1.3em"><a href="<?php echo($localize_hash["WHITEPAPER_LINK_01"][$language]); ?>" style="color:#bea106"><i class="fa fa-download"></i> <u><?php echo($localize_hash["WHITEPAPER_DOWNLOAD_01"][$language]); ?></u></a></h3>
                </div>
            </div>
        </div>
    </section>
    <!-- ReadMap -->
    <section id="roadmap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading text-uppercase">RoadMap</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
	                <div class="col-lg-12 text-center">
	                    <h2 class="section-heading text-uppercase">2018</h2>
	                </div>
                    <ul class="timeline">
                        <li class="timeline">
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="img/holding/01.png" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4><?php echo($localize_hash["ROADMAP_BORN_TIME"][$language]); ?></h4>
                                    <h4 class="subheading"><?php echo($localize_hash["ROADMAP_BORN_TITLE"][$language]); ?></h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">
                                    <?php echo($localize_hash["ROADMAP_BORN_DETAIL"][$language]); ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="img/holding/13.png" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4><?php echo($localize_hash["ROADMAP_CHARA_TIME"][$language]); ?></h4>
                                    <h4 class="subheading">
                                    <?php echo($localize_hash["ROADMAP_CHARA_TITLE"][$language]); ?>
                                    </h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">
                                    <?php echo($localize_hash["ROADMAP_CHARA_DETAIL"][$language]); ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline">
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="img/holding/03.png" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4><?php echo($localize_hash["ROADMAP_WHITEPAPER_TIME"][$language]); ?></h4>
                                    <h4 class="subheading">
                                    <?php echo($localize_hash["ROADMAP_WHITEPAPER_TITLE"][$language]); ?>
                                    </h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">
                                    <?php echo($localize_hash["ROADMAP_WHITEPAPER_DETAIL"][$language]); ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="img/holding/05.png" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4><?php echo($localize_hash["ROADMAP_COINSWAP_TIME"][$language]); ?></h4>
                                    <h4 class="subheading"><?php echo($localize_hash["ROADMAP_COINSWAP_TITLE"][$language]); ?></h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">
                                    <?php echo($localize_hash["ROADMAP_COINSWAP_DETAIL"][$language]); ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline">
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="img/holding/04.png" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4><?php echo($localize_hash["ROADMAP_FINANCE_TIME"][$language]); ?></h4>
                                    <h4 class="subheading"><?php echo($localize_hash["ROADMAP_FINANCE_TITLE"][$language]); ?></h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">
	                                <?php echo($localize_hash["ROADMAP_FINANCE_DETAIL"][$language]); ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="img/holding/09.png" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4><?php echo($localize_hash["ROADMAP_COINEXCHANGE_TITLE"][$language]); ?></h4>
                                    <h4 class="subheading"><?php echo($localize_hash["ROADMAP_COINEXCHANGE_TIME"][$language]); ?></h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted"><?php echo($localize_hash["ROADMAP_COINEXCHANGE_DETAIL"][$language]); ?></p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline">
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="img/holding/09.png" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4><?php echo($localize_hash["ROADMAP_OTHEREXCHANGE_TIME"][$language]); ?></h4>
                                    <h4 class="subheading"><?php echo($localize_hash["ROADMAP_OTHEREXCHANGE_TITLE"][$language]); ?></h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">
                                    <?php echo($localize_hash["ROADMAP_OTHEREXCHANGE_DETAIL"][$language]); ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
	                <div class="col-lg-12 text-center">
	                    <h2 class="section-heading text-uppercase">2019</h2>
	                </div>
                    <ul class="timeline">
                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="img/holding/12.png" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4><?php echo($localize_hash["ROADMAP_WALLET_TIME"][$language]); ?></h4>
                                    <h4 class="subheading"><?php echo($localize_hash["ROADMAP_WALLET_TITLE"][$language]); ?></h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">
                                    <?php echo($localize_hash["ROADMAP_WALLET_DETAIL"][$language]); ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline">
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="img/holding/10.png" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4><?php echo($localize_hash["ROADMAP_BAROPEN_TIME"][$language]); ?></h4>
                                    <h4 class="subheading"><?php echo($localize_hash["ROADMAP_BAROPEN_TITLE"][$language]); ?></h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">
                                    <?php echo($localize_hash["ROADMAP_BAROPEN_DETAIL"][$language]); ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="img/holding/12.png" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4><?php echo($localize_hash["ROADMAP_WALLET2_TIME"][$language]); ?></h4>
                                    <h4 class="subheading"><?php echo($localize_hash["ROADMAP_WALLET2_TITLE"][$language]); ?></h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">
                                    <?php echo($localize_hash["ROADMAP_WALLET2_DETAIL"][$language]); ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="img/holding/99.png" alt="">
                                <!--h4>
                                    <br>NEXT
                                    <br>
                                </h4-->
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- Allocation Grid -->
    <section class="bg-light" id="spec">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading text-uppercase">SPEC</h2>
                    <!--h3 class="section-subheading text-muted" style="font-size:1.3em">
                    <?php echo($localize_hash["SPEC_DETAIL_01"][$language]); ?>
                    </h3-->
                </div>
                <div class="col-sm-6" style="text-align:center">
                    <canvas id="CoinPortFolioGraph" style="height: 60vmin; width: 60vmin;"></canvas>
                </div>
                <div class="col-sm-6">
                    <div class="team-member" style="text-align:left">
                        <h4><?php echo($localize_hash["SPEC_TOKEN_TITLE"][$language]); ?></h4>
                        <div class="row">
                            <div class="col-sm-1">
                            </div>
                            <div class="col-sm-11">
                                <?php echo($localize_hash["SPEC_TOKEN_DETAIL"][$language]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="team-member" style="text-align:left">
                        <h4><?php echo($localize_hash["SPEC_DEVELOP_TITLE"][$language]); ?> <i class="fa fa-ellipsis-h"></i> 30%</h4>
                        <div class="row">
                            <div class="col-sm-1">
                            </div>
                            <div class="col-sm-11">
                                <?php echo($localize_hash["SPEC_DEVELOP_DETAIL"][$language]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="team-member" style="text-align:left">
                        <h4><?php echo($localize_hash["SPEC_SELLEXC_TITLE"][$language]); ?> <i class="fa fa-ellipsis-h"></i> 45%</h4>
                        <div class="row">
                            <div class="col-sm-1">
                            </div>
                            <div class="col-sm-11">
                                <?php echo($localize_hash["SPEC_SELLEXC_DETAIL"][$language]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="team-member" style="text-align:left">
                        <h4><?php echo($localize_hash["SPEC_MARKETING_TITLE"][$language]); ?> <i class="fa fa-ellipsis-h"></i> 15%</h4>
                        <div class="row">
                            <div class="col-sm-1">
                            </div>
                            <div class="col-sm-11">
                                <?php echo($localize_hash["SPEC_MARKETING_DETAIL"][$language]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="team-member" style="text-align:left">
                        <h4><?php echo($localize_hash["SPEC_TEAM_TITLE"][$language]); ?> <i class="fa fa-ellipsis-h"></i> 10%</h4>
                        <div class="row">
                            <div class="col-sm-1">
                            </div>
                            <div class="col-sm-11">
                                <?php echo($localize_hash["SPEC_TEAM_DETAIL"][$language]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row text-center">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h4 class="service-heading"></h4>
                    <p class="block-left-txt">
                        <span style="font-size:1.3em; color:#000000"><i class="fa fa-ether"></i> <?php echo($localize_hash["SPEC_ETHER_TOKEN_TITLE"][$language]); ?></span> <span style="font-size:1.0em;color:#000000">(ERC223)</span><span style="font-size:1.3em;"><br></span>
                        <?php echo($localize_hash["SPEC_ETHER_TOKEN_DETAIL_01"][$language]); ?>
                        <label style='width:65px'>Contract</label>：<br class="hidden-sm-up"><span class="contract">0xF6CaA4bebD8Fab8489bC4708344d9634315c4340</span><br>
                        <?php echo($localize_hash["SPEC_ETHER_TOKEN_DETAIL_02"][$language]); ?>
                    </p>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </section>
    <!-- Team -->
    <section id="team">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading text-uppercase">Team</h2>
                </div>
            </div>
            <!-- 12を対象のcol-sm-(数値)で割った値で分割する -->
            <div class="row">
                <div class="col-sm-4">
                    <div class="team-member">
                        <span class="fa-stack fa-4x">
                            <i class="fa fa-circle fa-stack-2x text-primary"></i>
                            <i class="fa fa-diamond fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4><?php echo($localize_hash["TEAM_MEMBER_BDA_TITLE"][$language]); ?></h4>
                        <p class="text-muted"><?php echo($localize_hash["TEAM_MEMBER_BDA_DETAIL"][$language]); ?></p>
	              <ul class="list-inline social-buttons">
	                <li class="list-inline-item">
	                  <a href="https://twitter.com/bda_dia">
	                    <i class="fa fa-twitter"></i>
	                  </a>
	                </li>
	                <li class="list-inline-item">
	                  <a href="https://www.facebook.com/BlackDiacoin-677002095997100/">
	                    <i class="fa fa-facebook"></i>
	                  </a>
	                </li>
	              </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <span class="fa-stack fa-4x">
                            <i class="fa fa-circle fa-stack-2x text-primary"></i>
                            <i class="fa fa-diamond fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4><?php echo($localize_hash["TEAM_MEMBER_KOMIYAMMA_TITLE"][$language]); ?></h4>
                        <p class="text-muted"><?php echo($localize_hash["TEAM_MEMBER_KOMIYAMMA_DETAIL"][$language]); ?></p>
	              <ul class="list-inline social-buttons">
	                <li class="list-inline-item">
	                  <a href="https://github.com/komiyamma">
	                    <i class="fa fa-github-alt"></i>
	                  </a>
	                </li>
	                <li class="list-inline-item">
	                  <a href="https://twitter.com/komiyamma">
	                    <i class="fa fa-twitter"></i>
	                  </a>
	                </li>
	              </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <span class="fa-stack fa-4x">
                            <i class="fa fa-circle fa-stack-2x text-primary"></i>
                            <i class="fa fa-diamond fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4><?php echo($localize_hash["TEAM_MEMBER_PAUL_TITLE"][$language]); ?></h4>
                        <p class="text-muted"><?php echo($localize_hash["TEAM_MEMBER_PAUL_DETAIL"][$language]); ?></p>
	              <ul class="list-inline social-buttons">
	                <li class="list-inline-item">
	                  <a href="https://twitter.com/lovealco2">
	                    <i class="fa fa-twitter"></i>
	                  </a>
	                </li>
	                <li class="list-inline-item">
	                  <a href="https://github.com/lovealco2">
	                    <i class="fa fa-github-alt"></i>
	                  </a>
	                </li>
	              </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <span class="fa-stack fa-4x">
                            <i class="fa fa-circle fa-stack-2x text-primary"></i>
                            <i class="fa fa-diamond fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4><?php echo($localize_hash["TEAM_MEMBER_TT_TITLE"][$language]); ?></h4>
                        <p class="text-muted"><?php echo($localize_hash["TEAM_MEMBER_TT_DETAIL"][$language]); ?></p>
	              <ul class="list-inline social-buttons">
	                <li class="list-inline-item">
	                  <a href="https://twitter.com/GekikaraNoodle">
	                    <i class="fa fa-twitter"></i>
	                  </a>
	                </li>
	                <li class="list-inline-item">
	                  <a href="https://github.com/tksw009">
	                    <i class="fa fa-github-alt"></i>
	                  </a>
	                </li>
	              </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <span class="fa-stack fa-4x">
                            <i class="fa fa-circle fa-stack-2x text-primary"></i>
                            <i class="fa fa-diamond fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4><?php echo($localize_hash["TEAM_MEMBER_RUPIN_TITLE"][$language]); ?></h4>
                        <p class="text-muted"><?php echo($localize_hash["TEAM_MEMBER_RUPIN_DETAIL"][$language]); ?></p>
	              <ul class="list-inline social-buttons">
	                <li class="list-inline-item">
	                  <a href="https://twitter.com/akiairdrop">
	                    <i class="fa fa-twitter"></i>
	                  </a>
	                </li>
	                <li class="list-inline-item">
	                  <a href="https://github.com/lupin68458">
	                    <i class="fa fa-github-alt"></i>
	                  </a>
	                </li>
	              </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <span class="fa-stack fa-4x">
                            <i class="fa fa-circle fa-stack-2x text-primary"></i>
                            <i class="fa fa-diamond fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4><?php echo($localize_hash["TEAM_MEMBER_TASHIRO_TITLE"][$language]); ?></h4>
                        <p class="text-muted"><?php echo($localize_hash["TEAM_MEMBER_TASHIRO_DETAIL"][$language]); ?></p>
	              <ul class="list-inline social-buttons">
	                <li class="list-inline-item">
	                  <a href="https://twitter.com/yazawanicoin">
	                    <i class="fa fa-twitter"></i>
	                  </a>
	                </li>
	                <li class="list-inline-item">
	                  <a href="https://github.com/tashiro12">
	                    <i class="fa fa-github-alt"></i>
	                  </a>
	                </li>
	              </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <span class="fa-stack fa-4x">
                            <i class="fa fa-circle fa-stack-2x text-primary"></i>
                            <i class="fa fa-diamond fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4><?php echo($localize_hash["TEAM_MEMBER_PAPARAZZI_TITLE"][$language]); ?></h4>
                        <p class="text-muted"><?php echo($localize_hash["TEAM_MEMBER_PAPARAZZI_DETAIL"][$language]); ?></p>
	              <ul class="list-inline social-buttons">
	                <li class="list-inline-item">
	                  <a href="https://twitter.com/rujakdulit">
	                    <i class="fa fa-twitter"></i>
	                  </a>
	                </li>
	                <li class="list-inline-item">
	                  <a href="https://www.facebook.com/rujak.dulit">
	                    <i class="fa fa-facebook"></i>
	                  </a>
	                </li>
	                <li class="list-inline-item">
	                  <a href="https://github.com/sinopsisfilm">
	                    <i class="fa fa-github-alt"></i>
	                  </a>
	                </li>
	              </ul>

                    </div>
                </div>
            </div>
            <!--div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <p class="large text-muted" style="font-size:1.0em">
                    <?php echo($localize_hash["TEAM_DETAIL_02"][$language]); ?>
                    </p>
                </div>
            </div-->
        </div>
    </section>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <span class="copyright">Copyright &copy; BLACK DIA COIN Team 2018</span>
                </div>
                <div class="col-md-6">
                    <ul class="list-inline social-buttons">
                        <li class="list-inline-item">
                            <a href="https://twitter.com/bda_dia">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://discord.gg/zcXbcbm">
                                <i class="fa fa-discord"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://www.facebook.com/BlackDiacoin-677002095997100/">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://github.com/BDACOIN">
                                <i class="fa fa-github-alt"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://t.me/joinchat/Gkw2Tk87hqPCjF1tmU-Vdg">
                                <i class="fa fa-telegram-alt"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Contact form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>
    <!-- Custom scripts for this template -->
    <script src="js/agency.min.js"></script>
    <script language="javascript">
        var dataLabelPlugin = {
            afterDatasetsDraw: function (chart, easing) {
                // To only draw at the end of animation, check for easing === 1
                var ctx = chart.ctx;

                chart.data.datasets.forEach(function (dataset, i) {
                    var dataSum = 0;
                    dataset.data.forEach(function (element) {
                        dataSum += element;
                    });

                    var meta = chart.getDatasetMeta(i);
                    if (!meta.hidden) {
                        meta.data.forEach(function (element, index) {
                            // Draw the text in black, with the specified font
                            ctx.fillStyle = 'rgb(255, 255, 255)';

                            var fontSize = 14;
                            var fontStyle = 'normal';
                            var fontFamily = 'Helvetica Neue';
                            ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

                            // Just naively convert to string for now
                            var labelString = chart.data.labels[index];
                            var dataString = (Math.round(dataset.data[index] / dataSum * 1000) / 10).toString() + "%";

                            // Make sure alignment settings are correct
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';

                            var padding = 5;
                            var position = element.tooltipPosition();
                            ctx.fillText(labelString, position.x, position.y - (fontSize / 2) - padding);
                            ctx.fillText(dataString, position.x, position.y + (fontSize / 2) - padding);
                        });
                    }
                });
            }
        };

        // Chart
        var myChart = "CoinPortFolioGraph";
        var chart = new Chart(myChart, {
            type: 'pie',
            data: {
                labels: ["<?php echo($localize_hash["SPEC_DEVELOP_TITLE"][$language]); ?>",
                         "<?php echo($localize_hash["SPEC_SELLEXC_TITLE"][$language]); ?>",
                         "<?php echo($localize_hash["SPEC_MARKETING_TITLE"][$language]); ?>",
                         "<?php echo($localize_hash["SPEC_TEAM_TITLE"][$language]); ?>"],
                datasets: [{
                    label: "",
                    backgroundColor: ["#3F51B5", "#F44336", "#FF9800", "#4CAF50"],
                    data: [30, 45, 15, 10],
                }]
            },
            options: {
                title: {
                    display: false,
                    text: "発行枚数 １兆枚"
                },
                legend: {
                    onClick: function(e) { return e.stopPropagation(); }
                },
                maintainAspectRatio: true,
            },
            plugins: [dataLabelPlugin],
        });
    </script>
</body>
</html>
