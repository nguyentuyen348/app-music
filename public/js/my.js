$(document).ready(function () {
    let origin = location.origin;
    $('.delete-user').click(function () {
        if (confirm('Bạn chắc chắn muốn xóa?')) {
            let idUser = $(this).attr('data-id');
            $.ajax({
                url: origin + '/admin/users/' + idUser + '/destroy',
                method: 'GET',
                dataType: 'json',
                success: function (res) {
                    $('#user-' + idUser).remove();
                    $('#text-success').hide();
                    alert(res);
                },
                error: function (error) {
                    console.log(error);
                }
            })
        }
    })
    $('.delete-book').click(function () {
        if (confirm('Bạn chắc chắn muốn xóa?')) {
            let idBook = $(this).attr('data-id');
            $.ajax({
                url: origin + '/admin/books/' + idBook + '/destroy',
                method: 'GET',
                dataType: 'json',
                success: function (res) {
                    $('#book-' + idBook).remove();
                    $('#text-success').hide();
                    alert(res);
                },
                error: function (error) {
                    console.log(error);
                }
            })
        }
    })
    $('.delete-student').click(function () {
        if (confirm('Bạn chắc chắn muốn xóa?')) {
            let idStudent = $(this).attr('data-id');
            $.ajax({
                url: origin + '/admin/students/' + idStudent + '/destroy',
                method: 'GET',
                dataType: 'json',
                success: function (res) {
                    $('#student-' + idStudent).remove();
                    $('#text-success').hide();
                    alert(res);
                },
                error: function (error) {
                    console.log(error);
                }
            })
        }
    })
    $('#search-student-borrow').keyup(function () {
        let value = $(this).val();
        if (value) {
            $.ajax({
                url: origin + '/admin/borrows/search-student/',
                method: 'GET',
                data: {
                    keyword: value
                },
                success: function (res) {
                    let html = '';
                    res.forEach(function (item, index) {
                        html += '<button data-id="' + item.id + '" class="list-group-item list-group-item-action student-item">';
                        html += item.name;
                        html += '</button>';
                    })
                    $('#list-student-borrow-search').html(html);
                    console.log(res)
                },
                error: function (error) {
                    console.log(error)
                }
            })
        } else {
            $('#list-student-borrow-search').html('');
        }
    })
    $('body').on('click', '.student-item', function () {
        let idStudentClicked = $(this).attr('data-id');
        $.ajax({
            url: origin + '/admin/borrows/find-student/' + idStudentClicked,
            method: 'GET',
            success: function (res) {
                $('#name-student-borrow').val(res.name);
                $('#email-student-borrow').val(res.email);
                $('#phone-student-borrow').val(res.phone);
                $('#student-id').val(res.id);
                $('#list-student-borrow-search').html('');
            }
        })
    });

    $('#search-book').keyup(function () {
        let value = $(this).val();
        if (value) {
            $.ajax({
                url: origin + '/admin/borrows/search-book/',
                method: 'GET',
                data: {
                    keyword: value
                },
                success: function (res) {
                    let html = '';
                    res.forEach(function (item, index) {
                        html += '<button data-id="' + item.id + '" class="list-group-item list-group-item-action book-item">';
                        html += item.name;
                        html += '</button>'
                    })
                    $('#list-book-search').html(html);
                    console.log(res)
                },
                error: function (error) {
                    console.log(error)
                }
            })
        } else {
            $('#list-book-search').html('');
        }
    })
    $('body').on('click', '.book-item', function () {
        let idBookClicked = $(this).attr('data-id');
        $.ajax({
            url: origin + '/admin/borrows/find-book/' + idBookClicked,
            method: 'GET',
            success: function (res) {
                if (res.status == 0) {
                    alert("Sách chưa thể mượn");
                } else {
                    $('#choseBook').hide();
                    let html = '<tr id="' + res.id + '" class="book-item">';
                    html += '<td>';
                    html += res.name;
                    html += '</td>';
                    html += ' <td>';
                    html += '<img width="80" src="http://127.0.0.1:8000/storage/' + res.image + '">';
                    html += '</td>';
                    if (res.status == 1) {
                        html += '<td class="text-success"><i class="fas fa-circle"></i> Có thể mượn';
                    } else {
                        html += '<td class="text-danger"><i class="fas fa-circle"></i> Chưa thể mượn';
                    }
                    html += '</td>';
                    html += '</tr>';
                    $('#book-id').val(res.id);
                    $('#book-item').append(html);
                    $('#book-status').val(res.status);
                    $('#list-book-search').html('');
                }
            }
        })
    });
    $('#create-borrow').click(function () {
        let ids = $('.book-item').map(function () {
            return this.id
        }).get()
        let student_id = $('#student-id').val();
        let borrow_date = $('#borrow_date').val();
        let return_date = $('#return_date').val();
        let book_status = $('#book-status').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: origin + '/admin/borrows/create',
            method: 'POST',
            data: {
                student_id: student_id,
                book_id: ids,
                borrow_date: borrow_date,
                return_date: return_date,
                book_status: book_status
            },
            success: function (res) {
                if (res === 'Cho mượn thành công') {
                    alert(res);
                    window.location.assign(origin + "/admin/borrows");
                } else if (res === 'Ngày mượn phải trước ngày trả') {
                    alert(res);
                } else {
                    alert(res);
                }
            },
            error: function (error) {
                console.log(error);
            }
        })
    })
    $('.confirm-return').click(function () {
        if (confirm('Xác nhận trả?')) {
            let idBorrow = $(this).attr('data-id');
            $.ajax({
                url: origin + '/admin/borrows/' + idBorrow + '/confirmReturn',
                method: 'GET',
                dataType: 'json',
                success: function (res) {
                    alert(res);
                    window.location.assign(origin + "/admin/borrows")
                }
            })
        }
    })
    $('#book-cancel').click(function () {
        $('#choseBook').show();
        $('#book-item').html('');
    })
});
