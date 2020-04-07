let leftTasks = 0;

/*
TODO:
1. зашифровать js, чтобы не было видно в браузере
2. editTask - исправить
 */
(function (window) {
    'use strict';

    let path = window.location.href;
    let state = path.split("/#/");
    if (!state[1]) {
        state[1] = 'all';
    }

    window.onload = function () {
        $(".filters li a").removeClass('selected');
        $(`#${state[1]}`).addClass('selected');

        showTasks(state[1]);
        getActiveCount();
    };

    $('.groups').on("click", function () {
        state[1] = $(this).attr('id');
        showTasks(state[1]);
    });


    $('.todo-list').on("click", "li .toggle", function () {
        let task = $(this).parent().parent();
        let id = task.data('id');
        let is_done = task.hasClass('completed');
        if (is_done) {
            uncompleteTask(id);

            if (state[1] == 'completed') {
                task.remove();
            }
        } else {
            completeTask(id);

            if (state[1] == 'active') {
                task.remove();
            }
        }
    });

    $('.clear-completed').on("click", function () {
        deleteActive(state[1]);
    });

    // create new task on 'Enter' button
    $('.new-todo').keypress(function (e) {
        if (e.which === 13) {
            createTask($(this).val());
            $(this).val("");
        }
    });

    $('.todo-list').on("click", "label", function () {
        $('li .edit').hide();
        let task = $(this).parent().parent();

        if (task.find('.edit:visible').length)
            task.find('.edit').hide();
        else
            task.find('.edit').show();
    });

    $('.todo-list').on('keypress focusout mouseup', '.edit', (function (e) {
        if (e.which === 13 || e.type === 'focusout' ) {
            let id = $(this).parent().data('id');
            editTask(id, $(this).val());
        }
    }));

    $('.todo-list').on("click", "li .destroy", function () {
        let task = $(this).parent().parent();
        let id = task.data('id');
        deleteTask(id);
        task.remove();

    });

    $('.toggle-all').on("click", function () {
        let res = 1;
        if ($('.toggle-all:checked').length){
            leftTasks = 0;
            completeAllTasks();
        } else {
            uncompleteAllTasks();
        }


        showTasks(state[1]);
    });
})(window);

// hide edit input if onclick not input
(function () {
    $(document).mouseup(function (e){
        let inp = $("li .edit");
        if (!inp.is(e.target)
            && inp.has(e.target).length === 0) {
            inp.hide();
        }
    });
})();

function showTasks(status) {
    $.ajax({
        type: "GET",
        url: 'app/api/task/' + status,
        success: function (response) {
            let answer = false;
            if (response && !(response.indexOf('exception') + 1))
                answer = JSON.parse(response);
            let result = "";

            if (answer) {
                answer.forEach((task) => {
                    let is_done_cl = "";
                    let is_done_check = "";

                    if (task[3] == 1) { // is_active (db)
                        if (task[2] == 1) { // is_done (db)
                            is_done_cl = "class='completed'";
                            is_done_check = "checked";
                        }
                        result += getTaskHtml(task[0], task[1], is_done_cl, is_done_check);
                    }
                });
            }


            $('.todo-list').html(result);

            $(".filters li a").removeClass('selected');
            $(`#${status}`).addClass('selected');

            getActiveCount();
        }
    });
}

function getTaskHtml(id, label, doneClass = "", doneCheck = "") {
    return `<li data-id="${id}" ${doneClass}>
	<div class="view">
		<input class="toggle" data-id="hello" type="checkbox" ${doneCheck}>
        <label>${label}</label>
        <button class="destroy"></button>
	</div>
	<input class="edit" value="${label}" maxlength="250">
</li>`;
}

function deleteTask(id) {
    $.ajax({
        type: "POST",
        url: 'app/api/task/delete',
        data: {task_id: parseInt(id)},
        success: function (response) {
            let res = (JSON.parse(response)[0])

            if (res[2] === "0")
                minusLeftTasks();
        }
    });
}

function deleteActive(state) {
    $.ajax({
        type: "POST",
        url: 'app/api/task/delete_active',
        success: function (response) {
            if (response){
                showTasks(state);
            }
        }
    });
}

function completeTask(id) {
    $.ajax({
        type: "POST",
        url: 'app/api/task/complete',
        data: {task_id: parseInt(id)},
        success: function (response) {
            $('li[data-id = ' + id + ']').addClass('completed');

            $('li[data-id = ' + id + '] .toggle').prop("checked", true);

            minusLeftTasks();
        }
    });
}

function uncompleteTask(id) {
    $.ajax({
        type: "POST",
        url: 'app/api/task/uncomplete',
        data: {task_id: parseInt(id)},
        success: function (response) {
            $('li[data-id = ' + id + ']').removeClass('completed');

            $('li[data-id = ' + id + '] .toggle').prop("checked", false);

            getActiveCount();
        }
    });
}

function completeAllTasks() {
    $.ajax({
        type: "POST",
        url: 'app/api/task/complete_all',
        success: function (response) {
            $('li').addClass('completed');

            $('li .toggle').prop("checked", true);

            getActiveCount();
        }
    });
}

function uncompleteAllTasks() {
    $.ajax({
        type: "POST",
        url: 'app/api/task/uncomplete_all',
        success: function (response) {
            $('li').removeClass('completed');

            $('li .toggle').prop("checked", false);

            getActiveCount();
        }
    });
}

function getActiveCount() {
    $.ajax({
        type: "GET",
        url: 'app/api/task/get_count',
        success: function (response) {
            let result = (JSON.parse(response));
            leftTasks = result[0][0];

            $('.todo-count strong').html(leftTasks);
        }
    });
}

function createTask(text) {
    $.ajax({
        type: "POST",
        url: 'app/api/task/create',
        data: {text: text},
        success: function (response) {
            let res = (JSON.parse(response)[0]);
            let content = getTaskHtml(res[0],res[1]);

            let el = $('.todo-list li:last-child');
            if (el.length === 0){
                el = $('.todo-list');
                el.html(content);
            } else {
                el.after(content);
            }

            plusLeftTasks();
        }
    });
}

function editTask(id, text) {
    $.ajax({
        type: "POST",
        url: 'app/api/task/edit',
        data: {text: text, task_id: id},
        success: function (response) {
            console.log(id, response);
        }
    });
}


function minusLeftTasks() {
    leftTasks--;
    $('.todo-count strong').html(leftTasks);
}

function plusLeftTasks() {
    leftTasks++;
    $('.todo-count strong').html(leftTasks);
}
