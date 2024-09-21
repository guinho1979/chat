<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
?>
<style>
.container{padding-right:5px;padding-left:5px;margin-right:auto;margin-left:auto}@media (min-width: 768px){.container{width:750px}}@media (min-width: 992px){.container{width:970px}}@media (min-width: 1200px){.container{width:1170px}}.container-fluid{padding-right:5px;padding-left:5px;margin-right:auto;margin-left:auto}.container{padding:0px!important}@media (min-width: 1200px){.container{width:1100px}}
.searchBox{background:#fff;background:-moz-linear-gradient(top,#fff 0,#e5e5e5 100%);background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#fff),color-stop(100%,#e5e5e5));background:-webkit-linear-gradient(top,#fff 0,#e5e5e5 100%);background:-o-linear-gradient(top,#fff 0,#e5e5e5 100%);background:-ms-linear-gradient(top,#fff 0,#e5e5e5 100%);background:linear-gradient(to bottom,#fff 0,#e5e5e5 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff',endColorstr='#e5e5e5',GradientType=0);width:100%;height:800px;border:#999 1px solid;margin-top:10px}
.searchForm{padding:10px;padding-left:20px;min-height:60px;width:100%;text-align:center;float:left;background:#fff;background:-moz-linear-gradient(top,#fff 0,#e5e5e5 100%);background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#fff),color-stop(100%,#e5e5e5));background:-webkit-linear-gradient(top,#fff 0,#e5e5e5 100%);background:-o-linear-gradient(top,#fff 0,#e5e5e5 100%);background:-ms-linear-gradient(top,#fff 0,#e5e5e5 100%);background:linear-gradient(to bottom,#fff 0,#e5e5e5 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff',endColorstr='#e5e5e5',GradientType=0);border-bottom:#ccc 2px solid}
.videoItemContainer{width:140px;height:140px;margin:3px;text-align:center;padding:5px;overflow:hidden;float:left;-webkit-box-shadow:4px 3px 5px 0 rgba(0,0,0,0.75);-moz-box-shadow:4px 3px 5px 0 rgba(0,0,0,0.75);box-shadow:4px 3px 5px 0 rgba(0,0,0,0.75);background:rgba(226,226,226,1);background:-moz-linear-gradient(left,rgba(226,226,226,1) 0,rgba(219,219,219,1) 50%,rgba(209,209,209,1) 51%,rgba(254,254,254,1) 100%);background:-webkit-gradient(left top,right top,color-stop(0%,rgba(226,226,226,1)),color-stop(50%,rgba(219,219,219,1)),color-stop(51%,rgba(209,209,209,1)),color-stop(100%,rgba(254,254,254,1)));background:-webkit-linear-gradient(left,rgba(226,226,226,1) 0,rgba(219,219,219,1) 50%,rgba(209,209,209,1) 51%,rgba(254,254,254,1) 100%);background:-o-linear-gradient(left,rgba(226,226,226,1) 0,rgba(219,219,219,1) 50%,rgba(209,209,209,1) 51%,rgba(254,254,254,1) 100%);background:-ms-linear-gradient(left,rgba(226,226,226,1) 0,rgba(219,219,219,1) 50%,rgba(209,209,209,1) 51%,rgba(254,254,254,1) 100%);background:linear-gradient(to right,rgba(226,226,226,1) 0,rgba(219,219,219,1) 50%,rgba(209,209,209,1) 51%,rgba(254,254,254,1) 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#e2e2e2',endColorstr='#fefefe',GradientType=1)}.videoItemImage img{cursor:pointer;width:130px;height:80px}.videoItemCaption{cursor:move}.videoList{height:720px;overflow:auto;border-left:#e4e4e4 1px solid;border-right:#e4e4e4 1px solid;border-top:#e4e4e4 1px solid}
.videoDetailContainer{background:#fff;background:-moz-linear-gradient(top,#fff 0,#e5e5e5 100%);background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#fff),color-stop(100%,#e5e5e5));background:-webkit-linear-gradient(top,#fff 0,#e5e5e5 100%);background:-o-linear-gradient(top,#fff 0,#e5e5e5 100%);background:-ms-linear-gradient(top,#fff 0,#e5e5e5 100%);background:linear-gradient(to bottom,#fff 0,#e5e5e5 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff',endColorstr='#e5e5e5',GradientType=0);width:100%;height:800px;border:#999 1px solid;margin-top:10px;padding:20px;text-align:center;overflow:auto}
.downloadDetail{background:#fff;background:-moz-linear-gradient(top,#fff 0,#e5e5e5 100%);background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#fff),color-stop(100%,#e5e5e5));background:-webkit-linear-gradient(top,#fff 0,#e5e5e5 100%);background:-o-linear-gradient(top,#fff 0,#e5e5e5 100%);background:-ms-linear-gradient(top,#fff 0,#e5e5e5 100%);background:linear-gradient(to bottom,#fff 0,#e5e5e5 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff',endColorstr='#e5e5e5',GradientType=0);width:100%;height:400px;border:#999 1px solid;margin-top:10px;text-align:center;overflow:auto}.vidContainer{text-align:center}.vidTitle{font-weight:bold;font-size:16px;margin-top:3px}.vidDesc{margin-top:8px}#relativeList{width:100%;height:300px;overflow:auto;text-align:center}
.download_cotainer{width:100%}.download_info{width:100%}.download_title{font-weight:bold}.format_list{width:100%}.format_list table{width:100%;border:solid 1px #CCC;-moz-box-shadow:5px 5px 0 #999;-webkit-box-shadow:5px 5px 0 #999;box-shadow:5px 5px 0 #999;border-collapse:collapse}.format_list table tr{margin-top:10px;border:2px #999 solid;width:100%;height:35px}.format_list table tr td{border-bottom:1px solid #008999}.downloadThumbnail{border:solid 1px #CCC;-moz-box-shadow:5px 5px 0 #999;-webkit-box-shadow:5px 5px 0 #999;box-shadow:5px 5px 0 #999}.downloadButton{-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;border:solid 1px #20538d;text-shadow:0 -1px 0 rgba(0,0,0,0.4);-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,0.4),0 1px 1px rgba(0,0,0,0.2);-moz-box-shadow:inset 0 1px 0 rgba(255,255,255,0.4),0 1px 1px rgba(0,0,0,0.2);box-shadow:inset 0 1px 0 rgba(255,255,255,0.4),0 1px 1px rgba(0,0,0,0.2);font:bold 11px Arial;text-decoration:none;background-color:#343a40;cursor: pointer;color:#fff;padding:10px;border-top:1px solid #ccc;border-right:1px solid #333;border-bottom:1px solid #333;border-left:1px solid #ccc}.downloadButton:hover{text-decoration:none;background:#17a2b8}.next{padding:15px;padding-top:25px;position:absolute;bottom:0;left:0;right:0;margin-top:10px;clear:both;float:right;text-align:right;border:#666 1px solid;height:50px;width:70px;cursor:pointer;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;border:solid 1px #20538d;text-shadow:0 -1px 0 rgba(0,0,0,0.4);-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,0.4),0 1px 1px rgba(0,0,0,0.2);-moz-box-shadow:inset 0 1px 0 rgba(255,255,255,0.4),0 1px 1px rgba(0,0,0,0.2);box-shadow:inset 0 1px 0 rgba(255,255,255,0.4),0 1px 1px rgba(0,0,0,0.2);background:#4479ba;color:#FFF;padding:8px 12px;text-decoration:none;text-align:center;vertical-align:middle}#playerContainer{background:#fff;background:-moz-linear-gradient(top,#fff 0,#e5e5e5 100%);background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#fff),color-stop(100%,#e5e5e5));background:-webkit-linear-gradient(top,#fff 0,#e5e5e5 100%);background:-o-linear-gradient(top,#fff 0,#e5e5e5 100%);background:-ms-linear-gradient(top,#fff 0,#e5e5e5 100%);background:linear-gradient(to bottom,#fff 0,#e5e5e5 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff',endColorstr='#e5e5e5',GradientType=0);width:100%;height:350px;border:#999 1px solid;margin-top:10px;text-align:center;padding:5px}#videoDownloadButton{-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;border:solid 1px #20538d;text-shadow:0 -1px 0 rgba(0,0,0,0.4);-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,0.4),0 1px 1px rgba(0,0,0,0.2);-moz-box-shadow:inset 0 1px 0 rgba(255,255,255,0.4),0 1px 1px rgba(0,0,0,0.2);box-shadow:inset 0 1px 0 rgba(255,255,255,0.4),0 1px 1px rgba(0,0,0,0.2);background:#4479ba;color:#FFF;padding:8px 12px;text-decoration:none}
#playList{background:#fff;background:-moz-linear-gradient(top,#fff 0,#e5e5e5 100%);background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#fff),color-stop(100%,#e5e5e5));background:-webkit-linear-gradient(top,#fff 0,#e5e5e5 100%);background:-o-linear-gradient(top,#fff 0,#e5e5e5 100%);background:-ms-linear-gradient(top,#fff 0,#e5e5e5 100%);background:linear-gradient(to bottom,#fff 0,#e5e5e5 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff',endColorstr='#e5e5e5',GradientType=0);width:100%;height:440px;border:#999 1px solid;margin-top:10px;text-align:center;padding:5px;overflow:auto}
@media print {
*, :after, :before {
color : #000 !important ;
text-shadow : none !important ;
background : 0 0 !important ;
box-shadow : none !important ;
}
img {
max-width : 100% !important ;
}
.btn > .caret, .dropup > .btn > .caret {
border-top-color : #000 !important ;
}
}
* {
box-sizing : border-box;
}
:after, :before {
box-sizing : border-box;
}
button, input, select, textarea {
font-family : inherit;
font-size : inherit;
line-height : inherit;
}
figure {
margin : 0;
}
img {
vertical-align : middle;
}
.img-rounded {
border-radius : 6px;
}
.img-thumbnail {
display : inline-block;
max-width : 100%;
height : auto;
padding : 4px;
line-height : 1.42857143;
background-color : #fff;
border : #ddd solid 1px;
border-radius : 4px;
transition : all 0.2s ease-in-out;
}
.img-circle {
border-radius : 50%;
}
.row {
margin-right : -15px;
margin-left : -15px;
}
.col-md-8, .col-md-4, .col-md-12{
position : relative;
min-height : 1px;
padding-right : 15px;
padding-left : 15px;
}
.col-xs-12 {
float : left;
}
.col-xs-12 {
width : 100%;
}
@media (min-width:992px) {
.col-md-4,.col-md-8 {
float : left;
}
.col-md-12 {
width : 100%;
}
.col-md-8 {
width : 66.66666667%;
}
.col-md-4 {
width : 33.33333333%;
}
}
.close {
float : right;
font-size : 21px;
font-weight : 700;
line-height : 1;
color : #000;
text-shadow : 0 1px 0 #fff;
opacity : 0.20000000298023223876953125;
}
.close:focus, .close:hover {
color : #000;
text-decoration : none;
cursor : pointer;
opacity : 0.5;
}
button.close {
padding : 0;
cursor : pointer;
background : 0 0;
border : 0;
}
.modal-open {
overflow : hidden;
}
.modal {
position : fixed;
top : 0;
right : 0;
bottom : 0;
left : 0;
z-index : 1050;
display : none;
overflow : hidden;
outline : 0;
}
.modal.fade .modal-dialog {
transition : transform 0.3s ease-out;
transform : translate(0,-25%);
}
.modal.in .modal-dialog {
transform : translate(0,0);
}
.modal-open .modal {
overflow-x : hidden;
overflow-y : auto;
}
.modal-dialog {
position : relative;
width : auto;
margin : 10px;
}
.modal-content {
position : relative;
background-color : #fff;
background-clip : padding-box;
border : #999 solid 1px;
border : rgba(0, 0, 0, 0.2) solid 1px;
border-radius : 6px;
outline : 0;
box-shadow : 0 3px 9px rgba(0, 0, 0, 0.5);
}
.modal-backdrop {
position : fixed;
top : 0;
right : 0;
bottom : 0;
left : 0;
z-index : 1040;
background-color : #000;
}
.modal-backdrop.fade {
opacity : 0;
}
.modal-backdrop.in {
opacity : 0.5;
}
.modal-header {
min-height : 16.43px;
padding : 15px;
border-bottom : 1px solid #e5e5e5;
}
.modal-header .close {
margin-top : -2px;
}
.modal-title {
margin : 0;
line-height : 1.42857143;
}
.modal-body {
position : relative;
padding : 15px;
}
.modal-footer {
padding : 15px;
text-align : right;
border-top : 1px solid #e5e5e5;
}
.modal-footer .btn + .btn {
margin-bottom : 0;
margin-left : 5px;
}
.modal-footer .btn-group .btn + .btn {
margin-left : -1px;
}
.modal-footer .btn-block + .btn-block {
margin-left : 0;
}
.modal-scrollbar-measure {
position : absolute;
top : -9999px;
width : 50px;
height : 50px;
overflow : scroll;
}
@media (min-width:768px) {
.modal-dialog {
width : 600px;
margin : 30px auto;
}
.modal-content {
box-shadow : 0 5px 15px rgba(0, 0, 0, 0.5);
}
.modal-sm {
width : 300px;
}
}
@media (min-width:992px) {
.modal-lg {
width : 900px;
}
}
.form-control {
display : block;
width : 100%;
height : 34px;
padding : 6px 12px;
font-size : 14px;
line-height : 1.42857143;
color : #555;
background-color : #fff;
background-image : none;
border : #ccc solid 1px;
border-radius : 4px;
box-shadow : 0 1px 1px rgba(0, 0, 0, 0.075) inset;
transition : border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.btn {
display : inline-block;
padding : 6px 12px;
margin-bottom : 0;
font-size : 14px;
font-weight : 400;
line-height : 1.42857143;
text-align : center;
white-space : nowrap;
vertical-align : middle;
cursor : pointer;
background-image : none;
border : transparent solid 1px;
border-radius : 4px;
}
.input-group {
position : relative;
display : table;
border-collapse : separate;
}
.input-group[class*="col-"] {
float : none;
padding-right : 0;
padding-left : 0;
}
.input-group .form-control {
position : relative;
z-index : 2;
float : left;
width : 100%;
margin-bottom : 0;
}
.input-group-lg > .form-control, .input-group-lg > .input-group-addon, .input-group-lg > .input-group-btn > .btn {
height : 46px;
padding : 10px 16px;
font-size : 18px;
line-height : 1.3333333;
border-radius : 6px;
}
select.input-group-lg > .form-control, select.input-group-lg > .input-group-addon, select.input-group-lg > .input-group-btn > .btn {
height : 46px;
line-height : 46px;
}
select[multiple].input-group-lg > .form-control, select[multiple].input-group-lg > .input-group-addon, select[multiple].input-group-lg > .input-group-btn > .btn, textarea.input-group-lg > .form-control, textarea.input-group-lg > .input-group-addon, textarea.input-group-lg > .input-group-btn > .btn {
height : auto;
}
.input-group-sm > .form-control, .input-group-sm > .input-group-addon, .input-group-sm > .input-group-btn > .btn {
height : 30px;
padding : 5px 10px;
font-size : 12px;
line-height : 1.5;
border-radius : 3px;
}
select.input-group-sm > .form-control, select.input-group-sm > .input-group-addon, select.input-group-sm > .input-group-btn > .btn {
height : 30px;
line-height : 30px;
}
select[multiple].input-group-sm > .form-control, select[multiple].input-group-sm > .input-group-addon, select[multiple].input-group-sm > .input-group-btn > .btn, textarea.input-group-sm > .form-control, textarea.input-group-sm > .input-group-addon, textarea.input-group-sm > .input-group-btn > .btn {
height : auto;
}
.input-group .form-control, .input-group-addon, .input-group-btn {
display : table-cell;
}
.input-group .form-control:not(:first-child):not(:last-child), .input-group-addon:not(:first-child):not(:last-child), .input-group-btn:not(:first-child):not(:last-child) {
border-radius : 0;
}
.input-group-addon, .input-group-btn {
width : 1%;
white-space : nowrap;
vertical-align : middle;
}
.input-group-addon {
padding : 6px 12px;
font-size : 14px;
font-weight : 400;
line-height : 1;
color : #555;
text-align : center;
background-color : #eee;
border : #ccc solid 1px;
border-radius : 4px;
}
.input-group-addon.input-sm {
padding : 5px 10px;
font-size : 12px;
border-radius : 3px;
}
.input-group-addon.input-lg {
padding : 10px 16px;
font-size : 18px;
border-radius : 6px;
}
.input-group-addon input[type="checkbox"], .input-group-addon input[type="radio"] {
margin-top : 0;
}
.input-group .form-control:first-child, .input-group-addon:first-child, .input-group-btn:first-child > .btn, .input-group-btn:first-child > .btn-group > .btn, .input-group-btn:first-child > .dropdown-toggle, .input-group-btn:last-child > .btn-group:not(:last-child) > .btn, .input-group-btn:last-child > .btn:not(:last-child):not(.dropdown-toggle) {
border-top-right-radius : 0;
border-bottom-right-radius : 0;
}
.input-group-addon:first-child {
border-right : 0;
}
.input-group .form-control:last-child, .input-group-addon:last-child, .input-group-btn:first-child > .btn-group:not(:first-child) > .btn, .input-group-btn:first-child > .btn:not(:first-child), .input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group > .btn, .input-group-btn:last-child > .dropdown-toggle {
border-top-left-radius : 0;
border-bottom-left-radius : 0;
}
.input-group-addon:last-child {
border-left : 0;
}
.input-group-btn {
position : relative;
font-size : 0;
white-space : nowrap;
}
.input-group-btn > .btn {
position : relative;
}
.input-group-btn > .btn + .btn {
margin-left : -1px;
}
.input-group-btn > .btn:active, .input-group-btn > .btn:focus, .input-group-btn > .btn:hover {
z-index : 2;
}
.input-group-btn:first-child > .btn, .input-group-btn:first-child > .btn-group {
margin-right : -1px;
}
.input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group {
z-index : 2;
margin-left : -1px;
}
</style>
<div class="container">
<?
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
ativo($meuid,'Convertor de MP3 ');
?>
<script src="https://socialcrazy.net/themes/frontend/default/js/jquery.js"></script>
<div class="row">
<div class="col-md-8">
<div class="searchBox">
<div class="searchForm">
<form role="form" method="post" action="" onSubmit="getVideoList(keyword.value); return false;">
<div class="row">
<div class="col-xs-12">
<div class="input-group input-group-lg">
<input type="text" class="form-control" name="keyword" placeholder="Digite Sua Busca" />
<div class="input-group-btn">
<button type="submit" class="btn" name="search" onClick="getVideoList(keyword.value)">Pesquisar</button>
</div>
</div>
</div>
</div>
</form>
</div>
<div class="videoList" id="videoList" ondrop="drop(event)" ondragover="allowDrop(event)">
</div>
</div>
</div>
<div class="col-md-4">
<div id="playerContainer">
<div id="player"></div>
<br>
<button id="videoDownloadButton" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onClick="downloadVideo();">DOWNLOAD</button>
</div>
</div> 
<div class="col-md-4">
<div id="playList" ondrop="drop(event)" ondragover="allowDrop(event)">
<h5 align="center"><b>Arraste Os Videos Para fazer Sua Play List</b></h5>
</div>
</div> 
</div> 
<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">DOWNLOAD</h4>
</div>
<div id="downloadFormatList" class="modal-body">
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
</div>
</div>
</div>
</div>
<script>
var playListArray;
$(document).ready(function(){
playListArray = new Array();
});
function playInPlayList(index){
player.playVideoAt(index);
}
function playThis(videoID){
player.loadVideoById(videoID);
}
function allowDrop(ev) {
ev.preventDefault();
}
function drag(ev) {
ev.dataTransfer.setData("text", ev.target.id);
}
function drop(ev) {
ev.preventDefault();
var data = ev.dataTransfer.getData("text");
ev.target.appendChild(document.getElementById(data));
playListArray.push(data);
player.cuePlaylist(playListArray);
var vidIndex = playListArray.length - 1;
document.getElementById(data).setAttribute('onClick', 'playInPlayList('+vidIndex+')');
}
function nextPage(keyword,token) {
document.getElementById("videoList").innerHTML="A lista de vídeos está sendo carregada. Por favor, espere...";
if (window.XMLHttpRequest) {
xmlhttp1=new XMLHttpRequest();
} else { 
xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp1.onreadystatechange=function() {
if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
document.getElementById("videoList").innerHTML=xmlhttp1.responseText;
}
};
keyword = keyword.replace(/ /g, '%2B');
xmlhttp1.open("GET","/f.php?keyword="+keyword+"&nextPage="+token,true);
xmlhttp1.send();
}
function getVideoList(keyword) {
document.getElementById("videoList").innerHTML="A lista de vídeos está sendo carregada. Por favor, espere...";
if (window.XMLHttpRequest) {
xmlhttp2 = new XMLHttpRequest();
} else { 
xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp2.onreadystatechange=function() {
if (xmlhttp2.readyState==4 && xmlhttp2.status==200) {
document.getElementById("videoList").innerHTML = xmlhttp2.responseText;
}
};
if(keyword.length > 0){
keyword = keyword.replace(/ /g, '%2B');
xmlhttp2.open("GET","/f.php?keyword="+keyword,true);
}else{
xmlhttp2.open("GET","/f.php",true);
}
xmlhttp2.send();
}
!function(e){
var n=!1;
if("function"==typeof define&&define.amd&&(define(e),n=!0),"object"==typeof exports&&(module.exports=e(),n=!0),!n){
var o=window.Cookies,t=window.Cookies=e();
t.noConflict=function(){
return window.Cookies=o,t;
}
}
}(function(){
function e(){
for(var e=0,n={};e<arguments.length;e++){
var o=arguments[e];
for(var t in o)n[t]=o[t]
}
return n;
}
function n(o){
function t(n,r,i){
var c;
if("undefined"!=typeof document){
if(arguments.length>1){
if(i=e({path:"/"},t.defaults,i),"number"==typeof i.expires){
var a=new Date;a.setMilliseconds(a.getMilliseconds()+864e5*i.expires),i.expires=a;
}
i.expires=i.expires?i.expires.toUTCString():"";
try{
c=JSON.stringify(r),/^[\{\[]/.test(c)&&(r=c);
}catch(e){}
r=o.write?o.write(r,n):encodeURIComponent(String(r)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),n=encodeURIComponent(String(n)),n=n.replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent),n=n.replace(/[\(\)]/g,escape);
var f="";
for(var s in i)i[s]&&(f+="; "+s,i[s]!==!0&&(f+="="+i[s]));
return document.cookie=n+"="+r+f;
}
n||(c={});
for(var p=document.cookie?document.cookie.split("; "):[],d=0;d<p.length;d++){
var u=p[d].split("="),l=u.slice(1).join("=");'"'===l.charAt(0)&&(l=l.slice(1,-1));
try{
var g=u[0].replace(/(%[0-9A-Z]{2})+/g,decodeURIComponent);
if(l=o.read?o.read(l,g):o(l,g)||l.replace(/(%[0-9A-Z]{2})+/g,decodeURIComponent),this.json);
try{
l=JSON.parse(l);
}catch(e){}
if(n===g){
c=l;
break}n||(c[g]=l);
}catch(e){}
}
return c;
}
}
return t.set=t,t.get=function(e){
return t.call(t,e)},t.getJSON=function(){
return t.apply({json:!0},[].slice.call(arguments))},t.defaults={},t.remove=function(n,o){
t(n,"",e(o,{expires:-1}))},t.withConverter=n,t;
}
return n(function(){})});
function downloadVideo() {
var maxCookieValue = 3, initCookie = 1, expirationDays = 1;
var cookieName = "tentativasdown";
var getCookie = Cookies.get(cookieName);
if (getCookie == null) {
Cookies.set(cookieName, initCookie, { expires: expirationDays });
console.log('Cookie definido como valor 1');
}
if (getCookie >= initCookie && getCookie < maxCookieValue) {
getCookie++;
Cookies.set(cookieName, getCookie, { expires: expirationDays });
console.log('Cookie incrementado. O valor é ' + getCookie);
}
if (getCookie >= maxCookieValue) {
console.log('Valor máximo permitido do cookie atingido: ' + getCookie);
document.getElementById("downloadFormatList").innerHTML="Desculpe limite de conversão atingido tente mais tarde";
}else{
var videoID = player.getVideoData()['video_id'];
document.getElementById("downloadFormatList").innerHTML="Aguarde. Processando...";
if (window.XMLHttpRequest) {
xmlhttp3 = new XMLHttpRequest();
} else { 
xmlhttp3 = new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp3.onreadystatechange=function() {
if (xmlhttp3.readyState==4 && xmlhttp3.status==200) {
document.getElementById("downloadFormatList").innerHTML=xmlhttp3.responseText;
}
};
xmlhttp3.open("GET","/download.php?videoid="+videoID,true);
xmlhttp3.send();
}
}
getVideoList('by redesocialcrazy');
if(!window.YT)var YT={loading:0,loaded:0};if(!window.YTConfig)var YTConfig={host:"https://www.youtube.com"};YT.loading||(YT.loading=1,function(){var o=[];YT.ready=function(n){YT.loaded?n():o.push(n)},window.onYTReady=function(){YT.loaded=1;for(var n=0;n<o.length;n++)try{o[n]()}catch(i){}},YT.setConfig=function(o){for(var n in o)o.hasOwnProperty(n)&&(YTConfig[n]=o[n])}}());
(function(){var g,k=this;function l(a){return"string"==typeof a}
function m(a){a=a.split(".");for(var b=k,c=0;c<a.length;c++)if(b=b[a[c]],null==b)return null;return b}
function aa(){}
function n(a){var b=typeof a;if("object"==b)if(a){if(a instanceof Array)return"array";if(a instanceof Object)return b;var c=Object.prototype.toString.call(a);if("[object Window]"==c)return"object";if("[object Array]"==c||"number"==typeof a.length&&"undefined"!=typeof a.splice&&"undefined"!=typeof a.propertyIsEnumerable&&!a.propertyIsEnumerable("splice"))return"array";if("[object Function]"==c||"undefined"!=typeof a.call&&"undefined"!=typeof a.propertyIsEnumerable&&!a.propertyIsEnumerable("call"))return"function"}else return"null";
else if("function"==b&&"undefined"==typeof a.call)return"object";return b}
function p(a){var b=n(a);return"array"==b||"object"==b&&"number"==typeof a.length}
function q(a){var b=typeof a;return"object"==b&&null!=a||"function"==b}
var r="closure_uid_"+(1E9*Math.random()>>>0),t=0;function ba(a,b,c){return a.call.apply(a.bind,arguments)}
function ca(a,b,c){if(!a)throw Error();if(2<arguments.length){var d=Array.prototype.slice.call(arguments,2);return function(){var c=Array.prototype.slice.call(arguments);Array.prototype.unshift.apply(c,d);return a.apply(b,c)}}return function(){return a.apply(b,arguments)}}
function u(a,b,c){Function.prototype.bind&&-1!=Function.prototype.bind.toString().indexOf("native code")?u=ba:u=ca;return u.apply(null,arguments)}
function da(a,b){for(var c in b)a[c]=b[c]}
var ea=Date.now||function(){return+new Date};
function w(a,b){var c=a.split("."),d=k;c[0]in d||!d.execScript||d.execScript("var "+c[0]);for(var e;c.length&&(e=c.shift());)c.length||void 0===b?d[e]&&d[e]!==Object.prototype[e]?d=d[e]:d=d[e]={}:d[e]=b}
function x(a,b){function c(){}
c.prototype=b.prototype;a.J=b.prototype;a.prototype=new c;a.prototype.constructor=a;a.R=function(a,c,f){for(var e=Array(arguments.length-2),d=2;d<arguments.length;d++)e[d-2]=arguments[d];return b.prototype[c].apply(a,e)}}
;var fa=Array.prototype.indexOf?function(a,b){return Array.prototype.indexOf.call(a,b,void 0)}:function(a,b){if(l(a))return l(b)&&1==b.length?a.indexOf(b,0):-1;
for(var c=0;c<a.length;c++)if(c in a&&a[c]===b)return c;return-1},y=Array.prototype.forEach?function(a,b,c){Array.prototype.forEach.call(a,b,c)}:function(a,b,c){for(var d=a.length,e=l(a)?a.split(""):a,f=0;f<d;f++)f in e&&b.call(c,e[f],f,a)};
function ha(a,b){a:{var c=a.length;for(var d=l(a)?a.split(""):a,e=0;e<c;e++)if(e in d&&b.call(void 0,d[e],e,a)){c=e;break a}c=-1}return 0>c?null:l(a)?a.charAt(c):a[c]}
function ia(a){return Array.prototype.concat.apply([],arguments)}
function z(a){var b=a.length;if(0<b){for(var c=Array(b),d=0;d<b;d++)c[d]=a[d];return c}return[]}
;function ja(a,b){this.c=a;this.f=b;this.b=0;this.a=null}
ja.prototype.get=function(){if(0<this.b){this.b--;var a=this.a;this.a=a.next;a.next=null}else a=this.c();return a};var ka=/&/g,la=/</g,ma=/>/g,na=/"/g,oa=/'/g,pa=/\x00/g,qa=/[\x00&<>"']/;var A;a:{var ra=k.navigator;if(ra){var sa=ra.userAgent;if(sa){A=sa;break a}}A=""};function ta(a){var b=B,c;for(c in b)if(a.call(void 0,b[c],c,b))return c}
;function ua(a){k.setTimeout(function(){throw a;},0)}
var C;
function va(){var a=k.MessageChannel;"undefined"===typeof a&&"undefined"!==typeof window&&window.postMessage&&window.addEventListener&&-1==A.indexOf("Presto")&&(a=function(){var a=document.createElement("IFRAME");a.style.display="none";a.src="";document.documentElement.appendChild(a);var b=a.contentWindow;a=b.document;a.open();a.write("");a.close();var c="callImmediate"+Math.random(),d="file:"==b.location.protocol?"*":b.location.protocol+"//"+b.location.host;a=u(function(a){if(("*"==d||a.origin==d)&&
a.data==c)this.port1.onmessage()},this);
b.addEventListener("message",a,!1);this.port1={};this.port2={postMessage:function(){b.postMessage(c,d)}}});
if("undefined"!==typeof a&&-1==A.indexOf("Trident")&&-1==A.indexOf("MSIE")){var b=new a,c={},d=c;b.port1.onmessage=function(){if(void 0!==c.next){c=c.next;var a=c.F;c.F=null;a()}};
return function(a){d.next={F:a};d=d.next;b.port2.postMessage(0)}}return"undefined"!==typeof document&&"onreadystatechange"in document.createElement("SCRIPT")?function(a){var b=document.createElement("SCRIPT");
b.onreadystatechange=function(){b.onreadystatechange=null;b.parentNode.removeChild(b);b=null;a();a=null};
document.documentElement.appendChild(b)}:function(a){k.setTimeout(a,0)}}
;function D(){this.b=this.a=null}
var wa=new ja(function(){return new E},function(a){a.reset()});
D.prototype.add=function(a,b){var c=wa.get();c.set(a,b);this.b?this.b.next=c:this.a=c;this.b=c};
D.prototype.remove=function(){var a=null;this.a&&(a=this.a,this.a=this.a.next,this.a||(this.b=null),a.next=null);return a};
function E(){this.next=this.b=this.a=null}
E.prototype.set=function(a,b){this.a=a;this.b=b;this.next=null};
E.prototype.reset=function(){this.next=this.b=this.a=null};function xa(a){F||ya();G||(F(),G=!0);za.add(a,void 0)}
var F;function ya(){if(-1!=String(k.Promise).indexOf("[native code]")){var a=k.Promise.resolve(void 0);F=function(){a.then(Aa)}}else F=function(){var a=Aa,c;
!(c="function"!=n(k.setImmediate))&&(c=k.Window&&k.Window.prototype)&&(c=-1==A.indexOf("Edge")&&k.Window.prototype.setImmediate==k.setImmediate);c?(C||(C=va()),C(a)):k.setImmediate(a)}}
var G=!1,za=new D;function Aa(){for(var a;a=za.remove();){try{a.a.call(a.b)}catch(c){ua(c)}var b=wa;b.f(a);100>b.b&&(b.b++,a.next=b.a,b.a=a)}G=!1}
;function H(){this.c=this.c;this.f=this.f}
H.prototype.c=!1;H.prototype.dispose=function(){this.c||(this.c=!0,this.A())};
H.prototype.A=function(){if(this.f)for(;this.f.length;)this.f.shift()()};function Ba(a,b){var c,d;var e=document;e=b||e;if(e.querySelectorAll&&e.querySelector&&a)return e.querySelectorAll(""+(a?"."+a:""));if(a&&e.getElementsByClassName){var f=e.getElementsByClassName(a);return f}f=e.getElementsByTagName("*");if(a){var h={};for(c=d=0;e=f[c];c++){var v=e.className,R;if(R="function"==typeof v.split)R=0<=fa(v.split(/\s+/),a);R&&(h[d++]=e)}h.length=d;return h}return f}
function Ca(a,b){for(var c=0;a;){if(b(a))return a;a=a.parentNode;c++}return null}
;var I="StopIteration"in k?k.StopIteration:{message:"StopIteration",stack:""};function J(){}
J.prototype.next=function(){throw I;};
J.prototype.m=function(){return this};
function Da(a){if(a instanceof J)return a;if("function"==typeof a.m)return a.m(!1);if(p(a)){var b=0,c=new J;c.next=function(){for(;;){if(b>=a.length)throw I;if(b in a)return a[b++];b++}};
return c}throw Error("Not implemented");}
function Ea(a,b){if(p(a))try{y(a,b,void 0)}catch(c){if(c!==I)throw c;}else{a=Da(a);try{for(;;)b.call(void 0,a.next(),void 0,a)}catch(c){if(c!==I)throw c;}}}
function Fa(a){if(p(a))return z(a);a=Da(a);var b=[];Ea(a,function(a){b.push(a)});
return b}
;var Ga=k.JSON.stringify;function K(a){H.call(this);this.l=1;this.g=[];this.h=0;this.a=[];this.b={};this.o=!!a}
x(K,H);g=K.prototype;g.subscribe=function(a,b,c){var d=this.b[a];d||(d=this.b[a]=[]);var e=this.l;this.a[e]=a;this.a[e+1]=b;this.a[e+2]=c;this.l=e+3;d.push(e);return e};
function Ha(a,b,c){var d=L;if(a=d.b[a]){var e=d.a;(a=ha(a,function(a){return e[a+1]==b&&e[a+2]==c}))&&d.D(a)}}
g.D=function(a){var b=this.a[a];if(b){var c=this.b[b];if(0!=this.h)this.g.push(a),this.a[a+1]=aa;else{if(c){var d=fa(c,a);0<=d&&Array.prototype.splice.call(c,d,1)}delete this.a[a];delete this.a[a+1];delete this.a[a+2]}}return!!b};
g.H=function(a,b){var c=this.b[a];if(c){for(var d=Array(arguments.length-1),e=1,f=arguments.length;e<f;e++)d[e-1]=arguments[e];if(this.o)for(e=0;e<c.length;e++){var h=c[e];Ia(this.a[h+1],this.a[h+2],d)}else{this.h++;try{for(e=0,f=c.length;e<f;e++)h=c[e],this.a[h+1].apply(this.a[h+2],d)}finally{if(this.h--,0<this.g.length&&0==this.h)for(;c=this.g.pop();)this.D(c)}}return 0!=e}return!1};
function Ia(a,b,c){xa(function(){a.apply(b,c)})}
g.clear=function(a){if(a){var b=this.b[a];b&&(y(b,this.D,this),delete this.b[a])}else this.a.length=0,this.b={}};
g.A=function(){K.J.A.call(this);this.clear();this.g.length=0};function Ja(){}
;function M(){}
x(M,Ja);M.prototype.clear=function(){var a=Fa(this.m(!0)),b=this;y(a,function(a){b.remove(a)})};function N(a){this.a=a}
x(N,M);function Ka(a){if(a.a)try{a.a.setItem("__sak","1"),a.a.removeItem("__sak")}catch(b){}}
g=N.prototype;g.set=function(a,b){try{this.a.setItem(a,b)}catch(c){if(0==this.a.length)throw"Storage mechanism: Storage disabled";throw"Storage mechanism: Quota exceeded";}};
g.get=function(a){a=this.a.getItem(a);if(!l(a)&&null!==a)throw"Storage mechanism: Invalid value was encountered";return a};
g.remove=function(a){this.a.removeItem(a)};
g.m=function(a){var b=0,c=this.a,d=new J;d.next=function(){if(b>=c.length)throw I;var d=c.key(b++);if(a)return d;d=c.getItem(d);if(!l(d))throw"Storage mechanism: Invalid value was encountered";return d};
return d};
g.clear=function(){this.a.clear()};
g.key=function(a){return this.a.key(a)};function La(){var a=null;try{a=window.localStorage||null}catch(b){}this.a=a}
x(La,N);function Ma(){var a=null;try{a=window.sessionStorage||null}catch(b){}this.a=a}
x(Ma,N);var Na=/^(?:([^:/?#.]+):)?(?:\/\/(?:([^/?#]*)@)?([^/#?]*?)(?::([0-9]+))?(?=[/#?]|$))?([^?#]+)?(?:\?([^#]*))?(?:#([\s\S]*))?$/;function Oa(a){var b=a.match(Na);a=b[1];var c=b[2],d=b[3];b=b[4];var e="";a&&(e+=a+":");d&&(e+="//",c&&(e+=c+"@"),e+=d,b&&(e+=":"+b));return e}
function Pa(a,b,c){if("array"==n(b))for(var d=0;d<b.length;d++)Pa(a,String(b[d]),c);else null!=b&&c.push(a+(""===b?"":"="+encodeURIComponent(String(b))))}
function Qa(a){var b=[],c;for(c in a)Pa(c,a[c],b);return b.join("&")}
var Ra=/#|$/;var O=window.yt&&window.yt.config_||window.ytcfg&&window.ytcfg.data_||{};w("yt.config_",O);function Sa(a){var b=arguments;if(1<b.length)O[b[0]]=b[1];else{b=b[0];for(var c in b)O[c]=b[c]}}
;function Ta(a){return a&&window.yterr?function(){try{return a.apply(this,arguments)}catch(b){Ua(b)}}:a}
function Ua(a,b){var c=m("yt.logging.errors.log");c?c(a,b,void 0,void 0,void 0):(c=[],c="ERRORS"in O?O.ERRORS:c,c.push([a,b,void 0,void 0,void 0]),Sa("ERRORS",c))}
;var Va=0;w("ytDomDomGetNextId",m("ytDomDomGetNextId")||function(){return++Va});var Wa={stopImmediatePropagation:1,stopPropagation:1,preventMouseEvent:1,preventManipulation:1,preventDefault:1,layerX:1,layerY:1,screenX:1,screenY:1,scale:1,rotation:1,webkitMovementX:1,webkitMovementY:1};
function P(a){this.type="";this.source=this.data=this.currentTarget=this.relatedTarget=this.target=null;this.charCode=this.keyCode=0;this.shiftKey=this.ctrlKey=this.altKey=!1;this.clientY=this.clientX=0;this.changedTouches=this.touches=null;if(a=a||window.event){this.a=a;for(var b in a)b in Wa||(this[b]=a[b]);(b=a.target||a.srcElement)&&3==b.nodeType&&(b=b.parentNode);this.target=b;if(b=a.relatedTarget)try{b=b.nodeName?b:null}catch(c){b=null}else"mouseover"==this.type?b=a.fromElement:"mouseout"==
this.type&&(b=a.toElement);this.relatedTarget=b;this.clientX=void 0!=a.clientX?a.clientX:a.pageX;this.clientY=void 0!=a.clientY?a.clientY:a.pageY;this.keyCode=a.keyCode?a.keyCode:a.which;this.charCode=a.charCode||("keypress"==this.type?this.keyCode:0);this.altKey=a.altKey;this.ctrlKey=a.ctrlKey;this.shiftKey=a.shiftKey}}
P.prototype.preventDefault=function(){this.a&&(this.a.returnValue=!1,this.a.preventDefault&&this.a.preventDefault())};
P.prototype.stopPropagation=function(){this.a&&(this.a.cancelBubble=!0,this.a.stopPropagation&&this.a.stopPropagation())};
P.prototype.stopImmediatePropagation=function(){this.a&&(this.a.cancelBubble=!0,this.a.stopImmediatePropagation&&this.a.stopImmediatePropagation())};var B=m("ytEventsEventsListeners")||{};w("ytEventsEventsListeners",B);var Xa=m("ytEventsEventsCounter")||{count:0};w("ytEventsEventsCounter",Xa);function Ya(a,b,c,d){d=void 0===d?!1:d;a.addEventListener&&("mouseenter"!=b||"onmouseenter"in document?"mouseleave"!=b||"onmouseenter"in document?"mousewheel"==b&&"MozBoxSizing"in document.documentElement.style&&(b="MozMousePixelScroll"):b="mouseout":b="mouseover");return ta(function(e){return!!e.length&&e[0]==a&&e[1]==b&&e[2]==c&&e[4]==!!d})}
function Za(a){a&&("string"==typeof a&&(a=[a]),y(a,function(a){if(a in B){var b=B[a],d=b[0],e=b[1],f=b[3];b=b[4];d.removeEventListener?d.removeEventListener(e,f,b):d.detachEvent&&d.detachEvent("on"+e,f);delete B[a]}}))}
function $a(a,b,c){var d=void 0===d?!1:d;if(a&&(a.addEventListener||a.attachEvent)){var e=Ya(a,b,c,d);if(!e){e=++Xa.count+"";var f=!("mouseenter"!=b&&"mouseleave"!=b||!a.addEventListener||"onmouseenter"in document);var h=f?function(d){d=new P(d);if(!Ca(d.relatedTarget,function(b){return b==a}))return d.currentTarget=a,d.type=b,c.call(a,d)}:function(b){b=new P(b);
b.currentTarget=a;return c.call(a,b)};
h=Ta(h);a.addEventListener?("mouseenter"==b&&f?b="mouseover":"mouseleave"==b&&f?b="mouseout":"mousewheel"==b&&"MozBoxSizing"in document.documentElement.style&&(b="MozMousePixelScroll"),a.addEventListener(b,h,d)):a.attachEvent("on"+b,h);B[e]=[a,b,c,h,d]}}}
;function ab(a){"function"==n(a)&&(a=Ta(a));return window.setInterval(a,250)}
;var bb={};function cb(a){return bb[a]||(bb[a]=String(a).replace(/\-([a-z])/g,function(a,c){return c.toUpperCase()}))}
;var Q={},S=[],L=new K,db={};function eb(){y(S,function(a){a()})}
function fb(a,b){b||(b=document);var c=z(b.getElementsByTagName("yt:"+a)),d="yt-"+a,e=b||document;d=z(e.querySelectorAll&&e.querySelector?e.querySelectorAll("."+d):Ba(d,b));return ia(c,d)}
function T(a,b){return"yt:"==a.tagName.toLowerCase().substr(0,3)?a.getAttribute(b):a?a.dataset?a.dataset[cb(b)]:a.getAttribute("data-"+b):null}
function gb(a,b){L.H.apply(L,arguments)}
;function hb(a){this.b=a||{};this.f={};this.c=this.a=!1;a=document.getElementById("www-widgetapi-script");if(this.a=!!("https:"==document.location.protocol||a&&0==a.src.indexOf("https:"))){a=[this.b,window.YTConfig||{},this.f];for(var b=0;b<a.length;b++)a[b].host&&(a[b].host=a[b].host.replace("http://","https://"))}}
var U=null;function V(a,b){for(var c=[a.b,window.YTConfig||{},a.f],d=0;d<c.length;d++){var e=c[d][b];if(void 0!=e)return e}return null}
function ib(a,b,c){U||(U={},$a(window,"message",u(a.g,a)));U[c]=b}
hb.prototype.g=function(a){if(a.origin==V(this,"host")||a.origin==V(this,"host").replace(/^http:/,"https:")){try{var b=JSON.parse(a.data)}catch(c){return}this.c=!0;this.a||0!=a.origin.indexOf("https:")||(this.a=!0);if(a=U[b.id])a.B=!0,a.B&&(y(a.u,a.C,a),a.u.length=0),a.I(b)}};function W(a,b,c){this.h=this.a=this.b=null;this.g=this[r]||(this[r]=++t);this.c=0;this.B=!1;this.u=[];this.f=null;this.l=c;this.o={};c=document;if(a=l(a)?c.getElementById(a):a)if(c="iframe"==a.tagName.toLowerCase(),b.host||(b.host=c?Oa(a.src):"https://www.youtube.com"),this.b=new hb(b),c||(b=jb(this,a),this.h=a,(c=a.parentNode)&&c.replaceChild(b,a),a=b),
a.allowFullscreen = false,
this.a=a,this.a.id||(a=b=this.a,a=a[r]||(a[r]=++t),b.id="widget"+a),Q[this.a.id]=this,window.postMessage){this.f=new K;kb(this);b=V(this.b,"events");
for(var d in b)b.hasOwnProperty(d)&&this.addEventListener(d,b[d]);for(var e in db)lb(this,e)}}
g=W.prototype;g.M=function(a,b){this.a.width=a;this.a.height=b;return this};
g.L=function(){return this.a};
g.I=function(a){this.s(a.event,a)};
g.addEventListener=function(a,b){var c=b;"string"==typeof b&&(c=function(){window[b].apply(window,arguments)});
this.f.subscribe(a,c);mb(this,a);return this};
function lb(a,b){var c=b.split(".");if(2==c.length){var d=c[1];a.l==c[0]&&mb(a,d)}}
g.K=function(){this.a.id&&(Q[this.a.id]=null);var a=this.f;a&&"function"==typeof a.dispose&&a.dispose();if(this.h){a=this.a;var b=a.parentNode;b&&b.replaceChild(this.h,a)}else(a=this.a)&&a.parentNode&&a.parentNode.removeChild(a);U&&(U[this.g]=null);this.b=null;a=this.a;for(var c in B)B[c][0]==a&&Za(c);this.h=this.a=null};
g.v=function(){return{}};
function X(a,b,c){c=c||[];c=Array.prototype.slice.call(c);b={event:"command",func:b,args:c};a.B?a.C(b):a.u.push(b)}
g.s=function(a,b){if(!this.f.c){var c={target:this,data:b};this.f.H(a,c);gb(this.l+"."+a,c)}};
function jb(a,b){for(var c=document.createElement("iframe"),d=b.attributes,e=0,f=d.length;e<f;e++){var h=d[e].value;null!=h&&""!=h&&"null"!=h&&c.setAttribute(d[e].name,h)}c.setAttribute("frameBorder",0);c.setAttribute("allow","encrypted-media; autoplay");(d=V(a.b,"width"))&&c.setAttribute("width",d);(d=V(a.b,"height"))&&c.setAttribute("height",d);var v=a.v();v.enablejsapi=window.postMessage?
1:0;window.location.host&&(v.origin=window.location.protocol+"//"+window.location.host);v.widgetid=a.g;window.location.href&&y(["debugjs","debugcss"],function(a){var b=window.location.href;var c=b.search(Ra);b:{var d=0;for(var e=a.length;0<=(d=b.indexOf(a,d))&&d<c;){var f=b.charCodeAt(d-1);if(38==f||63==f)if(f=b.charCodeAt(d+e),!f||61==f||38==f||35==f)break b;d+=e+1}d=-1}if(0>d)b=null;else{e=b.indexOf("&",d);if(0>e||e>c)e=c;d+=a.length+1;b=decodeURIComponent(b.substr(d,e-d).replace(/\+/g," "))}null===
b||(v[a]=b)});
c.src=V(a.b,"host")+a.w()+"?"+Qa(v);return c}
g.G=function(){this.a&&this.a.contentWindow?this.C({event:"listening"}):window.clearInterval(this.c)};
function kb(a){ib(a.b,a,a.g);a.c=ab(u(a.G,a));$a(a.a,"load",u(function(){window.clearInterval(this.c);this.c=ab(u(this.G,this))},a))}
function mb(a,b){a.o[b]||(a.o[b]=!0,X(a,"addEventListener",[b]))}
g.C=function(a){a.id=this.g;a.channel="widget";a=Ga(a);var b=this.b;var c=Oa(this.a.src);b=0==c.indexOf("https:")?[c]:b.a?[c.replace("http:","https:")]:b.c?[c]:[c,c.replace("http:","https:")];if(!this.a.contentWindow)throw Error("The YouTube player is not attached to the DOM.");for(c=0;c<b.length;c++)try{
if(this._skiped){ this.a.contentWindow.postMessage(a,b[c]); } else { this._skiped = true;}}catch(d){if(d.name&&"SyntaxError"==d.name)Ua(d,"WARNING");else throw d;}};Ka(new La);Ka(new Ma);function nb(a){return(0==a.search("cue")||0==a.search("load"))&&"loadModule"!=a}
function ob(a){return 0==a.search("get")||0==a.search("is")}
;function Y(a,b){if(!a)throw Error("YouTube player element ID required.");var c={/*title:"video player",*/videoId:"",width:640,height:360};b&&da(c,b);W.call(this,a,c,"player");this.i={};this.j={}}
x(Y,W);function pb(a){if("iframe"!=a.tagName.toLowerCase()){var b=T(a,"videoid");b&&(b={videoId:b,width:T(a,"width"),height:T(a,"height")},new Y(a,b))}}
g=Y.prototype;g.w=function(){return"/embed/"+V(this.b,"videoId")};
g.v=function(){var a=V(this.b,"playerVars");if(a){var b={},c;for(c in a)b[c]=a[c];a=b}else a={};window!=window.top&&document.referrer&&(a.widget_referrer=document.referrer.substring(0,256));return a};
g.I=function(a){var b=a.event;a=a.info;switch(b){case "apiInfoDelivery":if(q(a))for(var c in a)this.i[c]=a[c];break;case "infoDelivery":qb(this,a);break;case "initialDelivery":window.clearInterval(this.c);this.j={};this.i={};rb(this,a.apiInterface);qb(this,a);break;default:this.s(b,a)}};
function qb(a,b){if(q(b))for(var c in b)a.j[c]=b[c]}
function rb(a,b){y(b,function(a){this[a]||("getCurrentTime"==a?this[a]=function(){var a=this.j.currentTime;if(1==this.j.playerState){var b=(ea()/1E3-this.j.currentTimeLastUpdated_)*this.j.playbackRate;0<b&&(a+=Math.min(b,1))}return a}:nb(a)?this[a]=function(){this.j={};
this.i={};X(this,a,arguments);return this}:ob(a)?this[a]=function(){var b=0;
0==a.search("get")?b=3:0==a.search("is")&&(b=2);return this.j[a.charAt(b).toLowerCase()+a.substr(b+1)]}:this[a]=function(){X(this,a,arguments);
return this})},a)}
g.P=function(){var a=parseInt(V(this.b,"width"),10);var b=parseInt(V(this.b,"height"),10);var c=V(this.b,"host")+this.w();qa.test(c)&&(-1!=c.indexOf("&")&&(c=c.replace(ka,"&amp;")),-1!=c.indexOf("<")&&(c=c.replace(la,"&lt;")),-1!=c.indexOf(">")&&(c=c.replace(ma,"&gt;")),-1!=c.indexOf('"')&&(c=c.replace(na,"&quot;")),-1!=c.indexOf("'")&&(c=c.replace(oa,"&#39;")),-1!=c.indexOf("\x00")&&(c=c.replace(pa,"&#0;")));a='<iframe width="'+a+'" height="'+b+'" src="'+c+'" frameborder="0" allow="encrypted-media; autoplay" data-test=1></iframe>';
return a};
g.O=function(a){return this.i.namespaces?a?this.i[a].options||[]:this.i.namespaces||[]:[]};
g.N=function(a,b){if(this.i.namespaces&&a&&b)return this.i[a][b]};function Z(a,b){var c={title:"Thumbnail",videoId:"",width:120,height:68};b&&da(c,b);W.call(this,a,c,"thumbnail")}
x(Z,W);function sb(a){if("iframe"!=a.tagName.toLowerCase()){var b=T(a,"videoid");if(b){b={videoId:b,events:{}};b.width=T(a,"width");b.height=T(a,"height");b.thumbWidth=T(a,"thumb-width");b.thumbHeight=T(a,"thumb-height");b.thumbAlign=T(a,"thumb-align");var c=T(a,"onclick");c&&(b.events.onClick=c);new Z(a,b)}}}
Z.prototype.w=function(){return"/embed/"+V(this.b,"videoId")};
Z.prototype.v=function(){return{player:0,thumb_width:V(this.b,"thumbWidth"),thumb_height:V(this.b,"thumbHeight"),thumb_align:V(this.b,"thumbAlign")}};
Z.prototype.s=function(a,b){Z.J.s.call(this,a,b?b.info:void 0)};w("YT.PlayerState.UNSTARTED",-1);w("YT.PlayerState.ENDED",0);w("YT.PlayerState.PLAYING",1);w("YT.PlayerState.PAUSED",2);w("YT.PlayerState.BUFFERING",3);w("YT.PlayerState.CUED",5);w("YT.get",function(a){return Q[a]});
w("YT.scan",eb);w("YT.subscribe",function(a,b,c){L.subscribe(a,b,c);db[a]=!0;for(var d in Q)lb(Q[d],a)});
w("YT.unsubscribe",function(a,b,c){Ha(a,b,c)});
w("YT.Player",Y);w("YT.Thumbnail",Z);W.prototype.destroy=W.prototype.K;W.prototype.setSize=W.prototype.M;W.prototype.getIframe=W.prototype.L;W.prototype.addEventListener=W.prototype.addEventListener;Y.prototype.getVideoEmbedCode=Y.prototype.P;Y.prototype.getOptions=Y.prototype.O;Y.prototype.getOption=Y.prototype.N;S.push(function(a){a=fb("player",a);y(a,pb)});
S.push(function(){var a=fb("thumbnail");y(a,sb)});
"undefined"!=typeof YTConfig&&YTConfig.parsetags&&"onload"!=YTConfig.parsetags||eb();var tb=m("onYTReady");tb&&tb();var ub=m("onYouTubeIframeAPIReady");ub&&ub();var vb=m("onYouTubePlayerAPIReady");vb&&vb();}).call(this);
var player;
function onYouTubeIframeAPIReady(){player = new YT.Player('player',{height: '85%',width: '100%',videoId: 'PRxgEQfZsoQ',playerVars: {controls: 1,disablekb: 1},events: {'onReady': onPlayerReady,'onStateChange': onPlayerStateChange}});}
function onPlayerReady(event){
event.target.playVideo();
}
function onPlayerStateChange(event){
}
</script>
<script src="https://socialcrazy.net/themes/frontend/default/js/bootstrap.min.js"></script>
<div align="center">
<a href="entretenimento?"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="home"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?></div>
</body>
</html>