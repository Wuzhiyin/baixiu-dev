<?php 
/**
 * 后台首页
 */

// 载入脚本
 // ========================================

require '../functions.php';

// 访问控制
 // ========================================

// 启动会话
 session_start();


if (empty($_SESSION['is_logged_in'])) {
  // 没有登录标识就代表没有登录
  // 跳转到登录页
  header('Location: /admin/login.php');
  exit; // 结束代码继续执行
}

// 查询数据
 // ========================================

 
// 查询文章总数
$post_count = xiu_query('select count(1) from posts')[0][0];
//select count (1) 查询出来的永远是单行单列的数据，所以 [0][0]

// 查询草稿总数
$drafted_count = xiu_query('select count(1) from posts where status = \'drafted\'')[0][0];

// 查询分类总数
$category_count = xiu_query('select count(1) from categories')[0][0];

// 查询评论总数
$comment_count = xiu_query('select count(1) from comments')[0][0];

// 查询待审核的评论总数
$held_count = xiu_query('select count(1) from comments where status = \'held\'')[0][0];

 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include 'inc/navbar.php'; ?>
    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1>One Belt, One Road</h1>
        <p>Thoughts, stories and ideas.</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.php" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong><?php echo $post_count; ?></strong>篇文章（<strong><?php echo $drafted_count; ?></strong>篇草稿）</li>
              <li class="list-group-item"><strong><?php echo $category_count; ?></strong>个分类</li>
              <li class="list-group-item"><strong><?php echo $comment_count; ?></strong>条评论（<strong><?php echo $held_count; ?></strong>条待审核）</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4">
          <canvas id="chart"></canvas>
        </div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>

  <?php $current_page = 'dashboard'; ?>
  <?php include 'inc/sidebar.php'; ?>

  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="/static/assets/vendors/chart/Chart.js"></script>
  <script>
    var ctx = document.getElementById('chart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        datasets: [
          {
            data: [<?php echo $post_count; ?>, <?php echo $category_count; ?>, <?php echo $comment_count; ?>],
            backgroundColor: [
              'hotpink',
              'pink',
              'deeppink',
            ]
          },
          {
            data: [<?php echo $post_count; ?>, <?php echo $category_count; ?>, <?php echo $comment_count; ?>],
            backgroundColor: [
              'hotpink',
              'pink',
              'deeppink',
            ]
          }
        ],

        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: [
          '文章',
          '分类',
          '评论'
        ]
      }
    });
  </script>
  <script>NProgress.done()</script>
</body>
</html>
