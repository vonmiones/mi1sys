<script src="themes/<?= TEMPLATE; ?>/assets/flip/flip.min.js"></script>
<script src="themes/<?= TEMPLATE; ?>/assets/fontawesome/js/fontawesome.min.js"></script>
<script src="themes/<?= TEMPLATE; ?>/assets/fontawesome/js/duotone.min.js"></script>
<script>
	$(document).ready(function() {
		var isShown = false;
		var activeMenu = "";
		var activeContent = "";
		$('#sidebar-primary ul li').each(function(index, el) {
			$(el).click(function(event) {
				var p = $(el).data('page');
				var n = $(el).data('navigate');
				console.log(n + " = " + activeMenu);
				if (n != "") {
					$("#sidebar-secondary").load('?page='+p+'&form=secondary/'+n,function() {
						$('div#sidebar-left ul li').each(function(index, el2) {
							// console.log(el2);
							$(el2).click(function(event) {
								var pc = $(el2).data('page');
								var nc = $(el2).data('navigate');
								var mc = $(el2).data('module');
								console.log(nc + " = " + activeContent);
								if (nc != "") {
									// $("#content-wrapper").load('?page='+pc+'&form='+nc+'/'+mc,function() {
									// });
									// if (activeContent != nc) {
									// 	$("#sidebar-secondary").removeClass('open');
									// 	setTimeout(function() {
									// 		console.log("Open Again");
									// 		$("#sidebar-secondary").addClass('open');
									// 	},300);
									// }else{
									// 	$("#sidebar-secondary").toggleClass('open');
									// }
								}
								activeContent = nc;
							});
						});

					});
					if (activeMenu != n) {
						$("#sidebar-secondary").removeClass('open');
						setTimeout(function() {
							console.log("Open Again");
							$("#sidebar-secondary").addClass('open');
						},300);
					}else{
						$("#sidebar-secondary").toggleClass('open');
					}
				}
				activeMenu = n;
			});
		});		

	});
</script>