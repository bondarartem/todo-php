(function (window) {
	'use strict';

	let path = window.location.href;
	let status = path.split("/#/");
	if (status[1] == "" || !status[1]) {
		status[1] = 'all';
	}

	window.onload = function (e) {
		e.preventDefault();
		showTasks(status[1]);
	};

	$('#all').click((e) => {
		e.preventDefault();
		showTasks('all');
	});

	$('#active').click((e) => {
		e.preventDefault();
		showTasks('active');
	});

	$('#completed').click((e) => {
		e.preventDefault();
		showTasks('completed');
	});
})(window);


function showTasks(status) {
	$.ajax({
		type: "GET",
		url: 'app/api/task/'+status,
		success: function(response)
		{
			let answer = JSON.parse(response);
			let result = "";
			let is_done_cl = "";
			let is_done_check = "";

			answer.forEach((task) => {
				if (task[3]==1) {
					if (task[2] == 1) {
						is_done_cl = "class='completed'";
						is_done_check = "checked";
					}
					result += `<li data-id="${task[0]}" ${is_done_cl}>
	<div class="view">
		<input class="toggle" type="checkbox" ${is_done_check}>
        <label>${task[1]}</label>
        <button class="destroy"></button>
	</div>
	<input class="edit" value="new">
</li>`;
				}
			});

			$('.todo-list').html(result);

			$(".filters li a").removeClass('selected');
			$(`#${status}`).addClass('selected');
		}
	});
}

function deleteTask(id) {

}

function completeTask(id) {

}

function getActiveCount() {

}