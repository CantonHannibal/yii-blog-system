<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<!--代码放置于</body>上方-->


<body>

<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
        ['label' => 'Article', 'url' => ['/posts/index']],
        ['label' => 'Eamil', 'url' => ['/site/entry']],
        ['label' => 'Country', 'url' => ['/country/index']],
        ['label' => 'Users', 'url' => ['/user/index']],
//        ['label' => 'Subject', 'url' => ['/subject/index']],
//        ['label' => 'Teachers', 'url' => ['/teachers/index']],
//        ['label' => 'Teach', 'url' => ['/teach/index']],
//        ['label' => 'Class', 'url' => ['/clbum/index']],
//        ['label' => 'ClbumSubject', 'url' => ['/classsubject/index']],
//        ['label' => 'Students', 'url' => ['/students/index']],
//        ['label' => 'Scores', 'url' => ['/scores/index']],




    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>



<?php $this->endBody() ?>
<!--代码放置于</body>上方-->
<script type="text/javascript">
    /* 鼠标特效 */
    var a_idx = 0;
    jQuery(document).ready(function($) {
        $("body").click(function(e) {
            var a = new Array("prosperous", "democratic", "enlightened", "harmonious", "liberty", "equality", "Impartiality" ,"legality", "patriotism", "professionalism", "integrity", "amicability");
            var $i = $("<span />").text(a[a_idx]);
            a_idx = (a_idx + 1) % a.length;
            var x = e.pageX,
                y = e.pageY;
            $i.css({
                "z-index": 999999999999999999999999999999999999999999999999999999999999999999999,
                "top": y - 20,
                "left": x,
                "position": "absolute",
                "font-weight": "bold",
                "color": "#c7a83e"
            });
            $("body").append($i);
            $i.animate({
                    "top": y - 180,
                    "opacity": 0
                },
                1500,
                function() {
                    $i.remove();
                });
        });
    });
</script>
<script>

    !function () {

        function n(n, e, t) {

            return n.getAttribute(e) || t

        }

        function e(n) {

            return document.getElementsByTagName(n)

        }

        function t() {

            var t = e("script"), o = t.length, i = t[o - 1];

            return {

                l: o, z: n(i, "zIndex", -1), o: n(i, "opacity", .5), c: n(i, "color", "0,0,0"), n: n(i, "count", 99)

            }

        }

        function o() {

            a = m.width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth,

                c = m.height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight

        }

        function i() {

            r.clearRect(0, 0, a, c);

            var n, e, t, o, m, l;

            s.forEach(function (i, x) {

                for (i.x += i.xa, i.y += i.ya, i.xa *= i.x > a || i.x < 0 ? -1 : 1, i.ya *= i.y > c || i.y < 0 ? -1 : 1, r.fillRect(i.x - .5, i.y - .5, 1, 1), e = x + 1; e < u.length; e++)n = u[e],

                null !== n.x && null !== n.y && (o = i.x - n.x, m = i.y - n.y,

                    l = o * o + m * m, l < n.max && (n === y && l >= n.max / 2 && (i.x -= .03 * o, i.y -= .03 * m),

                    t = (n.max - l) / n.max, r.beginPath(), r.lineWidth = t / 2, r.strokeStyle = "rgba(" + d.c + "," + (t + .2) + ")", r.moveTo(i.x, i.y), r.lineTo(n.x, n.y), r.stroke()))

            }),

                x(i)

        }

        var a, c, u, m = document.createElement("canvas"),

            d = t(), l = "c_n" + d.l, r = m.getContext("2d"),

            x = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame ||

                function (n) {

                    window.setTimeout(n, 1e3 / 45)

                },

            w = Math.random, y = {x: null, y: null, max: 2e4};
        m.id = l, m.style.cssText = "position:fixed;top:0;left:0;z-index:" + d.z + ";opacity:" + d.o, e("body")[0].appendChild(m), o(), window.onresize = o,

            window.onmousemove = function (n) {

                n = n || window.event, y.x = n.clientX, y.y = n.clientY

            },

            window.onmouseout = function () {

                y.x = null, y.y = null

            };

        for (var s = [], f = 0; d.n > f; f++) {

            var h = w() * a, g = w() * c, v = 2 * w() - 1, p = 2 * w() - 1;
            s.push({x: h, y: g, xa: v, ya: p, max: 6e3})

        }

        u = s.concat([y]),

            setTimeout(function () {
                i()
            }, 100)

    }();

</script>

<iframe frameborder="no" border="0" marginwidth="0" marginheight="0" width=330 height=450 src="//music.163.com/outchain/player?type=1&id=74416996&auto=1&height=430"></iframe></body>
<!------------------------->
<!--作者：小康平方-->
<!--来源：CSDN-->
<!--原文：https://blog.csdn.net/Yan_Xiaokang/article/details/83927351-->
<!--版权声明：本文为博主原创文章，转载请附上博文链接！-->
</html>
<?php $this->endPage() ?>
