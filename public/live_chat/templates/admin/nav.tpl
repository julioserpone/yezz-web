<ul class="nav nav-pills nav-stacked">
	<li <?php if (in_array(basename($_SERVER['PHP_SELF']), array('index.php'))) echo 'class="active"'; ?>><a href="index.php"><?php translate('Home'); ?></a></li>
	<li <?php if (in_array(basename($_SERVER['PHP_SELF']), array('chat_history.php', 'view_chat.php'))) echo 'class="active"'; ?>><a href="chat_history.php"><?php translate('Chat history'); ?></a></li>
	<li <?php if (in_array(basename($_SERVER['PHP_SELF']), array('canned_messages.php', 'add_canned_message.php', 'edit_canned_message.php'))) echo 'class="active"'; ?>><a href="canned_messages.php"><?php translate('Canned messages'); ?></a></li>
	<li <?php if (in_array(basename($_SERVER['PHP_SELF']), array('departments.php', 'add_department.php', 'edit_department.php'))) echo 'class="active"'; ?>><a href="departments.php"><?php translate('Departments'); ?></a></li>
	<li <?php if (in_array(basename($_SERVER['PHP_SELF']), array('operators.php', 'add_operator.php', 'edit_operator.php'))) echo 'class="active"'; ?>><a href="operators.php"><?php translate('Operators'); ?></a></li>
	<li <?php if (in_array(basename($_SERVER['PHP_SELF']), array('groups.php', 'add_group.php', 'edit_group.php'))) echo 'class="active"'; ?>><a href="groups.php"><?php translate('Groups'); ?></a></li>
	<li <?php if (in_array(basename($_SERVER['PHP_SELF']), array('languages.php', 'add_language.php', 'edit_language.php'))) echo 'class="active"'; ?>><a href="languages.php"><?php translate('Languages'); ?></a></li>
	<li <?php if (in_array(basename($_SERVER['PHP_SELF']), array('translations.php', 'edit_translation.php'))) echo 'class="active"'; ?>><a href="translations.php"><?php translate('Translations'); ?></a></li>
	<li <?php if (in_array(basename($_SERVER['PHP_SELF']), array('blocked_visitors.php'))) echo 'class="active"'; ?>><a href="blocked_visitors.php"><?php translate('Blocked visitors'); ?></a></li>
	<li <?php if (in_array(basename($_SERVER['PHP_SELF']), array('access_logs.php'))) echo 'class="active"'; ?>><a href="access_logs.php"><?php translate('Access logs'); ?></a></li>
	<li <?php if (in_array(basename($_SERVER['PHP_SELF']), array('settings.php'))) echo 'class="active"'; ?>><a href="settings.php"><?php translate('Settings'); ?></a></li>
</ul>
