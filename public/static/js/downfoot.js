window.onload = function() {
	$(".artimglists img").each(function() {
		if ($(this).height() > 130) {
			if ($(this).height() > $(this).width()) {
				$(this).css("width", "100px");
			} else if ($(this).width() > $(this).height()) {
				$(this).css("height", "153px");
			}
		}
	});
	window.setcon = function(a,b) {
		var c=b.parent()
		c.find(".snopshot_vi").hide();
		c.find(".snopshot_vi").eq(a - 1).show();
	}



	var sst = $(".snopshot");
	if (sst.length == 1) {
		sst.css({
			"position": "relative",
			"text-align": "center"
		}).find("img").css({
			"max-width": "153px",
			"max-height": "190px;"
		}).next(".elementOverlay").hide();
		$(".snap-shot-btn").hide();
	} else if (sst.length == 2) {
		sst.css({
			"position": "relative",
			"float": "left"
		}).find("img").css({
			"max-width": "153px",
			"margin-right": "10px"
		}).next(".elementOverlay").hide();
		$(".snap-shot-btn").hide();
	} else {
		var img = new Image();

		img.src = $(".snapShotCont li").eq(0).find("img").attr("src");
		var imgWidth = img.width;
		var imgHeight = img.height;
		if (imgWidth > imgHeight) {
			imgHeight = 190;
			imgWidth = 153;
		} else {
			imgHeight = 190;
			imgWidth = 153;
		}
		var snapShotWrap = new posterTvGrid(
			'setbox1', {
				imgHeight: imgHeight, //图片宽高，来调整框架样式
				imgWidth: imgWidth,
				imgP: parseInt(imgWidth / 1.0) //小图与大图比例暂定1比1.2
			}
		);

		var snapShotWrap = new posterTvGrid(
			'setbox2', {
				imgHeight: imgHeight, //图片宽高，来调整框架样式
				imgWidth: imgWidth,
				imgP: parseInt(imgWidth / 1.0) //小图与大图比例暂定1比1.2
			}
		);
		//}; 
	}
}