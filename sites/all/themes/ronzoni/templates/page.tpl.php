<div role="document" class="page">
	<header role="banner" class="l-header">
		<?php if ($top_bar): ?>
			<?php if ($top_bar_classes): ?><div class="<?php print $top_bar_classes; ?>"><?php endif; ?>
			<nav class="top-bar"<?php print $top_bar_options; ?>>
				<ul class="title-area">
					<li class="name"><h1><?php print $linked_site_name; ?></h1></li>
					<li class="toggle-topbar menu-icon"><a href="#"><span><?php print $top_bar_menu_text; ?></span></a></li>
				</ul>
				<section class="top-bar-section">
					<?php if ($top_bar_main_menu) :?>
						<?php print $top_bar_main_menu; ?>
					<?php endif; ?>
				</section>
			</nav>
			<?php if ($top_bar_classes): ?></div><!--/.top-bar --><?php endif; ?>
    <?php endif; ?>
    <?php if (!empty($page['header'])): ?>
    	<section class="l-header-region row">
    		<div class="large-12 columns"><?php print render($page['header']); ?></div>
    	</section><!--/.l-header-region -->
    <?php endif; ?>
	</header><!--/.l-header -->

	<?php if (!empty($page['featured'])): ?>
  	<section class="l-featured row">
    	<div class="large-12 columns"><?php print render($page['featured']); ?></div>
	</section><!--/.l-featured -->
	<?php endif; ?>

	<?php if ($messages && !$zurb_foundation_messages_modal): ?>
  	<section class="l-messages row">
  		<div class="large-12 columns"><?php if ($messages): print $messages; endif; ?></div>
  	</section><!--/.l-messages -->
  	<?php endif; ?>

  	<main role="main" class="row l-main">
  		<div class="<?php print $main_grid; ?> main columns">
  			<?php if (!empty($page['highlighted'])): ?>
  				<div class="highlight panel callout"><?php print render($page['highlighted']); ?></div>
  			<?php endif; ?>

  			<?php if ($breadcrumb): print $breadcrumb; endif; ?>
  			<?php if ($title && !$is_front): ?>
	  			<?php print render($title_prefix); ?>
	  			<h1 id="page-title" class="title"><?php print $title; ?></h1>
	  			<?php print render($title_suffix); ?>
  			<?php endif; ?>
  			<?php if (!empty($tabs)): ?>
  				<?php print render($tabs); ?>
  				<?php if (!empty($tabs2)): print render($tabs2); endif; ?>
  			<?php endif; ?>

  			<?php if ($action_links): ?>
  			<ul class="action-links">
	  			<?php print render($action_links); ?>
	  		</ul>
	  		<?php endif; ?>

	  		<?php print render($page['content']); ?>
	  	</div><!--/.l-main region -->

	  	<?php if (!empty($page['sidebar_first'])): ?>
	  		<aside role="complementary" class="<?php print $sidebar_first_grid; ?> l-sidebar-first columns sidebar">
	  			<?php print render($page['sidebar_first']); ?>
	  		</aside>
	  	<?php endif; ?>

	  	<?php if (!empty($page['sidebar_second'])): ?>
	  		<aside role="complementary" class="<?php print $sidebar_sec_grid; ?> l-sidebar-second columns sidebar">
		  		<?php print render($page['sidebar_second']); ?>
		  	</aside>
		<?php endif; ?>
	</main><!--/.l-main-->

	<?php if (!empty($page['footer_first']) || !empty($page['footer_middle']) || !empty($page['footer_last'])): ?>
	<footer class="l-footer panel row" role="contentinfo">
	    <?php if (!empty($page['footer_first'])): ?>
	    <div id="footer-first" class="large-4 columns">
	    	<?php print render($page['footer_first']); ?>
	    </div>
	    <?php endif; ?>
	    <?php if (!empty($page['footer_middle'])): ?>
	    <div id="footer-middle" class="large-4 columns">
	    	<?php print render($page['footer_middle']); ?>
	    </div>
	    <?php endif; ?>
	    <?php if (!empty($page['footer_last'])): ?>
	    <div id="footer-last" class="large-4 columns">
	    	<?php print render($page['footer_last']); ?>
	    </div>
	    <?php endif; ?>
	    <?php if ($site_name) :?>
	    <div class="copyright large-12 columns">
    		&copy; <?php print date('Y') . ' ' . check_plain($site_name) . ' ' . t('All rights reserved.'); ?>
	    </div>
	    <?php endif; ?>
	</footer><!--/.footer-->
	<?php endif; ?>

	<?php if ($messages && $zurb_foundation_messages_modal): print $messages; endif; ?>
</div><!--/.page -->
