<script>
(function(){
    $(document).on("click", "#cancelBooking", function(e) {
    e.preventDefault();
    var link = $(this).attr("href");
    Swal.fire({
    title: 'Are you Want to Cancel?',
    text: "Once Cancel, This will be Permanently Canceled!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, Cancel it!'
    }).then((result) => {
    if (result.value) {
    window.location.href = link;
    }else{
    console.log("Safe Data!");
    }
    });
    });
})(jQuery);
</script>
