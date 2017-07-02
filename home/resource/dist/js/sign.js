!(function ($, w, d) {

    // 登陆注册切换
    var $controller = $('.sign-controller-item').find('a');
    var $container = $('.sign-container-item');

    $controller.on('click',function(event){
        event.preventDefault();
        var $this = this;
        var index = $controller.index($this);
        var active = 'is-active';

        $container.removeClass(active).eq(index).addClass(active);

        $controller.removeClass(active).eq(index).addClass(active);
        

    });



})($, window, document)