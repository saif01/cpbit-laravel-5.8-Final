<script>
    (function(){
    $(".viewAdminData").click(function () {
    var id = $(this).attr("id");
    $.ajax({
    url: "{{ route('admin.details') }}",
    method: "GET",
    data: { id: id },
    dataType: "json",
    success: function (data) {
    $(".AdminImageForModal").attr("src", "{{ asset('/') }}" + data.image);
    $(".AdminIdForModal").text(data.login);
    $(".AdminNameForModal").text(data.name);
    $(".AdminEmailForModal").text(data.email);
    $(".AdminDeptForModal").text(data.department);
    $(".AdminContactForModal").text(data.contact);
    $(".AdminOfficeForModal").text(data.office_id);
    $("#AdminDataModal").modal("show");

    },
    error: function (response) {
    console.log('Error', response);
    },
    });
    });
    })(jQuery);
</script>
