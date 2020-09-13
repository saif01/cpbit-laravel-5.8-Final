<script>
    (function(){

    $(".viewData").click(function(){
          var id = $(this).attr("id");
        $.ajax({
        url: "{{ route('inv.old.details') }}",
        method: "GET",
        data: { id: id },
        dataType: "json",
        success: function (data) {
        $("#category_m").text(data.category);
        $("#subcategory_m").text(data.subcategory);
        $("#bu_location_m").text(data.bu_location);
        $("#department_m").text(data.department);
        $("#operation_m").text(data.operation);
        $("#name_m").text(data.name);
        $("#remarks_m").html(data.remarks);
        $("#type_m").text(data.type);
        $("#serial_m").text(data.serial);
        $("#rec_name_m").text(data.rec_name);
        $("#rec_contact_m").text(data.rec_contact);
        $("#rec_position_m").text(data.rec_position);
        $("#reg_m").text(data.created_at);

        $("#dataViewModal").modal("show");

        },
        error: function (response) {
        console.log('Error', response);
        },
        });
    });

    $("#searchBtn").click(function(){
        $("#dataSearchModal").modal("show");
    });

})(jQuery);

</script>
