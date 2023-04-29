<div class="container">
  <div class="row">
	<!--  Queue -->
  	<div class="col-lg-3 col-md-3">
		<div data-id="1" class="card border-warning" style="width: 18rem;">
			  <div class="card-header text-white bg-warning mb-3">
			     <div style="cursor: pointer;" id="add_entity" ><i class="fad fa-plus orange-accent" aria-hidden="true"></i> Waiting List</div>
			  </div>
			  <div class="list-group-item">
				  <div data-order="1" class="list-item">Cras justo odio</div>
			  </div>
			  <div class="list-group-item">
				  <div data-order="2" class="list-item">Cras justo odio</div>
			  </div>
			  <div class="list-group-item">
				  <div data-order="3" class="list-item">Cras justo odio</div>
			  </div> 
		</div>
    </div>
    <!-- Queue End -->
	<!--  Queue -->
  	<div class="col-lg-3 col-md-3">
		<div data-id="2" class="card border-primary" style="width: 18rem;">
			  <div class="card-header text-white bg-primary mb-3">
			    Scanned
			  </div>
			  <div class="list-group-item">
				  <div data-order="4" class="list-item">Cras justo odio</div>
			  </div>
			  <div class="list-group-item">
				  <div data-order="5" class="list-item">Cras justo odio</div>
			  </div>
			  <div class="list-group-item">
				  <div data-order="6" class="list-item">Cras justo odio</div>
			  </div> 
		</div>
    </div>
    <!-- Queue End -->
	<!--  Queue -->
  	<div class="col-lg-3 col-md-3">
		<div data-id="3" class="card border-info" style="width: 18rem;">
			  <div class="card-header text-white bg-info mb-3">
			    Validated
			  </div>
			  <div class="list-group-item">
				  <div data-order="7" class="list-item">Cras justo odio</div>
			  </div>
			  <div class="list-group-item">
				  <div data-order="8" class="list-item">Cras justo odio</div>
			  </div>
			  <div class="list-group-item">
				  <div data-order="9" class="list-item">Cras justo odio</div>
			  </div> 
		</div>
    </div>
    <!-- Queue End -->
	<!--  Queue -->
  	<div class="col-lg-3 col-md-3">
		<div data-id="4" class="card border-success" style="width: 18rem;">
			  <div class="card-header text-white bg-success mb-3">
			    Released
			  </div>
			  <div class="list-group-item">
				  <div data-order="10" class="list-item">Cras justo odio</div>
			  </div>
			  <div class="list-group-item">
				  <div data-order="11" class="list-item">Cras justo odio</div>
			  </div>
			  <div class="list-group-item">
				  <div data-order="12" class="list-item">Cras justo odio</div>
			  </div> 
		</div>
    </div>
    <!-- Queue End -->
  </div>

</div>



 <div class="modal fade"  data-backdrop="static" role="dialog" tabindex="-1" id="toolModal" style="min-width: 800;">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button class="btn btn-primary" id="btn-print" type="button">Print Request</button> -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="toolbox">
                	
                	<div class="container">
                		<div class="row">            			
		                    <form>
		                      <center><h1 id="full_name"></h1></center>
		                      <div class="form-row" style="display: flex;">
		                        <div class="col-lg-3" style="display: block; margin-right:10px;">
		                          <input id="last_name" type="text" class="form-control" placeholder="Last name">
		                        </div>
		                        <div class="col-lg-3" style="display: block; margin-right:10px;">
		                          <input id="first_name" type="text" class="form-control" placeholder="First name">
		                        </div>
		                        <div class="col-lg-3" style="display: block; margin-right:10px;">
		                          <input id="middle_name" type="text" class="form-control" placeholder="Middle name">
		                        </div>
		                        <div class="col-lg-3" style="display: block; margin-right:10px;">
		                          <input id="suffix_name" type="text" class="form-control" placeholder="Suffix">
		                        </div>
		                      </div>
		                    </form>
                		</div>
                		<h2 class="text-divider"><span>Eligibility</span></h2>
                		<div class="row">
							<div class="col-lg-3 col-md-3">
									<!--  4Ps -->
									<div class="form-check form-switch">
									  <input class="form-check-input" type="radio" name="eligibility" role="check" />
									  <label class="form-check-label" for="flexSwitchCheckDefault">Adding Dependent</label>
									</div>
								    <!-- 4Ps End -->
						  	</div>
							<div class="col-lg-3 col-md-3">
									<!--  4Ps -->
									<div class="form-check form-switch">
									  <input class="form-check-input" type="radio" name="eligibility" role="check" />
									  <label class="form-check-label" for="flexSwitchCheckDefault">Senior Citizen</label>
									</div>
								    <!-- 4Ps End -->
						  	</div>
							<div class="col-lg-3 col-md-3">
									<!--  4Ps -->
									<div class="form-check form-switch">
									  <input class="form-check-input" type="radio" name="eligibility" role="check" />
									  <label class="form-check-label" for="flexSwitchCheckDefault">4Ps Beneficiary</label>
									</div>
								    <!-- 4Ps End -->
						  	</div>
							<div class="col-lg-3 col-md-3">
									<!--  4Ps -->
									<div class="form-check form-switch">
									  <input class="form-check-input" type="radio" name="eligibility" role="check" />
									  <label class="form-check-label" for="flexSwitchCheckDefault">NHTS / Indigent Member</label>
									</div>
								    <!-- 4Ps End -->
						  	</div>
						</div>
                	</div>


                </div>
                <div id="elementH"></div>
            </div>
            <div class="modal-footer">
                <!-- <button class="btn btn-light" type="button" data-bs-dismiss="modal" aria-label="Close">Close</button> -->
                <button class="btn btn-primary" id="btn-save" type="button">Add to List</button>
            </div>
        </div>
    </div>
</div>



<script>

	function updateName() {
		var last_name = $("#last_name").val();
		var first_name = $("#first_name").val();
		var middle_name = $("#middle_name").val();
		var suffix_name = $("#suffix_name").val();

		var fullname = last_name + ", " + first_name + " " + middle_name + " " + suffix_name;
		$("#full_name").text(fullname.toUpperCase());
	}

	$(function() {


		$("input").each(function(index, el) {
			$(el).keydown(function(event) {
				updateName();
			});
		});
	    $( ".card" ).sortable({
	      connectWith: ".card",
	      handle: ".list-item",
	      cancel: ".item-toggle",
	      placeholder: "item-placeholder",
	      update: function( event, ui ) {
	      		var el = $(event.target);
	      		var destID = $(event.target).data("id");
	      		var destCount = $(event.target).find("div.list-group-item").length;
	      		var item_order = new Array();

				$(event.target).find("div.list-group-item").each(function(index, el) {
					var ord = $(el).find('div').data("order");
					item_order.push(ord);
				});
				console.log(item_order);			

			}
	    });

	    $( ".card" ).on( "sortactivate", function( event, ui ) {
	    	// console.log(ui.position);

	    } );
	 
	    $( ".list-item" )
	      .addClass( "ui-widget ui-widget-content ui-helper-clearfix" )
	        .addClass( "ui-widget-header" )
	       
	 
	    $( ".item-toggle" ).click(function() {
	      var icon = $( this );
	      icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
	      icon.closest( ".list-item" ).find( ".item-content" ).toggle();
	    });

	function addEntity() {
		$("#full_name").text("");
		$("#last_name").text("");
		$("#first_name").text("");
		$("#middle_name").text("");
		$("#suffix_name").text("");
        $('.modal').modal('show');
	}
	$("#add_entity").click(function(event) {
		/* Act on the event */
		 addEntity();
	});

    $("body").keydown(function(e){
         var keyCode = e.keyCode || e.which;
         //your keyCode contains the key code, F1 to F12 
         //is among 112 and 123. Just it.
         if (keyCode == 112) {
         	e.preventDefault();
         	 addEntity();
         }
    });


  });
</script>