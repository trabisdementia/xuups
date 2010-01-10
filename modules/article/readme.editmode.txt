
Guide for setting customized article edit mode

The module allows you to set your prefered edit mode: which mode of edit form can used by users, which fields are allowed for users in a custom or basic mode.

Note: the application requires very basic PHP skill.

Guide #1 - Set form modes
1 In file module/article(or cloned module)/include/form.article.config.php, set the modes of "basic", "custom"; "full" mode can also be configured by modifying
$form_art_elements["full"] = !empty($form_element["active"]) ? array_keys($form_element["active"]) :
2 A full list of all available fields is listed for each mode, a field can be hidden by comment out; or be displayed by removing the comment mark; the sorting order is active for user interface


Guide #2 - Set user permission
1 In file module/article(or cloned module)/include/plugin.php, set the preference for $customConfig["form_mode"]
2 Available values for the "form_mode":
	"fix" - force to use "custom", custom mode;
	"basic" - default as basic mode "basic", can be switched by user;
	"full" - default as advanced mode "full", can be switched by user;
	"custom" - default as custom mode "custom", can be switched by user;
