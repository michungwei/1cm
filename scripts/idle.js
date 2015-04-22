$(window).load(function() {
	OpenIdleFrame();
	/*$('.fancybox').fancybox({
		afterClose: function() {
			$.idle(function(){
				if( jQuery(window).width() > 767 )
				{
					$.fancybox.open({
						href: 'idle.php',
						type: 'iframe',
						padding: 0,
						scrolling: 'no',
						width: 750,
						height: 730,
						overlayShow: true,
						"openEffect": "elastic",
						"closeEffect": "elastic"
					});
				}
			}, 30000);	
			console.log("close idle!!");
		}
	});*/
});

function OpenIdleFrame()
{
	var lastX = 0;
	var lastY = 0;
	console.log("openIdleFrame");
	$(document).mousemove(function(e) {
		/*console.log("mousemove!!");
		console.log("x: "+e.pageX+" y: " +e.pageY);*/
		/*console.log("x: "+e.pageX+" y: " +e.pageY);
		console.log("lastX: "+lastX+" lastY: " +lastY);*/
		if(e.pageX != lastX || e.pageY != lastY)
		{
			//console.log("mouse no move!!");
			$.idle(function(){
				if( jQuery(window).width() > 767 )
				{
					$.fancybox.open({
						href: 'idle.php',
						type: 'iframe',
						padding: 0,
						scrolling: 'no',
						width: 750,
						height: 760,
						overlayShow: false,
						"openEffect": "elastic",
						"closeEffect": "elastic",
						autoSize : false,
						fitToView   : false,
						afterClose: function() {
							OpenIdleFrame();
							console.log("close idle!!");
						}
					});
				}
			}, 150000);	
		}
		lastX = e.pageX;
		lastY = e.pageY;
	});
}