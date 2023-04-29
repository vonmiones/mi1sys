<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>MOPH - Equipment Tracking</title>
    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/css/accent.css">
    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/flip/flip.min.css">
    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/fontawesome/css/duotone.min.css">
    <script src="themes/<?= TEMPLATE; ?>/assets/js/jquery-3.6.0.min.js"></script>
    <script src="themes/<?= TEMPLATE; ?>/assets/bootstrap/js/bootstrap.min.js"></script>
    <style>
/*@import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');
@import url('https://use.fontawesome.com/releases/v5.13.0/css/all.css');
*/
body {
  font-family: 'Open Sans', sans-serif;
  font-size: 10pt;
}
.content-main{
    width:100%;
    padding: 20px;
    margin-left:223px;
    background-color: #eeeeee;
}

.sidebar {
  background-color: #303030;
  height: 100%;
  width: 200px;
  padding:10px;
  overflow: hidden;
  box-shadow: 5px 0px 5px rgba(0, 0, 0, 0.1);
}
.secondary{
    background-color: #292929;
}
.bottom {
    position: fixed;
    bottom: 0;
    width: 230px;
}

.sidebar-items {
  list-style: none;
  margin-left:-30px;
}

.sidebar-item {
  /*background-color: rgba(255,255,255,0.03);*/
  border-radius: 5px;
  background-color: #303030;
  color: #f0f0f0;
  list-style: none;
  margin-top:5px;
  padding-left:10px;
  padding-right:10px;
  padding-top:10px;
  padding-bottom:10px;
  /*margin-bottom: 10px;*/
  cursor: pointer;
  position: relative;
  transition: all 0.4s ease-in-out;
  z-index: 0;
}

.menu-divider {
    font-family: 'Open Sans', sans-serif;
    color: #aaaaaa;
    text-align: center;
    font-size: 12px;
    position: relative;
    margin-top:-10px;
}
.menu-divider div {
    background-color: #292929;
    position: relative;
    margin:0 auto;
    z-index: 99;
    padding-left:5px;
    padding-right:5px;
    width:fit-content ;
}
.menu-divider:before {
    content: "";
    display: block;
    width: 100%;
    height: 1px;
    background: #aaaaaa;
    left: 0;
    top: 50%;
    position: absolute;
}
.menu-divider:after {
    content: "";
    display: block;
    width: 100%;
    height: 1px;
    background: #aaaaaa;
    right: 0;
    top: 50%;
    position: absolute;
}

.sidebar-item svg {
  margin-right: 10px !important;
}
.sidebar-item i {
  margin-right: 10px !important;
}

.sidebar-item:hover {
  /*border-left: 7px solid;*/
  /*transform: translateY(-10px);*/
  z-index: 999999999999;
  transform: scale(1.05);
  transform-origin: center;
  box-shadow: 0px 5px 5px rgba(0, 0, 0, 1);
  transition: all 0.1s ease-in-out;
}

.orange:hover {
  border: 1px solid;
  /*border-left: 7px solid;*/
  border-color: #ff5000;
  transition: all 0.3s ease-in-out;
}

.orange {
  /*border-left: 7px solid;*/
  border-color: #ffff00;
  transition: all 0.3s ease-in-out;
}

.gradient-border {
  --borderWidth: 3px;
  background: #1D1F20;
  position: relative;
  border-radius: var(--borderWidth);
}
.gradient-border:hover {
  content: '';
  position: absolute;
  top: calc(-1 * var(--borderWidth));
  left: calc(-1 * var(--borderWidth));
  height: calc(100% + var(--borderWidth) * 2);
  width: calc(100% + var(--borderWidth) * 2);
  background: linear-gradient(60deg, #f79533, #f37055, #ef4e7b, #a166ab, #5073b8, #1098ad, #07b39b, #6fba82);
  border-radius: calc(2 * var(--borderWidth));
  z-index: -1;
  animation: animatedgradient 3s ease alternate infinite;
  background-size: 300% 300%;
}

#sidebar-secondary {
    z-index: 0;
    margin-left: -300px;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

#sidebar-secondary.close {
    z-index: 0;
    margin-left: -300px;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

#sidebar-secondary.open {
  margin-left: 0;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}



@keyframes animatedgradient {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}   
    </style>
</head>
