<!DOCTYPE html>
<!--nobanner-->
<?php
// 現在アクセスしてるフルURL
function GetCurrentURL() {
    return $_SERVER["HTTP_HOST"];
}

function ua_smt () {
    //ユーザーエージェントを取得
    $ua = $_SERVER['HTTP_USER_AGENT'];
    //スマホと判定する文字リスト
    $ua_list = array('iPhone','iPad','iPod','Android');
    foreach ($ua_list as $ua_smt) {
        //ユーザーエージェントに文字リストの単語を含む場合はTRUE、それ以外はFALSE
        if (strpos($ua, $ua_smt) !== false) {
            return true;
        }
    }

    return false;
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
<html lang="<?php echo($language); ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>BLACK DIA COIN | <?php echo($language); ?></title>
<meta name="description" content="BDA(BLACK DIA COIN) is a cryptocurrency token made to connect restaurant and customer.">
<meta name="keywords" content="BDA,BLACK DIA COIN,CRYPTOCURRENCY,仮想通貨,ビットコイン,BITCOIN,イーサ,ETHEREUM,ETHER,ERC20,ERC223,AIRDROP,エアドロ">

<!-- Favicons
    ================================================== -->
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
<link rel="apple-touch-icon" href="img/apple-touch-icon.png">

<!-- Bootstrap -->
<link rel="stylesheet" type="text/css"  href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">

<!-- Stylesheet
    ================================================== -->
<?php if(ua_smt()){echo('<link rel="stylesheet" type="text/css"  href="css/style_phone.css?v=2.0">' . "\n");} else {echo('<link rel="stylesheet" type="text/css"  href="css/style_pc.css">' . "\n");} ?>
<link rel="stylesheet" type="text/css"  href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/nivo-lightbox/nivo-lightbox.css">
<link rel="stylesheet" type="text/css" href="css/nivo-lightbox/default.css">
<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Anton">


<link rel="stylesheet" type="text/css" href="./font-awesome/css/font-awesome-plugin.css?v=201809100249">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>

</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<!-- Navigation
    ==========================================-->
<nav id="menu" class="navbar navbar-default navbar-fixed-top">
  <div class="container"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand page-scroll" href="#page-top"><i class="fa fa-bda4"></i>BLACK DIA</a></div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#about" class="page-scroll">About</a></li>
        <li><a href="#about" class="page-scroll">WhitePaper</a></li>
        <li><a href="#restaurant-roadmap" class="page-scroll">RoadMap</a></li>
        <li><a href="#restaurant-spec" class="page-scroll">Spec</a></li>
        <li><a href="#team" class="page-scroll">TEAM</a></li>
        <li>
            <?php
            $selfURL =  GetCurrentURL();
            if ( stripos($selfURL , "test.") === FALSE ) {
                if ($language=="ja") {
                    echo("<a class='nav-link js-scroll-trigger' href='http://en.bdacoin.org'>ENGLISH</a>");
                } else {
                    echo("<a class='nav-link js-scroll-trigger' href='http://ja.bdacoin.org'>JAPANESE</a>");
                }
            } else {
                if ($language=="ja") {
                    echo("<a class='nav-link js-scroll-trigger' href='http://en.test.bdacoin.org'>ENGLISH</a>");
                } else {
                    echo("<a class='nav-link js-scroll-trigger' href='http://ja.test.bdacoin.org'>JAPANESE</a>");
                }
            }
            ?>
        </li>
      </ul>
    </div>
    <!-- /.navbar-collapse --> 
  </div>
</nav>
<!-- Header -->
<header id="header">
  <div class="intro text-center center">
	  <div class="section-title text-center center">
      <div class="intro-text">
          <h1><i class="fa fa-bda4"></i>BLACK DIA COIN<br></h1>
	      <p><?php echo($localize_hash["TOP_DETAIL_01"][$language]); ?></p>
	    </div>
	  </div>
  </div>
</header>
<!-- About Section -->
<div id="about">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-6 ">
        <div class="about-img"><img src="img/about.jpg" class="img-responsive" alt=""></div>
        <br>
        <br>
      </div>
      <div class="col-xs-12 col-md-6">
        <div class="about-text">
          <h2>ABOUT</h2>
          <hr>
          <p>
               <?php echo($localize_hash["ABOUT_DETAIL_01"][$language]); ?>
	  </p>
          <h3>WHITEPAPER</h3>
          <p><a href="<?php echo($localize_hash["WHITEPAPER_LINK_01"][$language]); ?>" style="color:#bea106"><i class="fa fa-download"></i> <u><?php echo($localize_hash["WHITEPAPER_DOWNLOAD_01"][$language]); ?></u></a></p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Restaurant RoadMap Section -->
<div id="restaurant-roadmap">
  <div class="section-title text-center center">
    <div class="overlay">
      <h2>RoadMap</h2>
      <hr>
      <p><?php echo($localize_hash["ROADMAP_DETAIL_01"][$language]); ?></p>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-6">
        <div class="roadmap-section">
          <h2 class="roadmap-section-title">2018</h2>
          <h4 class="roadmap-subsection-title"><?php echo($localize_hash["ROADMAP_BORN_TERM_01"][$language]); ?></h4>
          <hr>
          <!--div class="menu-images"><img src="img/menu/beer.png" alt="Hot Drinks"></div-->
          <div class="roadmap-item">
            <div class="roadmap-item-name"><?php echo($localize_hash["ROADMAP_BORN_TITLE"][$language]); ?></div>
            <div class="roadmap-item-price"><?php echo($localize_hash["ROADMAP_BORN_TIME"][$language]); ?></div>
            <div class="roadmap-item-description"><?php echo($localize_hash["ROADMAP_BORN_DETAIL"][$language]); ?></div>
          </div>
          <div class="roadmap-item">
            <div class="roadmap-item-name"><?php echo($localize_hash["ROADMAP_CHARA_TITLE"][$language]); ?></div>
            <div class="roadmap-item-price"><?php echo($localize_hash["ROADMAP_CHARA_TIME"][$language]); ?></div>
            <div class="roadmap-item-description"><?php echo($localize_hash["ROADMAP_CHARA_DETAIL"][$language]); ?></div>
          </div>
          <div class="roadmap-item">
            <div class="roadmap-item-name"><?php echo($localize_hash["ROADMAP_WHITEPAPER_TITLE"][$language]); ?></div>
            <div class="roadmap-item-price"><?php echo($localize_hash["ROADMAP_WHITEPAPER_TIME"][$language]); ?></div>
            <div class="roadmap-item-description"><?php echo($localize_hash["ROADMAP_WHITEPAPER_DETAIL"][$language]); ?></div>
          </div>
          <div class="roadmap-item">
            <div class="roadmap-item-name"><?php echo($localize_hash["ROADMAP_COINSWAP_TITLE"][$language]); ?></div>
            <div class="roadmap-item-price"><?php echo($localize_hash["ROADMAP_COINSWAP_TIME"][$language]); ?></div>
            <div class="roadmap-item-description"><?php echo($localize_hash["ROADMAP_COINSWAP_DETAIL"][$language]); ?></div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6">
        <div class="roadmap-section">
          <h2 class="roadmap-section-title">2018</h2>
          <h4 class="roadmap-subsection-title"><?php echo($localize_hash["ROADMAP_BORN_TERM_02"][$language]); ?></h4>
          <hr>
          <!--div class="menu-images"><img src="img/menu/beer.png" alt="Hot Drinks"></div-->
          <div class="roadmap-item">
            <div class="roadmap-item-name"><?php echo($localize_hash["ROADMAP_FINANCE_TITLE"][$language]); ?></div>
            <div class="roadmap-item-price"><?php echo($localize_hash["ROADMAP_FINANCE_TIME"][$language]); ?></div>
            <div class="roadmap-item-description"><?php echo($localize_hash["ROADMAP_FINANCE_DETAIL"][$language]); ?></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-6">
        <div class="roadmap-section">
          <h2 class="roadmap-section-title"><?php echo($localize_hash["ROADMAP_BORN_TERM_03"][$language]); ?></h2>
          <hr>
          <div class="roadmap-item">
            <div class="roadmap-item-name"><?php echo($localize_hash["ROADMAP_COINEXCHANGE_TITLE"][$language]); ?></div>
            <div class="roadmap-item-price"><?php echo($localize_hash["ROADMAP_COINEXCHANGE_TIME"][$language]); ?></div>
            <div class="roadmap-item-description"><?php echo($localize_hash["ROADMAP_COINEXCHANGE_DETAIL"][$language]); ?></div>
          </div>
          <div class="roadmap-item">
            <div class="roadmap-item-name"><?php echo($localize_hash["ROADMAP_MOREEXCHANGE_TITLE"][$language]); ?></div>
            <div class="roadmap-item-description"><?php echo($localize_hash["ROADMAP_MOREEXCHANGE_DETAIL"][$language]); ?></div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6">
        <div class="roadmap-section">
          <h2 class="roadmap-section-title">Next</h2>
          <hr>
          <div class="roadmap-item">
            <div class="roadmap-item-name"><?php echo($localize_hash["ROADMAP_NEXT_TITLE"][$language]); ?></div>
            <div class="roadmap-item-description"><?php echo($localize_hash["ROADMAP_NEXT_DETAIL"][$language]); ?></div>
		  </div>
        </div>
      </div>
    </div>
  </div>
</div>




<!-- Restaurant Spec Section -->
<div id="restaurant-spec">
  <div class="section-title text-center center">
    <div class="overlay">
      <h2>Spec</h2>
      <hr>
      <p><?php echo($localize_hash["SPEC_DETAIL_01"][$language]); ?></p>
    </div>
  </div>
  <div class="container">
    <div class="row">

      <div class="col-xs-12 col-sm-6">
        <div class="spec-section">
          <h2 class="spec-section-title"><?php echo($localize_hash["SPEC_TOKEN_TOKEN"][$language]); ?></h2>
          <hr>
          <div class="spec-item">
            <div class="spec-item-name"><?php echo($localize_hash["SPEC_ETHER_TOKEN_LABEL_01"][$language]); ?></div>
            <div class="spec-item-price"><?php echo($localize_hash["SPEC_ETHER_TOKEN_DETAIL_01"][$language]); ?></div>
          </div>
          <div class="spec-item">
            <div class="spec-item-name"><?php echo($localize_hash["SPEC_ETHER_TOKEN_LABEL_02"][$language]); ?></div>
            <div class="spec-item-price"><?php echo($localize_hash["SPEC_ETHER_TOKEN_DETAIL_02"][$language]); ?></div>
          </div>
          <div class="spec-item">
            <div class="spec-item-name"><?php echo($localize_hash["SPEC_ETHER_TOKEN_LABEL_03"][$language]); ?></div>
            <div class="spec-item-price"><?php echo($localize_hash["SPEC_ETHER_TOKEN_DETAIL_03"][$language]); ?></div>
          </div>
          <div class="spec-item">
            <div class="spec-item-name"><?php echo($localize_hash["SPEC_ETHER_TOKEN_LABEL_04"][$language]); ?></div>
            <div class="spec-item-price">ERC20/ERC223</div>
            <div class="spec-item-description"><span id="coin-contract"><?php echo($localize_hash["SPEC_ETHER_TOKEN_DETAIL_04"][$language]); ?></span></div>
          </div>
        </div>
      </div>

      <div class="col-xs-12 col-sm-6">
        <div class="spec-section">
          <h2 class="spec-section-title"><?php echo($localize_hash["SPEC_TOKEN_ALLOCATION"][$language]); ?></h2>
          <hr>
          <div class="spec-item">
            <div class="spec-item-name"><?php echo($localize_hash["SPEC_DEVELOP_TITLE"][$language]); ?></div>
            <div class="spec-item-price">30%</div>
            <div class="spec-item-description"><?php echo($localize_hash["SPEC_DEVELOP_DETAIL"][$language]); ?></div>
          </div>
          <div class="spec-item">
            <div class="spec-item-name"><?php echo($localize_hash["SPEC_SELLEXC_TITLE"][$language]); ?></div>
            <div class="spec-item-price">45%</div>
            <div class="spec-item-description"><?php echo($localize_hash["SPEC_SELLEXC_DETAIL"][$language]); ?></div>
          </div>
          <div class="spec-item">
            <div class="spec-item-name"><?php echo($localize_hash["SPEC_MARKETING_TITLE"][$language]); ?></div>
            <div class="spec-item-price">15%</div>
            <div class="spec-item-description"><?php echo($localize_hash["SPEC_MARKETING_DETAIL"][$language]); ?></div>
          </div>
          <div class="spec-item">
            <div class="spec-item-name"><?php echo($localize_hash["SPEC_TEAM_TITLE"][$language]); ?></div>
            <div class="spec-item-price">10%</div>
            <div class="spec-item-description"><?php echo($localize_hash["SPEC_TEAM_DETAIL"][$language]); ?></div>
          </div>
        </div>
      </div>
	</div>

    <div class="row">
      <div class="col-sm-3"></div>
      <div class="col-xs-12 col-sm-6" style="text-align:center">
          <canvas id="CoinPortFolioGraph" style="height: 60vmin; width: 60vmin;"></canvas>
      </div>
	</div>
  </div>
</div>





<!-- Team Section -->
<div id="team" class="text-center">
  <div class="overlay">
    <div class="container">
      <div class="col-md-10 col-md-offset-1 section-title">
        <h2>Team</h2>
        <hr>
        <p><?php echo($localize_hash["TEAM_DETAIL_02"][$language]); ?></p>
      </div>
      <div id="row">
        <div class="col-md-3 team">
          <div class="thumbnail">
            <div class="team-img"><img src="img/team/member_01.png" alt="..."></div>
            <div class="caption">
              <h3><?php echo($localize_hash["TEAM_MEMBER_BDA_TITLE"][$language]); ?></h3>
              <p><?php echo($localize_hash["TEAM_MEMBER_BDA_DETAIL"][$language]); ?></p>
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
        </div>
        <div class="col-md-3 team">
          <div class="thumbnail">
            <div class="team-img"><img src="img/team/member_03.png" alt="..."></div>
            <div class="caption">
              <h3><?php echo($localize_hash["TEAM_MEMBER_PAUL_TITLE"][$language]); ?></h3>
              <p><?php echo($localize_hash["TEAM_MEMBER_PAUL_DETAIL"][$language]); ?></p>
	              <ul class="list-inline social-buttons">
	                <li class="list-inline-item">
	                  <a href="https://twitter.com/lovealco4">
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
        </div>
        <div class="col-md-3 team">
          <div class="thumbnail">
            <div class="team-img"><img src="img/team/member_02.png" alt="..."></div>
            <div class="caption">
              <h3><?php echo($localize_hash["TEAM_MEMBER_KOMIYAMMA_TITLE"][$language]); ?></h3>
              <p><?php echo($localize_hash["TEAM_MEMBER_KOMIYAMMA_DETAIL"][$language]); ?></p>
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
        </div>
        <div class="col-md-3 team">
          <div class="thumbnail">
            <div class="team-img"><img src="img/team/member_08.png" alt="..."></div>
            <div class="caption">
              <h3><?php echo($localize_hash["TEAM_MEMBER_CHAMPHORTREE_TITLE"][$language]); ?></h3>
              <p><?php echo($localize_hash["TEAM_MEMBER_CHAMPHORTREE_DETAIL"][$language]); ?></p>
	              <ul class="list-inline social-buttons">
	                <li class="list-inline-item">
	                  <a href="https://twitter.com/kanpatree2">
	                    <i class="fa fa-twitter"></i>
	                  </a>
	                </li>
	                <li class="list-inline-item">
	                  <a href="https://github.com/kanpatree2">
	                    <i class="fa fa-github-alt"></i>
	                  </a>
	                </li>
	              </ul>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
<!-- Call Reservation Section -->
<!-- Contact Section -->
<div id="footer">
  <div class="container-fluid text-center copyrights">
    <div class="col-md-8 col-md-offset-2">
      <div class="social">
        <ul>
            <li class="list-inline-item">
                <a href="https://twitter.com/bda_dia">
                    <i class="fa fa-twitter"></i>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="https://discord.gg/xKaXrYh">
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
      <p>Copyright &copy; BLACK DIA COIN Team 2018-2019</p>
    </div>
  </div>
</div>
<script type="text/javascript" src="js/jquery.1.11.1.js"></script> 
<script type="text/javascript" src="js/bootstrap.js"></script> 
<script type="text/javascript" src="js/SmoothScroll.js"></script> 
<script type="text/javascript" src="js/nivo-lightbox.js"></script> 
<script type="text/javascript" src="js/jquery.isotope.js"></script> 
<script type="text/javascript" src="js/jqBootstrapValidation.js"></script> 
<script type="text/javascript" src="js/contact_me.js"></script> 
<script type="text/javascript" src="js/main.js"></script>

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
                text: "Total 40000000000"
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
