<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('assets/admin/dist/js/adminlte.js') }}"></script>
<script src="{{ asset('assets/admin/js/datatables.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/datatables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/admin/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $(".alert-warning").css('display', 'none');
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function dataTablePosition() {
        $('.buttons-collection').detach().appendTo('.dataTables_filter');
    }

    function deleteData($_id, $_action, roles=[]) {
        var authRole = '<?php echo getUser()->role; ?>';
        $.ajax({
            url: $_action,
            type: 'POST',
            data: {'id': $_id, '_method': 'DELETE'},
            beforeSend: function (){
              if(roles.length > 0) {
                  if(!roles.includes(authRole)){
                      alert('Unauthorized');
                      return false;
                  }
              }
            },
            success: function (data) {
                if (data.error) {
                    toastr.warning(data.error);
                } else if (data.db_error) {
                    toastr.warning(data.db_error);
                } else if (!data.error && !data.db_error) {
                    toastr.success(data.msg);
                    if (data.redirectRoute) {
                        setTimeout(function () {
                            location.href = data.redirectRoute;
                        }, 1000);
                    }
                }

            },
            error: function (xhr) {
                console.log(xhr.responseJSON);
            }
        });
    }

    function onlynumbers(event) {

        let key = window.event ? event.keyCode : event.which;
        // event.keyCode == 39 (is for single quote)
        // event.keyCode == 37 for decimal
        if (event.keyCode == 8 || event.keyCode == 46 ||
            event.keyCode == 37) {
            return true;
        } else if (key < 48 || key > 57) {
            return false;
        } else return true;
    }

    function onpasteString(event) {
        if (event.clipboardData.getData('Text').match(/[^\d]/)) {
            event.preventDefault();
            $.alert({
                title: 'Alert !',
                content: 'Only numbers can be pasted',
                icon: 'fa fa-exclamation-triangle',
                theme: 'modern',
            });
        }
    }

    var animationInterval;

    function setSubmittingAnimation(idName) {
        $("#" + idName).attr('disabled', true)
        var count = 0;
        animationInterval = setInterval(function () {
            count++;
            document.getElementById(idName).innerHTML = "Submitting." + new Array(count % 10).join('.');
        }, 100);
    }

    function clearAnimatedInterval(idName, text) {
        setTimeout(function () {
            clearInterval(animationInterval);
            $("#" + idName).attr('disabled', false);
            $("#" + idName).html(text);
        }, 500);
    }
</script>

<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-container",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    @if (Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch (type) {
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif
</script>
@yield('scripts')
