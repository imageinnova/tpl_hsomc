<?php
defined('_JEXEC') or die;

$app = JFactory::getApplication();
$doc = JFactory::getDocument();

// get template parameters
$params = $app->getTemplate(true)->params;

// config parameters defaults
$sitename = $app->get('sitename');

if ($this->params->get('logoFile')):
	$logo = '<img class="img-responsive" src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" />';
elseif ($this->params->get('sitetitle')):
	$logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle')) . '</span>';
else:
	$logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
endif;

// determine if left and right columns will be collapsed
$left = $right = true;
$span = 'col-md-6';

if (!$this->countModules('position-3') &&
		!$this->countModules('position-4') &&
		!$this->countModules('position-5') &&
		!$this->countModules('position-6') &&
		!$this->countModules('position-7') &&
		!$this->countModules('position-8')):
		$left = $right = false;
		$span = 'col-md-12';
elseif (!$this->countModules('position-3') &&
		!$this->countModules('position-4') &&
		!$this->countModules('position-5')):
		$left = false;
		$span = 'col-md-9';
elseif (!$this->countModules('position-6') &&
		!$this->countModules('position-7') &&
		!$this->countModules('position-8')):
		$right = false;
		$span = 'col-md-9';
endif;

// determine widths for bottom columns
$bottomLeft = $bottomMiddle = $bottomRight = false;
$spanBottomLeft = $spanBottomMiddle = $spanBottomRight = 'col-md-4';
if ($this->countModules('position-12'))
	$bottomLeft = true;
if ($this->countModules('position-13'))
	$bottomMiddle = true;
if ($this->countModules('position-14'))
	$bottomRight = true;
if (!$bottomLeft && $bottomMiddle && $bottomRight): // center & right
	$spanBottomMiddle = $spanBottomRight = 'col-md-6';
elseif ($bottomLeft && $bottomMiddle && !$bottomRight): // left & center
	$spanBottomLeft = $spanBottomMiddle = 'col-md-6';
elseif ($bottomLeft && !$bottomMiddle && $bottomRight): // left & right
	$spanBottomLeft = $spanBottomRight = 'col-md-6';
elseif ($bottomLeft): // left only
	$spanBottomLeft = 'col-md-12';
elseif ($bottomMiddle): // middle only
	$spanBottomMiddle = 'col-md-12';
elseif ($bottomRight): // right only
	$spanBottomRight = 'col-md-12';
endif;

// template stylesheets
$doc->addStyleSheet('templates/' . $this->template . '/css/bootstrap.min.css');
$doc->addStyleSheet('templates/' . $this->template . '/css/template.css');

// include Bootstrap framework
JHtml::_('bootstrap.framework');

// template scripting
// attempting to get rid of conflict with MooTools
$doc->addScriptDeclaration('
   if (MooTools != undefined) {
      var mHide = Element.prototype.hide;
      Element.implement({
         hide: function() {
            if (this.hasClass("deeper")) {
               return this;
            }
            mHide.apply(this, arguments);
         }
      });
   }
');
?>
<!DOCTYPE html>
<html>
	<head>
		<jdoc:include type="head" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<?php // Google font for headings and title ?>
		<?php if ($this->params->get('googleFont')) : ?>
		<link href='//fonts.googleapis.com/css?family=<?php echo $this->params->get('googleFontName'); ?>' rel='stylesheet' type='text/css' />
		<style type="text/css">
			h1, h2, h3, h4, h5, h6, .site-title {
				font-family: '<?php echo str_replace('+', ' ', $this->params->get('googleFontName')); ?>', sans-serif;
			}
		</style>
		<?php endif; ?>
		
		<style type="text/css">
			body.site {
				border-top: 3px solid <?php echo $params->get('templateColor'); ?>;
				background-color: <?php echo $params->get('templateBackgroundColor'); ?>;
			}

			h1, h2, h3, h4, h5, h6, .site-title {
				color: <?php echo $params->get('templateHeadingColor'); ?>;
			}
			
			a {
				color: <?php echo $params->get('templateLinkColor'); ?>;
			}
			
			.navbar-inner, .nav-list > .active > a, .nav-list > .active > a:hover, .dropdown-menu li > a:hover, .dropdown-menu .active > a, .dropdown-menu .active > a:hover, .nav-pills > .active > a, .nav-pills > .active > a:hover,
			.btn-primary {
				background: <?php echo $params->get('templateMenuHighlightColor'); ?>;
			}
			
			.navbar-inner {
			  background-color: #fafafa;
			  background-image: linear-gradient(to bottom, #ffffff, #f2f2f2);
			  background-repeat: repeat-x;
			  border: 1px solid #d4d4d4;
			  border-radius: 4px;
			  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.067);
			  min-height: 40px;
			  padding-left: 20px;
			  padding-right: 20px;
			}
		</style>
	</head>
	<body class="site">
		<div class="body">
			<div class="container">
				<!-- Header area -->
				<header class="header hidden-xs" role="banner">
					<div class="container-fluid">
						<div class="header-inner clearfix">
							<a class="brand pull-left" href="<?php echo $this->baseurl; ?>/">
								<?php echo $logo; ?>
								<?php if ($this->params->get('sitedescription')) : ?>
									<?php echo '<div class="site-description">' . htmlspecialchars($this->params->get('sitedescription')) . '</div>'; ?>
								<?php endif; ?>
							</a>
							<?php if ($this->countModules('position-11')): ?>
							<div class="header-search pull-right">
								<jdoc:include type="modules" name="position-11" style="none" />
							</div> <!-- header-search -->
							<?php endif; ?>
						</div> <!-- header-inner -->
						<?php if ($this->countModules('position-0')) : ?>
							<div>
								<jdoc:include type="modules" name="position-0" />
							</div>
						<?php endif; ?>
					</div> <!-- container-fluid -->
				</header>

				<!-- Navigation -->
				<?php if ($this->countModules('position-1')) : ?>
				<div class="col-md-12">
					<jdoc:include type="modules" name="position-1" style="none" />
				</div> <!-- col-md-12 -->
				<?php endif; ?>
				
				<!-- Main content area -->
				<div class="row-fluid">
					<!-- Left sidebar -->
					<?php if ($left) : ?>
					<div class="col-md-3">
						<jdoc:include type="modules" name="position-3" style="well" />
						<jdoc:include type="modules" name="position-4" style="well" />
						<jdoc:include type="modules" name="position-5" style="well" />
					</div> <!-- col-md-3 -->
					<?php endif; ?>

					<!--  Middle -->
					<main id="content" role="main" class="<?php echo $span; ?>">
						<!-- above -->
						<jdoc:include type="modules" name="position-9" style="xhtml" />
						<jdoc:include type="message" />
						<jdoc:include type="component" />
						<!-- below -->
						<jdoc:include type="modules" name="position-10" style="xhtml" />
						<!-- breadcrumbs -->
						<jdoc:include type="modules" name="position-2" style="none" />
					</main>
					
					<!--  Right sidebar -->
					<?php if ($right) : ?>
					<div class="col-md-3">
						<jdoc:include type="modules" name="position-6" style="well" />
						<jdoc:include type="modules" name="position-7" style="well" />
						<jdoc:include type="modules" name="position-8" style="well" />
					</div> <!-- col-md-3 -->
					<?php endif; ?>
				</div> <!-- row-fluid -->
				
				<!-- Bottom area -->
				<?php if($bottomLeft || $bottomMiddle || $bottomRight): ?>
				<div class="row-fluid">
					<?php if ($bottomLeft) : ?>
					<div class="<?php echo $spanBottomLeft; ?>">
						<jdoc:include type="modules" name="position-12" />
					</div> <!-- bottomLeft -->
					<?php endif; ?>
					<?php if ($bottomMiddle) : ?>
					<div class="<?php echo $spanBottomMiddle; ?>">
						<jdoc:include type="modules" name="position-13" />
					</div> <!-- bottomMiddle -->
					<?php endif; ?>
					<?php if ($bottomRight) : ?>
					<div class="<?php echo $spanBottomRight; ?>">
						<jdoc:include type="modules" name="position-14" />
					</div> <!-- bottomRight -->
					<?php endif; ?>
				</div> <!-- row-fluid -->
				<?php endif; ?>

				<!-- Footer -->
				<div class="col-md-12">
					<footer class="footer" role="contentinfo">
						<div class="container-fluid">
							<hr />
							<jdoc:include type="modules" name="footer" style="none" />
							<p>
								&copy; <?php echo date('Y'); ?> <?php echo $sitename; ?>
							</p>
						</div>
					</footer>
				</div> <!-- col-md-12 -->
				<jdoc:include type="modules" name="debug" style="none" />
			</div>
		</div>
	</body>
</html>