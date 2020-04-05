<?php


session_start();
if(!isset($_SESSION["session_username"]) || !isset($_SESSION["session_id"])){
    // вывод "Session is set"; // в целях проверки
    header("Location: /auth/login.php");
}

require_once('template/header.php');
require_once('controllers/TodoController.php');


?>
<script>
    let author_id = <?=$_SESSION["session_id"]?>;
</script>
			<header class="header">
				<h1>todos</h1>
				<input class="new-todo" placeholder="очередной пунктик" autofocus>
			</header>
			<!-- This section should be hidden by default and shown when there are todos -->
			<section class="main">
				<input id="toggle-all" class="toggle-all" type="checkbox">
				<label for="toggle-all">Mark all as complete</label>
				<ul class="todo-list">

				</ul>
			</section>
			<!-- This footer should hidden by default and shown when there are todos -->
			<footer class="footer">
				<!-- This should be `0 items left` by default -->
				<span class="todo-count"><strong>0</strong> дел осталось</span>
				<!-- Remove this if you don't implement routing -->
				<ul class="filters">
					<li>
						<a id="all" class="selected" href="#/">All</a>
					</li>
					<li>
						<a id="active" href="#/active">Active</a>
					</li>
					<li>
						<a id="completed" href="#/completed">Completed</a>
					</li>
				</ul>
				<!-- Hidden if no completed items are left ↓ -->
				<button class="clear-completed">Clear completed</button>
			</footer>

<?php
require_once('template/footer.php');
?>