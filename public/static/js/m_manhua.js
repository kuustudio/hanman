;(function(){
    soft = {
        loadFn:function(){
            if($('.d_stickup2').length>0){
                $('.d_stickup2').html('xiaomanquan');
            }
        },
        m_nav : function(){
            var mySwiper = new Swiper('.m_banner',{
                pagination : '.swiper-pagination',
                autoplay: 5000,//可选选项，自动滑动
                paginationClickable :true,//可点击切换
            })
            $(".m_ph_p1").each(function(){
                var maxwidth=18;
                if($(this).text().length>maxwidth){
                    $(this).text($(this).text().substring(0,maxwidth));
                    $(this).html($(this).html()+'...');
                }
            });
        },
        m_header:function(){
            $(".m_logo").after('<a href="javascript:;" class="l_app_href3"><i></i><span>关注公众号</span></a>');
        },
        m_recently : function(){
            var swiper = new Swiper('.m_recently_swiper', {
                slidesPerView: 3.8,
                pagination: {
                  el: '.swiper-pagination',
                  clickable: true,
                },
                spaceBetween: 10,
            });
        },
        m_whole : function(){
            $(".m_whole_table a").click(function(){
                $(this).addClass('active').siblings().removeClass('active');
                $('.m_ph_ul').eq($(this).index()).show().siblings().hide();
            })
        },
        d_he_zk : function(){//详情页展开效果
            var d_he = $(".d_cen_ul li").length;
            $(".d_he_zk i").click(function(){
                $(this).hide();
                $(".d_he_tit").css("height","auto");
            })
            $(".d_cen_look").click(function(){
                if(d_he>=17){
                    $(this).hide();
                    $(".d_cen_ul").css("height","auto");
                }
            })

            //阅读完整小说
            var copyTxt='xiaomanquan';
            $(".d_header").after('' +
                '<div class="d_want">' +
                '<p class="d_want_p">' +
                '<textarea cols="1" rows="1" id="biao1"></textarea>' +
                '想要看完整无修版漫画请根据下面步骤操作</p>' +
                '<ul class="d_want_ul">' +
                '<li>1、点击复制按钮，进入微信</li>' +
                '<li>2、搜索框粘贴复制的文字进入公众号</li>' +
                '<li>3、搜索你想看的漫画名称即可阅读无删减版(完整版)漫画</li>' +
                '<span class="d_stickup">'+copyTxt+'</span>' +
                '<a class="d_copy" href="javascript:;">复制</a></ul></div>');
            //复制   点击d_copy  复制d_stickup的内容
            if($('.d_copy').length>0){
                $('.d_copy').attr('data-clipboard-action','copy');
                $('.d_copy').attr('data-clipboard-text',copyTxt);
                
            }
            if($('.d_copy2').length>0){
                $('.d_copy2').attr('data-clipboard-action','copy');
                $('.d_copy2').attr('data-clipboard-text',copyTxt);

            }
            $(".d_copy").click(function(){
                //复制内容到剪切板
                new ClipboardJS('.d_copy');
            })
            $(".d_copy2").click(function(){
                //复制内容到剪切板
                new ClipboardJS('.d_copy2');
            })
        },
        r_look:function(){
            

            $(".l_top_r,.l_top_r2,.s_page3").click(function(){
                $(".l_top_r").addClass("l_top_r2");
                $(".mask_bg").css("top",$(".l_top").height()+20);
                $(".mask_bg").css("height",$(window).height());
            
                $(".mask,.mask_bg").toggle();
                $("body").css("overflow","hidden");

                var a=$(".mask").attr("class")
                if(a.indexOf("op")<0){
                    $(".mask").attr("class","mask op");
                    $("body").css("overflow","hidden");
                }else{
                    $(".mask").attr("class","mask");
                    $("body").css("overflow","auto");
                }
            })
            $(".mask").click(function(){
                $(".mask,.mask_bg").toggle();
                $(".mask").attr("class","mask");
                $("body").css("overflow","auto");
            })

            //限制字数
            $(".l_top_l span").each(function(){
                var maxwidth=15;
                if($(this).text().length>maxwidth){
                    $(this).text($(this).text().substring(0,maxwidth));
                    $(this).html($(this).html()+'...');
                }
            });
            $(".l_foot_next").after('<a class="l_app_href1" href="javascript:;"><i></i><span>关注公众号</span></a>');
            $(".statement_tit").after('<a class="l_app_href2" href="javascript:;"><i></i><span>下载APP查看更多精彩内容</span></a>');
        },
        //列表页
        list_open:function(){
            var list = $(".d_cen_ul").height();
            if(list>200){
                $(".d_cen_ul").css("height","200px");
                $(".d_cen_look").css("display","block");
            }
            $(".d_cen_look").click(function(){
                $(".d_cen_ul").css("height","auto");
                $(".d_cen_look").css("display","none");
            })
        },
        //回到顶部
        goTop:function(){
            // 滑动滚动条
            $(window).scroll(function(){
                if($(window).scrollTop() >= 1000){
                    $("#goTop").fadeIn(1000);
                }else{
                $("#goTop").stop(true,true).fadeOut(1000); 
                }
            });
            $("#goTop a").click(function(){
                $('html,body').animate({
                    scrollTop: 0
                }, 700);
            })
        },
        //文章页
        art_read:function(){
            //限制字数
            $(".art_top_p u").each(function(){
                var maxwidth=30;
                if($(this).text().length>maxwidth){
                    $(this).text($(this).text().substring(0,maxwidth));
                    $(this).html($(this).html()+'...');
                }
            });
        },
        //文章列表
        list_article:function(){
            $(".list_tab a,.list_atricle a").click(function(){
                $(this).addClass('active').siblings().removeClass('active');
            })
        },
        clickFn:function(){
            $(document).on('click','.l_app_href1,.l_app_href2,.l_app_href3',function(){
                _hmt.push(['_trackEvent', 'tjAPP', 'click']);
            })
        },
        invoke : function(){
            //this.disabFn();
            this.loadFn();
            this.m_nav();
            this.m_recently();
            this.m_whole();
            this.d_he_zk();
            this.r_look();
            this.list_open();
            this.goTop();
            this.m_header();
            this.art_read();
            this.list_article();
            this.clickFn();
        }
    }
    soft.invoke();
})();



$(".l_cen").click(function(){
    fz();
});

var fz=function(){
    //$(".l_progressBar").fadeIn();
    var a =$(".l_cen").height();//整个漫画内容的高度
    var cc = $(this).height();//当前页面高度
    var c1 = $(document).scrollTop()+cc-50;//滚动的高度加上当前页面高度再减去padding的50px
    var c2 = c1/a;
    var c3 = parseFloat(c2).toFixed(2)*100;//转换
    //console.log(c1+':滚动的高度'+'--------当前页面高度'+a+'----------百分比'+c3+'%');
    $(".l_progressBar_r i").css("height",c3+'%');
    $(".l_progressBar_r span").css("top",c3-4+'%');
}

$(window).scroll(function(){
    
    var before = $(window).scrollTop();
    //$(".l_progressBar").fadeOut();
    
    if ($(document).scrollTop() >= $(document).height() - $(window).height()) {
        fz();
    }
    $(window).scroll(function() {
        var after = $(window).scrollTop();
        if (before<after) { 
           if($(document).scrollTop()>=60){
                $(".l_top").show();
                $(".l_top").css("position","fixed");
            }
          // window.atime=setTimeout(function(){
          //       $(".l_top").hide();
          //   }, 3000);
           //console.log(111)
        };
        if (before>after){
            $(".l_top").show();
            // atime.clearInterval(atime)
            $(".l_top").css("position","fixed");
            if($(document).scrollTop()>=60){
                $(".l_top").show();
                $(".l_top").css("position","fixed");
            }else{
                $(".l_top").hide();
                $(".l_top").css("position","relative"); 
            }
            //console.log(222)
        }
    });
});
