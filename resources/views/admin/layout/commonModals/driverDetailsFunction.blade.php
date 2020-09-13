<script>
    (function(){
    $(".viewDriverData").click(function () {
    var id = $(this).attr("id");
    $.ajax({
    url: "{{ route('driver.details') }}",
    method: "GET",
    data: { id: id },
    dataType: "json",
    success: function (data) {
    $(".DriverImageForModal").attr("src", "{{ asset('/') }}" + data.image);
    $(".DriverNameForModal").text(data.name);
    $(".DriverContactForModal").text(data.contact);
    $(".DriverNidForModal").text(data.nid);
    $(".DriverlicenseForModal").text(data.license);
    $("#DriverDataModal").modal("show");

    },
    error: function (response) {

    console.log('Error', response);
    },
    });
    });
    })(jQuery);
</script>
