# America ACF Local JSON Manager

One of the great things about version 5 of the Advanced Custom Fields plugin is the ability to save forms as local JSON, which dramatically speeds up ACF and allows for version control over field settings.

However, it has two big drawbacks. First, you can only have one save location for your forms. This will cause problems if you have more than one plugin/theme that depends on ACF and utilizes local JSON to save your forms. Second, it does not automatically not load data from local JSON files; you have to manually sync for the forms from within Wordpress, which is not ideal when moving through multiple environments.

This plugin allows for automatic syncing to multiple save/load points.
