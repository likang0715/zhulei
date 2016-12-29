$(function() {

    //删除
    $('.del').click(function() {
        if (confirm('确定删除？ 谨慎操作！')) {
            var uid = $(this).data('id');
            $.get('index.php', {'a': 'del', 'uid': uid}, function(data) {
                if (data == 0) {
                    alert('删除成功！');
                    window.location.reload();
                } else {
                    alert('删除失败！');
                }
                return;
            })
        }
    })

    $('.user').hover(function(e) {
        $(this).addClass('active-tr');
    }, function(e) {
        $(this).removeClass('active-tr');
    })


})