<script>
    (function(){
        $(".viewCarData").click(function () {
        var id = $(this).attr("id");
        $.ajax({
        url: "{{ route('car.details') }}",
        method: "GET",
        data: { id: id },
        dataType: "json",
        success: function (data) {
        $(".CarImageForModal").attr("src", "{{ asset('/') }}" + data.image);
        $(".CarNameForModal").text(data.name);
        $(".CarNumberForModal").text(data.number);
        if(data.temporary == 1 ){
        $(".CarTypeForModal").text("Temporary");
        }else{
        $(".CarTypeForModal").text("Regular");
        }

        $(".CarCapacityForModal").text(data.capacity);
        $(".CarRemarksForModal").text(data.remarks);
        $("#CarDataModal").modal("show");

        },
        error: function (response) {
        console.log('Error', response);
        },
        });
        });
    })(jQuery);

</script>
