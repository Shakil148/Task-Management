$(function() {
    "use strict";
    var update_url = $("#update_url").val();
        $("#todo-item-drop, #inprogress-item-drop, #complete-item-drop").sortable({
            connectWith: ".connectedSortable",
            revert: true,
            opacity: 0.5,
        });
        $(".connectedSortable").on("sortupdate", function(event, ui) {
            var todo = [];
            var inProgress = [];
            var accept = [];
            $("#todo-item-drop li").each(function(index) {
                if ($(this).attr('item-id')) {
                    todo[index] = $(this).attr('item-id');
                    // console.log(todo[index]);
                }
            });
            $("#inprogress-item-drop li").each(function(index) {
                if ($(this).attr('item-id')) {
                    inProgress[index] = $(this).attr('item-id');
                    // console.log(inProgress[index]);
                }
            });
            $("#complete-item-drop li").each(function(index) {
                accept[index] = $(this).attr('item-id');
                // console.log(accept[index]);
            });
            $.ajax({
                url: update_url,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    todo: todo,
                    inProgress: inProgress,
                    accept: accept
                },
                success: function(data) {
                    // console.log('success');
                }
            });

        });
    });