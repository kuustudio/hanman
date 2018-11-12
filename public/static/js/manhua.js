
// 页面分享功能
with (document) {
    var object = 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion=' + ~(-new Date() / 36e5)];
}
$(".red_total_a3 span").after("<div class='Ashar_box'><div class='bdsharebuttonbox bdshare-button-style0-16' data-bd-bind='1504167374698'><a href='javascript:;' class='Abds_sqq' data-cmd='sqq'></a><a href='javascript:;' class='Abds_weixin' data-cmd='weixin' title='分享到微信'></a></div></div>");


;(function(){
    soft = {
        m_nav : function(){
            $(".m_nav a,.m_new_day a,.m_new_tabs a").click(function(){
                $(this).addClass('active').siblings().removeClass('active');
            })
        },
        //首页左侧导航
        m_fixed :function(){
            $(".m_fixed_ul li").click(function(){
                $(this).addClass('active').siblings().removeClass('active');
            })
        },
        //详情页的背景   
        details_bg:function(){
            var img2 = $(".d_bgi_href img").attr('src');
            $(".d_bgs .d_bgi").after('<div class="details_bgs"><img src="'+img2+'"/></div>')
        },
        //
        m_day :function(){
            var appendNumber = 4;
            var prependNumber = 1;
            var swiper = new Swiper('.m_day_ftop', {
                nextButton: '.swiper-button-next',
                prevButton: '.swiper-button-prev',
                slidesPerView: 1,
                centeredSlides: true,
                paginationClickable: true,
                spaceBetween: 18,
                loop : true,
            });
        },
        //回到顶部
        m_top :function(){
            //var m_content = $(".m_content").offset().top;
            var m_content = ($('.m_content').offset() || { "top": NaN }).top;
            if (isNaN(top)) {
                $(window).scroll(function(){
                  var scrollTop = $(this).scrollTop();
                  if(scrollTop >=m_content ){
                    $(".m_fixed").css("top","100px");
                  }else{
                    $(".m_fixed").css("top","300px");
                  }
                });
            }
            //  else {
            //     alert(top);
            // }
            

            $(".m_fixed_top,.fi_go_back").click(function(){
                $('html,body').animate({
                    scrollTop: 0
                }, 700);
            })
        },
        //banner图
        m_banner : function(){
            var mySwiper = new Swiper('.m_banner',{
                pagination : '.swiper-pagination',
                autoplay: 5000,//可选选项，自动滑动
                paginationClickable :true,//可点击切换
            })
        },
        //最新更新的选项
        m_new : function(){
            $(".m_new .m_new_tabs a").click(function(){
                $(this).addClass('active').siblings().removeClass('active');
                $('.m_new .m_ph_ul').eq($(this).index()).show().siblings().hide();
            })
        },
        //最热漫画的选项
        m_hot : function(){
            $(".m_hot .m_new_tabs a").click(function(){
                $(this).addClass('active').siblings().removeClass('active');
                $('.m_hot .m_ph_ul').eq($(this).index()).show().siblings().hide();
            })
        },
        //右侧的列表hover时候的效果
        m_ph : function(){
            $(".m_ph_ul li").hover(function(){
                $(this).addClass('active').siblings().removeClass('active');
                },function(){
            });
        },
        //列表页面的排序和题材
        l_nav : function(){
            $(".l_nav a,.l_tab_ul li a").click(function(){
                $(this).addClass('active').siblings().removeClass('active');
            })
        },
        //点击查看更多章节
        d_menu_much : function(){
            var much = $(".d_menu ul li").length;
            if(much>=25){
                $(".d_menu_much").css("display","block");
                $(".d_menu_much").click(function(){
                    $(this).hide();
                    $(".d_menu ul").css("max-height","none");
                })
            }
        },

        //排序
        d_inverted : function(){
            $(".d_menu ul li").each(function(){
                var tsi=$(this).index();
                $(this).attr("idx",tsi); 
            })
            
            $(".d_inverted").click(function() {
                var orderIdArray = [];
                var idIndex = [];
                var mode = $(this).attr("mode");
                var orderid = $(".d_menu ul li");

                orderid.each(function(i) {
                    var id = parseInt($(this).attr("idx"));
                    idIndex[id] = i;        //orderid的序号
                    orderIdArray.push(id);  //orderid的值
                });
                //index的值是从大到小的，所以此处的大于号和小于号是相反的
                if(mode == 1) 
                {
                    $(this).attr("mode", 0);
                    $(this).html("倒序");
                    orderIdArray = orderIdArray.sort(function(a, b){return (a > b) ? 1 : -1}); //从大到小排序 
                    $(".d_inverted").removeClass("d_positive");
                } 
                else if(mode == 0) 
                {
                    $(this).attr("mode", 1);
                    $(this).html("正序");
                    orderIdArray = orderIdArray.sort(function(a, b){return (a < b) ? 1 : -1}); //从小到大排序
                    $(".d_inverted").addClass("d_positive");
                }

                var list = $(".d_menu ul").find("li");
                var _length = orderIdArray.length;

                for (var i=0; i<_length; i++){
                    $(".d_menu ul").append(list.eq(idIndex[orderIdArray[i]]));
                } 
            });
        },
        //list页面数据为空时候
        List_kong:function(){
            var Length = $(".m_new_ul li").length;
            if(Length==0){
                $(".s_404").show();
            }
        },
        //阅读页
        red_none:function(){
            //var r_img = $(".r_img").offset().top;
            var r_img = ($('.r_img').offset() || { "top": NaN }).top;
            $(window).scroll(function(){
              if (isNaN(top)){ 
                  var scrollTop = $(this).scrollTop();
                  if(scrollTop >=r_img ){
                    $(".fi_foot").fadeIn();
                    //hover
                    // $(".fi_classify_img").hover(function(){
                    //     $(".fi_classify,.fi_classify_after").slideDown("slow");
                    // },function(){
                    //     $("body").click(function(){
                    //         $(".fi_classify,.fi_classify_after").slideUp("hide")
                    //     })
                    // });
                    $(".fi_classify_img").click(function(){
                        $(".fi_classify,.fi_classify_after").toggle();
                        return false;
                    });

                    $(document).click(function(event){
                        var _con = $(".fi_classify,.fi_classify_after")  // 设置目标区域
                        if(!_con.is(event.target) && _con.has(event.target).length === 0){ // Mark 1
                           $(".fi_classify,.fi_classify_after").hide();
                        }
                   });


                  }else{
                    $(".fi_foot").fadeOut();
                  }
              } 
            });

            //回到顶部按钮的距离
            
            var fi_go = ($('.m_content').offset() || { "top": NaN }).left;
            if (isNaN(top)){
                $(".fi_go").css("right",fi_go-50);
            }

            $(".fi_classify_ul").css("height",$(window).height()/1.2);

            //弹窗
            $(".fi_dialog_r span").click(function(){
                $(".fi_mask,.fi_dialog").hide();
                $(".r_body").removeClass("r_body_hidden");
            })
        },
        //分享
        reg_share:function(){
            $(".reg_share").hover(function(){
                $(".reg_totalS").fadeIn();
            },function(){
                $(".reg_totalS").fadeOut();
            });
            // $(".reg_share").click(function(){
            //     $(".reg_totalS").toggle();
            // })
        //收藏
            $(".reg_collect,.d_bg_collect").click(function(){
                $(".fi_mask,.reg_mask").show();
            })
            $(".reg_mask_button,.fi_mask").click(function(){
                $(".fi_mask,.reg_mask").hide();
            })
        //复制链接 
            $(".red_total_a1").click(function(){
                //复制内容到剪切板
                var Url2=document.getElementById("biao1");
                var Url = window.location.href;
                Url2.innerHTML = Url;
                Url2.select(); // 选择对象
                document.execCommand("Copy"); // 执行浏览器复制命令
                $(".reg_lianjie h3").text(Url);
                $(".fi_mask,.reg_lianjie").show();
            })
            $(".fi_mask,.reg_lianjie a").click(function(){
                $(".fi_mask,.reg_lianjie").hide();
            })
        },
        invoke : function(){
            this.m_nav();
            this.m_banner();
            this.m_new();
            this.m_hot();
            this.m_ph(); 
            this.l_nav();
            this.m_fixed();  
            this.m_top();
            this.m_day();
            this.d_menu_much();
            this.d_inverted();
            this.red_none();
            this.List_kong();
            this.details_bg();
            this.reg_share();
        }
    }
    soft.invoke();
})();


//全屏显示
var $fullScreen = document.getElementById("fi_quanping");//按钮 
if ($fullScreen) { 
  $fullScreen.addEventListener("click", function () { 
    var docElm = document.documentElement; 
    if (docElm.requestFullscreen) { 
      docElm.requestFullscreen(); 
    } 
    else if (docElm.msRequestFullscreen) { 
      docElm.msRequestFullscreen(); 
    } 
    else if (docElm.mozRequestFullScreen) { 
      docElm.mozRequestFullScreen(); 
    } 
    else if (docElm.webkitRequestFullScreen) { 
      docElm.webkitRequestFullScreen(); 
    } 
  }, false); 
}

//键盘操作
$(document).keydown(function (event) {
    var a = $(".r_exit_read").length;
    var up_href = $(".r_tab_up").attr("href");
    var do_down = $(".r_tab_down").attr("href");

    if(a>=1){
        switch (event.keyCode) {
        case 37:
            //console.log("向左");
            window.location.href=up_href;
            break;
        case 39:
            //console.log('方向键-右');
            window.location.href=do_down;
            break;
        };
        //console.log("有这个值");
    }else{
        //console.log("你是胡写的");
    }
    
    
});
