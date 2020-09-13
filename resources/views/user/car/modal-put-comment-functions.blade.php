<script src="{{ asset('common/form-validation/jquery.validate.min.js') }}"></script>

<script>

(function(){

      $(document).on("click", ".bookingComment", function() {
        var id = $(this).attr("id");
        $.ajax({
            url: "{{ route('user.booked.car.data') }}",
            method: "GET",
            data:{ id:id },
            success: function(data){

                var start_mileage = data.start_mileage;
                var end_mileage = data.end_mileage;
                var gas = data.gas;
                var octane = data.octane;
                var toll = data.toll;
                var driver_rating = data.driver_rating;

                 if ((start_mileage === null) || (end_mileage === null) || (gas === null) || (octane === null) || (toll === null) ||(driver_rating === null) )
                    {
                        $("#beforComment").show();
                        $("#afterComment").hide();
                    }
                    else
                    {
                        $("#beforComment").hide();
                        $("#afterComment").show();
                    }

                $("#booking_id").val(id);
                $(".start_mileage").val(start_mileage);
                $(".end_mileage").val(end_mileage);
                $(".gas").val(gas);
                $(".octane").val(octane);
                $(".toll").val(toll);
                $(".driver_rating").val(driver_rating);

                $("#CommentModal").modal("show");
            },
            error: function(response){
                console.log('Error', response);
            }
        });

    });


    $(document).ready( function() {

				$( "#commentInputForm" ).validate( {
				rules: {
					start_mileage: "required",
					end_mileage: "required",
					gas: "required",
					octane: "required",
					start_mileage: "required",
					toll: "required",
					driver_rating: "required",	
				},
				messages: {
					start_mileage: "Start car meter reading (Only Number)",
					end_mileage: "End car meter reading (Only Number)",
					gas: "Please enter Gasoline cost in taka  if not have then put 0",
					octane: "Please enter Octane cost in taka  if not have then put 0",
					toll: "Please enter Toll cost in taka  if not have then put 0 ",
					driver_rating: "Please enter Driver Rating (0 to 10)",
				
				},
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					error.addClass( "help-block" );
					error.insertAfter(element);
					
				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
				},
				unhighlight: function (element, errorClass, validClass) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
				},
            });
            
	});


   
})(jQuery);


</script> 
