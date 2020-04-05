(function (window) {
	'use strict';

	let path = window.location.href;
	let status = path.split("/#/");
	if (status[1] == "" || !status[1]) {
		status[1] = 'all';
	}

	window.onload = function () {
		$(".filters li a").removeClass('selected');
		$(`#${status[1]}`).addClass('selected');

		showTasks(status[1]);
	};

	$('#all').click(() => {
		showTasks('all');
		status[1] = 'all';
	});

	$('#active').click(() => {
		showTasks('active');
		status[1] = 'active';
	});

	$('#completed').click(() => {
		showTasks('completed');
		status[1] = 'completed';
	});

	$('.todo-list').on("click", "li .toggle",  function () {
		let id = $(this).parent().parent().data('id');
		console.log(id);
		let is_done = $(this).parent().parent().hasClass('completed');
		let res = 1;
		if (is_done) {
			uncompleteTask(id);

			if (status[1] == 'completed') {
				$(this).parent().parent().remove();
			}
		} else {
			completeTask(id);

			if (status[1] == 'active') {
				$(this).parent().parent().remove();
			}
		}
		getActiveCount();

	});

	$('.clear-completed').on("click", function () {
		deleteActive();
		showTasks(status[1]);
	});

	// create new task on 'Enter' button

	$('.new-todo').keypress(function(e) {
		if(e.which == 13) {
			createTask($(this).val());
			$(this).val("");
			showTasks(status[1]);
		}
	});

	$('.todo-list').on("click", "label", function () {
		$('li .edit').hide();
		let li = $(this).parent().parent();

		if (li.find('.edit:visible').length)
			li.find('.edit').hide();
		else
			li.find('.edit').show();
	});

	$('.todo-list').on('keypress', '.edit',(function(e) {
		if(e.which == 13) {
			let id = $(this).parent().data('id');
			console.log($(this).val());
			editTask(id, $(this).val());
			showTasks(status[1]);
		}
	}));

})(window);


function showTasks(status) {
	$.ajax({
		type: "GET",
		url: 'app/api/task/'+status,
		success: function(response)
		{
			let answer = JSON.parse(response);
			let result = "";

			if (answer != "0") {
				answer.forEach((task) => {
					let is_done_cl = "";
					let is_done_check = "";
					if (task[3]==1) {
						if (task[2] == 1) {
							is_done_cl = "class='completed'";
							is_done_check = "checked";
						}
						result += `<li data-id="${task[0]}" ${is_done_cl}>
	<div class="view">
		<input class="toggle" data-id="hello" type="checkbox" ${is_done_check}>
        <label>${task[1]}</label>
        <button class="destroy"></button>
	</div>
	<input class="edit" value="${task[1]}">
</li>`;
					}
				});
			}



			$('.todo-list').html(result);

			$(".filters li a").removeClass('selected');
			$(`#${status}`).addClass('selected');

			getActiveCount()
		}
	});
}

function deleteTask(id) {
	$.ajax({
		type: "POST",
		url: 'app/api/task/delete',
		data: { task_id : parseInt(id) },
		success: function(response)
		{
		}
	});
}

function deleteActive() {
	$.ajax({
		type: "POST",
		url: 'app/api/task/delete_active',
		success: function(response)
		{
			console.log(response)
		}
	});
}

function completeTask(id) {
	$.ajax({
		type: "POST",
		url: 'app/api/task/complete',
		data: { task_id : parseInt(id) },
		success: function(response)
		{
			$('li[data-id = '+ id +']').addClass('completed');

			$('li[data-id = '+ id +'] .toggle').prop( "checked", true );
		}
	});
}

function uncompleteTask(id) {
	$.ajax({
		type: "POST",
		url: 'app/api/task/uncomplete',
		data: { task_id : parseInt(id) },
		success: function(response)
		{
			$('li[data-id = '+ id +']').removeClass('completed');

			$('li[data-id = '+ id +'] .toggle').prop( "checked", false );
		}
	});
}

function getActiveCount() {
	$.ajax({
		type: "GET",
		url: 'app/api/task/get_count',
		success: function(response)
		{
			let result = (JSON.parse(response));
			$('.todo-count').html("<strong>" + result[0][0] + "</strong> дел осталось")
		}
	});
}

function createTask(text) {
	$.ajax({
		type: "POST",
		url: 'app/api/task/create',
		data: { text : text },
		success: function(response)
		{
			console.log(response)
		}
	});
}

function editTask(id, text) {
	$.ajax({
		type: "POST",
		url: 'app/api/task/edit',
		data: { text : text , task_id: id},
		success: function(response)
		{
			console.log(response)
		}
	});
}