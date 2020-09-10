<?php
/**
 * 文章管理
 */

// 载入脚本
 // ========================================

require '../functions.php';

// 访问控制
 // ========================================

// 获取登录用户信息
 xiu_get_current_user();

// 查询数据
// =========================================

// 查询全部文章数据
$posts = xiu_query('select * from posts');

// 数据过滤函数
 // ========================================

/**
 * 将英文状态描述转换为中文
 * @param  string $status 英文状态
 * @return string         中文状态
 */
function convert_status ($status) {
  switch ($status) {
    case 'drafted':
      return ' 草稿';
    case 'published':
      return ' 已发布';
    case 'trashed':
      return ' 回收站';
    default:
      return ' 未知';
  }
}

/**
 * 格式化日期
 * @param  string $created 时间字符串
 * @return string          格式化后的时间字符串
 */
function format_date ($created) {
  // 设置默认时区！！！ PRC 指的是中华人民共和国
   date_default_timezone_set('PRC');

  // 转换为时间戳
   $timestamp = strtotime($created);

  // 格式化并返回 由于 r 是特殊字符，所以需要 \r 转义一下
   return date('Y 年 m 月 d 日 <b\r> H:i:s', $timestamp);
}

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
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
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline">
          <select name="" class="form-control input-sm">
            <option value="">所有分类</option>
            <option value="">未分类</option>
          </select>
          <select name="" class="form-control input-sm">
            <option value="">所有状态</option>
            <option value="">草稿</option>
            <option value="">已发布</option>
          </select>
          <button class="btn btn-default btn-sm">筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">
          <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li>
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $item) { ?>
            <tr>
              <td class="text-center"><input type="checkbox"></td>
              <td><?php echo $item['title']; ?></td>
              <td><?php echo $item['user_id']; ?></td>
              <td><?php echo $item['category_id']; ?></td>
              <td class="text-center"><?php echo format_date($item['created']); ?></td>
              <td class="text-center"><?php echo convert_status($item['status']); ?></td>
              <td class="text-center">
                <a href="post-add.php" class="btn btn-default btn-xs"> 编辑 </a>
                <a href="javascript:;" class="btn btn-danger btn-xs"> 删除 </a>
              </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php $current_page = 'posts'; ?>
  <?php include 'inc/sidebar.php'; ?>

  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
