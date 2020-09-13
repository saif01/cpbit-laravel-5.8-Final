<script>
    (function(){

    $(document).on('click', '.viewUserData', function(){
    var id = $(this).attr("id");
    $.ajax({
    url: "{{ route('user.details') }}",
    method: "GET",
    data: { id: id },
    dataType: "json",
    success: function (data) {
    $(".UserImageForModal").attr("src", "{{ asset('/') }}" + data.image);
    $(".UserIdForModal").text(data.login);
    $(".UserNameForModal").text(data.name);
    $(".UserEmailForModal").text(data.email);
    $(".UserBUMailForModal").text(data.bu_email);
    $(".UserBULocationForModal").text(data.bu_location);
    $(".UserDeptForModal").text(data.department);
    $(".UserContactForModal").text(data.contact);
    $(".UserOfficeForModal").text(data.office_id);
    $("#UserDataModal").modal("show");

    },
    error: function (response) {
    console.log('Error', response);
    },
    });
    });
    })(jQuery);
</script>
