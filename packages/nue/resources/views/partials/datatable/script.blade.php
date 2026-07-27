iDisplayLength: 25, 
select: {
    style: 'multi',
    selector: 'td:first-child input[type="checkbox"]',
    classMap: {
        checkAll: '#datatable-checkbox-check',
        counter: '#datatable-checkbox',
        counterInfo: '#datatable-checkbox-info'
    }
}, 
info: {
    totalQty: "#datatable-total"
},
processing: true,
serverSide: true,
search: "#datatabe-search",
entries: "#datatable-entries",
pagination: "datatable-pagination", 
isResponsive: true,
isShowPaging: false,
bInfo : false, 
bProcessing: false, 
bLengthChange: false, 
fnDrawCallback: function( oSettings ) {
    $('#delete-selected').on('click', function(e) {
        e.preventDefault();
        swal({
            title: 'Are you sure?',
            html: 'Please type <b>delete</b> to confirm.',
            type: 'warning',
            input: 'text',
            showCancelButton: true,
            confirmButtonText: 'Sure',
            showLoaderOnConfirm: true,
            preConfirm: function (data) {
                return new Promise(function (resolve, reject) {
                    setTimeout(function() {
                        if (data !== 'delete') {
                            reject('Please enter according to the command.')
                        } else {
                            resolve()
                        }
                    }, 1000)
                })
            },
            allowOutsideClick: false
        }).then(function(data) {
            $("#submit-all").submit();
        })
    });
}