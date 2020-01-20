<?php Defined('BASE_PATH') or die(ACCESS_DENIED); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style type="text/css">
        <title>404 Error Page Stripo</title>
        @import url('https://fonts.googleapis.com/css?family=Sniglet:400,800');

		body{
            position: fixed;
            scroll-margin: none;
			background: rgb(255, 255, 255);
			font-family: 'Sniglet', cursive;

		}
		h1{
			text-align: center;
			font-size: 190px;
			font-weight: 400;
			margin: 0;
		}
		.fa{
			font-size: 120px;
			text-align: center;
			display: block;
			padding-top: 100px;
			margin: 0 auto;
			color: #A93226;
		}
		#error p{
			text-align: center;
			font-size: 36px;
			color: #4A235A;
		}
		a.back{
			text-align: center;
			margin: 0 auto;
			display: block;
			text-decoration: none;
			font-size: 24px;
			background: #BA4A00;
			border-radius: 10px;
			width: 10%;
			padding: 4px;
			color: #fff; 

		}
		footer p{
			padding-top: 160px;
			text-align: center;
		}
		a.w3hubs{
			text-decoration: none;
			color: #A93226;
		}
		@media(max-width: 550px){
			a.back{
				width: 20%;
			}
		}
		@media(max-width: 425px){
			h1{
				    padding-top: 20px;
			}
			.fa{
				padding-top: 100px;
			}
		}
	</style>
        <title>Error</title>
    </head>
    <body>
    <section id="error">
	<div class="content">
		<i class="fa fa-plane"></i>
		<h1>404</h1>
		<p>Error occurred! - File not Found</p>
		<a class="back" href="#">Back</a>
	</div>
</section>
    </body>
</html>