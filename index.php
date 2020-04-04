<?php
require_once('template/header.php');
require_once('controllers/TodoController.php');

?>
			<header class="header">
				<h1>todos</h1>
				<input class="new-todo" placeholder="What needs to be done?" autofocus>
			</header>
			<!-- This section should be hidden by default and shown when there are todos -->
			<section class="main">
				<input id="toggle-all" class="toggle-all" type="checkbox">
				<label for="toggle-all">Mark all as complete</label>
				<ul class="todo-list">
                    <?php
                    foreach ($arResults as $todoItem) {
                        if ($todoItem[3] == 1) {?>

                        <li <?=$todoItem[2]==1 ? "class='completed'": ""?>>
                            <div class="view">
                                <input class="toggle" type="checkbox" <?=$todoItem[2]==1 ? "checked": ""?>>
                                <label><?=$todoItem[1]?></label>
                                <button class="destroy"></button>
                            </div>
                            <input class="edit" value="<?=$todoItem[1]?>">
                        </li>
                    <?php }
                    }?>
				</ul>
			</section>
			<!-- This footer should hidden by default and shown when there are todos -->
			<footer class="footer">
				<!-- This should be `0 items left` by default -->
				<span class="todo-count"><strong>0</strong> item left</span>
				<!-- Remove this if you don't implement routing -->
				<ul class="filters">
					<li>
						<a class="selected" href="#/">All</a>
					</li>
					<li>
						<a href="#/active">Active</a>
					</li>
					<li>
						<a href="#/completed">Completed</a>
					</li>
				</ul>
				<!-- Hidden if no completed items are left ↓ -->
				<button class="clear-completed">Clear completed</button>
			</footer>

<?
require_once('template/footer.php');
?>