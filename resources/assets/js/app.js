require('./bootstrap');

window.Vue = require('vue');
window.$ = require('jquery');

require('animate.css');

//列表页：当前页的分页按钮变色
$(document).ready(function () {
    var url_split = window.location.href.split('/');
    var num = url_split.length;
    for (i=0; i<num; i++) {
        if (url_split[i] === 'page') {
            result = url_split[i+1];
            break;
        }
    }
    if (typeof result === 'undefined') {
        return false;
    }
    $('.paginate_button').removeClass('active');
    $('#paginate_button_'+result).addClass('active');
    $('#paginate_button_'+result+' a').removeAttr("href");
});