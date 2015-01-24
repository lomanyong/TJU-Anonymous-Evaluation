<!doctype html>
<html lang="en" ng-app="evaluationApp">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<title ng-bind="title"></title>
	<link rel="stylesheet" href="/stylesheets/main.css" />
	<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.2/css/bootstrap.min.css" />
	<link rel="stylesheet" media="all" href="//i.gtimg.cn/vipstyle/frozenui/1.2.0/css/frozen.css?_bid=306" />
	<link rel="stylesheet" media="all" href="//i.gtimg.cn/vipstyle/frozenui/1.2.0/css/global.css?_bid=306" />
	<script src="//i.gtimg.cn/vipstyle/frozenjs/lib/zepto.min.js?_bid=304"></script>
	<script src="//i.gtimg.cn/vipstyle/frozenjs/1.0.0/frozen.js?_bid=304"></script>
	<script src="//cdn.bootcss.com/angular.js/1.3.8/angular.min.js"></script>
	<script src="//cdn.bootcss.com/angular-ui-router/0.2.13/angular-ui-router.min.js"></script>
	<script src='/javascripts/app.js'></script>
	<script>
		angular.module("evaluationApp").constant("CSRF_TOKEN", '<?php echo csrf_token(); ?>');
	</script>
</head>
<body>
	<h2 class="title">TJU匿名课程评价</h2>
	<div ui-view="searchbar">
	  
	</div>
	<div ui-view="main">

	</div>	
</body>
</html>