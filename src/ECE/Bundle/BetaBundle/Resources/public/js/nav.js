$(document).ready(function () {

$('.nav li').hover(
function () {
//show its submenu
$('ul', this).slideDown(100);

},
function () {
//hide its submenu
$('ul', this).slideUp(100);
}
);

$('#pictures').click(
function () {
//show its submenu
$('#pictures').addClass('active');
$('#videos').removeClass('active');
$('#music').removeClass('active');
$('#locations').removeClass('active');
$('#feeds').removeClass('active');
$('#other').removeClass('active');
$('#favoris').removeClass('active');

}
);

$('#videos').click(
function () {
//show its submenu
$('#videos').addClass('active');
$('#pictures').removeClass('active');
$('#music').removeClass('active');
$('#locations').removeClass('active');
$('#feeds').removeClass('active');
$('#other').removeClass('active');
$('#favoris').removeClass('active');

}
);

$('#music').click(
function () {
//show its submenu
$('#music').addClass('active');
$('#pictures').removeClass('active');
$('#videos').removeClass('active');
$('#locations').removeClass('active');
$('#feeds').removeClass('active');
$('#other').removeClass('active');
$('#favoris').removeClass('active');

}
);
$('#locations').click(
function () {
//show its submenu
$('#locations').addClass('active');
$('#pictures').removeClass('active');
$('#music').removeClass('active');
$('#videos').removeClass('active');
$('#feeds').removeClass('active');
$('#other').removeClass('active');
$('#favoris').removeClass('active');

}
);

$('#feeds').click(
function () {
//show its submenu
$('#feeds').addClass('active');
$('#pictures').removeClass('active');
$('#music').removeClass('active');
$('#videos').removeClass('active');
$('#locations').removeClass('active');
$('#other').removeClass('active');
$('#favoris').removeClass('active');

}
);
$('#other').click(
function () {
//show its submenu
$('#other').addClass('active');
$('#pictures').removeClass('active');
$('#music').removeClass('active');
$('#videos').removeClass('active');
$('#locations').removeClass('active');
$('#feeds').removeClass('active');
$('#favoris').removeClass('active');

}
);
$('#favoris').click(
function () {
//show its submenu
$('#favoris').addClass('active');
$('#pictures').removeClass('active');
$('#music').removeClass('active');
$('#videos').removeClass('active');
$('#locations').removeClass('active');
$('#feeds').removeClass('active');
$('#other').removeClass('active');

}
);

$(function() {

$('#navigation a').stop().animate({'marginLeft':'-55px'},1000);

$('#navigation > li').hover(
function () {
$('a',$(this)).stop().animate({'marginLeft':'-2px'},200);
},
function () {
$('a',$(this)).stop().animate({'marginLeft':'-55px'},200);
}
);
});
$(function() {
$('#navigation > li').hover(
function () {
$('a',$(this)).stop().animate({'marginLeft':'-2px'},200);
},
function () {
$('a',$(this)).stop().animate({'marginLeft':'-55px'},200);
}
);
});
});