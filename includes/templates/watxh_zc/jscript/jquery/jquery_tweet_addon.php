<script type="text/javascript">
jQuery(function(){
	jQuery(".tweet").tweet({
		avatar_size: 0,
		count: 1,
		modpath: 'twitter/',
		username: "<?php echo defined('TABLEAU_TWITTER_HANDLE') ? constant('TABLEAU_TWITTER_HANDLE') : ''; ?>",
		loading_text: "searching twitter...",
		refresh_interval: 60,
	});
});
</script>