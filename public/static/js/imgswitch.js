
(function($){
    var browserV = (navigator.userAgent.toLowerCase().match( /.+(?:ie)[\/: ]([\d.]+)/ ) || [0,'0'])[1];
    var browserVersion = (browserV == "2.0" || browserV == "1.0")? false : true;
    var posterTvGrid = function(o, options){
    this.parent = $("." + o);
    this.body = $("body");
    if(this.parent.length <= 0){
    return false;
    }
    $(".snopshot:eq(0) span").removeClass("elementOverlay").addClass("elementOverlays");
this.options = $.extend({}, posterTvGrid.options, options);
this.reset(); //resize
var _this = this;
$(window).resize(function(){
    _this.reset();
    });
};
posterTvGrid.prototype = {
    
    //初始化
    reset : function(options){
    if(typeof(options) == 'object'){
    $.extend(this.options, options);
    }
this.total = this.parent.find("img").length; //总的图片数量
this.pageNow = this.options.initPage; //当前显示第几条
this.preLeft = 0;
this.nextLeft = this.options.width-this.options.imgP;
this.preNLeft = -this.options.imgP;
this.nextNLeft = this.options.width;
this.pageNowLeft = (this.options.width-this.options.imgWidth)/2//居中的当前图
this.drawContent(); //根据图片尺寸设定区域的样式
},
drawContent : function(){
    this.parent.css({height:this.options.imgHeight+"px"});
this.parent.find(".snapShotCont").css({height:this.options.imgHeight+"px"});
this.parent.find(".snopshot").css({width:'0px', opacity: 0, left:this.options.width/2+'px', zIndex:0, marginTop: '135px'});
this.parent.find(".snopshot:nth-child("+this.pageNow+")").css({width:this.options.imgWidth+'px',height:this.options.imgHeight+'px',opacity:1,left:this.pageNowLeft+'px',zIndex:3,marginTop:0});
var pre = this.pageNow > 1 ? this.pageNow-1 : this.total;
var next = this.pageNow == this.total ? 1 : this.pageNow+1;
//只变宽度，让高度自己去等比压缩
this.parent.find(".snopshot:nth-child("+pre+")").css({opacity: 1, left: this.preLeft+'px', width: this.options.imgP+'px', zIndex: 0, marginTop: this.options.imgHeight/12+'px'});
this.parent.find(".snopshot:nth-child("+next+")").css({opacity: 1, left: this.nextLeft+'px',width: this.options.imgP+'px', zIndex: 0, marginTop: this.options.imgHeight/12+'px'});
this.bind();
//this.start();
},
bind : function(){
    this.leftNav = this.parent.find(".shotPrev");
    this.rightNav = this.parent.find(".shotNext");
    var _this = this;
    //_this.parent.mouseover(function(){
    //_this.stop();
    //_this.leftNav.show();
    //_this.rightNav.show();
    //}).mouseout(function(){
    //_this.start();
    //});
_this.leftNav.click(function(){
    _this.turn("right");
    });
_this.rightNav.click(function(){
    _this.turn("left");
    });
},
start: function(){
    var _this = this;
    if(_this.timerId) _this.stop();
    _this.timerId = setInterval(function(){
    _this.turn(_this.options.direct);
    }, _this.options.delay);
},
stop: function(){
    clearInterval(this.timerId);
    },
turn : function(dir){
    var _this = this;

    if(dir == "right"){
    var page = _this.pageNow -1;
    if(page <= 0) page = _this.total;
    }else{
    var page = _this.pageNow + 1;
    if(page > _this.total) page = 1;
    }
    _this.turnpage(page, dir);
    var tsindex=this.leftNav.selector.split(" ")[0]
    var z=$(""+tsindex+"")
    setcon(page,z);
},
turnpage : function(page,dir){
    var _this = this;
    if(_this.locked) {
    return false;
    } //开关变量
_this.locked = true;
if(_this.pageNow == page) return false; //如果刚好是当前页面,除非有nav，否则一般不会出现
//主要的动画函数
var run = function(page, dir, t){
    var pre = page > 1 ? page -1: _this.total;
    var next = page == _this.total ? 1 : page + 1;
    var preP = pre - 1 >= 1 ? pre-1 : _this.total;
    var nextN = next + 1 > _this.total ? 1 : next+1;
    if(dir == 'left'){
    //当前的变成左边的小图
_this.parent.find(".snopshot:nth-child("+_this.pageNow+")").css({zIndex: 0});
_this.parent.find(".snopshot:nth-child("+pre+")").css({zIndex: 2});
if(browserVersion){
    //_this.parent.find(".snopshot:nth-child("+pre+")").find(".elementOverlay").css({opacity: 0.4});
    _this.parent.find(".snopshot:nth-child("+pre+")").find("span").removeClass("elementOverlays").addClass("elementOverlay");
}
_this.parent.find(".snopshot:nth-child("+pre+")").animate({opacity: 1, left: _this.preLeft+'px', width: _this.options.imgP + 'px', height:_this.options.imgHeight/1.2+'px', zIndex: 2, marginTop: _this.options.imgHeight/12+'px'}, t);

//显示新的最大图
_this.parent.find(".snopshot:nth-child("+page+")").css({zIndex: 3});
//_this.parent.find(".snopshot:nth-child("+page+")").find(".elementOverlay").css({opacity:0});
if(browserVersion){
    //_this.parent.find(".snopshot:nth-child("+page+")").find(".elementOverlay").css({opacity: 0});
    //_this.parent.find(".snopshot:nth-child("+page+")").find(".elementOverlay").addclass("picbgs");
    _this.parent.find(".snopshot:nth-child("+page+")").find("span").removeClass("elementOverlay").addClass("elementOverlays");
    //_this.parent.find(".snopshot:eq("+page+") span").remove();

}
_this.parent.find(".snopshot:nth-child("+page+")").animate({width:_this.options.imgWidth + 'px',height:_this.options.imgHeight + 'px',opacity:1,left:_this.pageNowLeft + 'px',zIndex:3,marginTop:0}, t);


_this.parent.find(".snopshot:nth-child("+next+")").css({opacity: 0, left: _this.nextNLeft+'px', height: '100px', width: _this.options.imgP + 'px', zIndex: 2, marginTop: '85px'});
if(browserVersion){
    //_this.parent.find(".snopshot:nth-child("+next+")").find(".elementOverlay").css({opacity: 0.4});
    _this.parent.find(".snopshot:nth-child("+next+")").find("span").removeClass("elementOverlays").addClass("elementOverlay");
}
_this.parent.find(".snopshot:nth-child("+next+")").animate({opacity: 1, left: _this.nextLeft+'px', width: _this.options.imgP + 'px', height:_this.options.imgHeight/1.2+'px', zIndex: 2, marginTop: _this.options.imgHeight/12 + 'px'}, t, "",function(){
    if(_this.total === 3){
        _this.locked=false;
    }
});


if(_this.total != 3){
    _this.parent.find(".snopshot:nth-child("+preP+")").css({zIndex:0});
    if(browserVersion){
        //_this.parent.find(".snopshot:nth-child("+preP+")").find(".elementOverlay").css({opacity: 0.4});
        _this.parent.find(".snopshot:nth-child("+preP+")").find("span").removeClass("elementOverlays").addClass("elementOverlay");
    }
    _this.parent.find(".snopshot:nth-child("+preP+")").animate({width:_this.options.imgP+'px', opacity: 0, left:_this.preNLeft+'px', zIndex:0, marginTop: '85px'},t, "", function(){_this.locked=false;});
}
} else{
    _this.parent.find(".snopshot:nth-child("+_this.pageNow+")").css({zIndex: 0});

_this.parent.find(".snopshot:nth-child("+next+")").css({zIndex: 2});
if(browserVersion){
    //_this.parent.find(".snopshot:nth-child("+next+")").find(".elementOverlay").css({opacity: 0.4});
    _this.parent.find(".snopshot:nth-child("+next+")").find("span").removeClass("elementOverlays").addClass("elementOverlay");
}
_this.parent.find(".snopshot:nth-child("+next+")").animate({opacity: 1, left: _this.nextLeft+'px', width: _this.options.imgP + 'px', height:_this.options.imgHeight/1.2+'px', zIndex: 2, marginTop: _this.options.imgHeight/12+'px'}, t);


//显示新的最大图
_this.parent.find(".snopshot:nth-child("+page+")").css({zIndex: 3});

        if(browserVersion){
           // _this.parent.find(".snopshot:nth-child("+page+")").find(".elementOverlay").css({opacity: 0});
            
    _this.parent.find(".snopshot:nth-child("+page+")").find("span").removeClass("elementOverlay").addClass("elementOverlays");
    
        //_this.parent.find(".snopshot:eq("+page+") span").remove();
    
        }
_this.parent.find(".snopshot:nth-child("+page+")").animate({width:_this.options.imgWidth + 'px',height:_this.options.imgHeight + 'px',opacity:1,left:_this.pageNowLeft + 'px',zIndex:3,marginTop:0}, t);


_this.parent.find(".snopshot:nth-child("+pre+")").css({opacity: 0, left: _this.preNLeft+'px', height: '100px', width: _this.options.imgP + 'px', zIndex: 2, marginTop: '85px'});
        if(browserVersion){
            //_this.parent.find(".snopshot:nth-child("+pre+")").find(".elementOverlay").css({opacity: 0.4});
    _this.parent.find(".snopshot:nth-child("+pre+")").find("span").removeClass("elementOverlays").addClass("elementOverlay");
        }
_this.parent.find(".snopshot:nth-child("+pre+")").animate({opacity: 1, left: _this.preLeft+'px', width: _this.options.imgP + 'px', height:_this.options.imgHeight/1.2+'px', zIndex: 2, marginTop: _this.options.imgHeight/12 + 'px'}, t, "",function(){
    if(_this.total === 3){
        _this.locked = false;
    }
});


        if(_this.total != 3){
            _this.parent.find(".snopshot:nth-child("+nextN+")").css({zIndex:0});
            if(browserVersion){
                //_this.parent.find(".snopshot:nth-child("+nextN+")").find(".elementOverlay").css({opacity: 0.4});
            _this.parent.find(".snopshot:nth-child("+nextN+")").find("span").removeClass("elementOverlays").addClass("elementOverlay");
            }
            _this.parent.find(".snopshot:nth-child("+nextN+")").animate({width:_this.options.imgP+'px', opacity: 0, left:_this.nextNLeft+'px', zIndex:0, marginTop: '85px'},t, "", function(){_this.locked=false;});
        }
}
_this.pageNow = page;
};//函数结束
run(page,dir,_this.options.speed);
}
};
posterTvGrid.options = {
    total : 5,
    offsetPages : 3,//默认可视最大条数
    direct : "left",//滚动的方向
    initPage : 1,//默认当前显示第几条
    className : "snapShotWrap",//最外层样式
    autoWidth : true,//默认不用设置宽
    width : 440,//最外层宽，需要使用的时候在传,默认由程序自动判断
    height : 310,//最外层高
    delay : 5000,//滚动间隔（毫秒）
    speed : 500, //滚动速度毫秒
    imgP : 200 //图片偏移
    };
window.posterTvGrid = posterTvGrid;
})(jQuery);