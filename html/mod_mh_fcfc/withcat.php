<?php
/**
 * @author     mediahof, Kiel-Germany
 * @link       http://www.mediahof.de
 * @copyright  Copyright (C) 2011 - 2014 mediahof. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die;

$css[] = 'div.fcfc_' . $module->id . '.fcfc_wrapper{';
$css[] = 'width:' . ($params->get('width') ? $params->get('width') . 'px;' : '100%;');
$css[] = 'height:' . $params->get('height') . 'px;';
$css[] = '}';

JFactory::getDocument()->addStyleDeclaration(implode($css));
?>
<div class="fcfc_wrapper fcfc_<?php echo $module->id ?>">
    <?php foreach ($rows as $key => &$row) : ?>
        <div class="fcfc_inner" id="<?php echo 'fcfc_' . $module->id . '_' . ($key + 1); ?>">
            <?php if ($params->get('title')) : ?>
                <h<?php echo $params->get('headerlevel', 3); ?>><?php echo $params->get('titlelink') ? JHtml::_('link', $row->link, $row->title) : $row->title; ?></h<?php echo $params->get('headerlevel', 3); ?>>
            <?php endif;
            echo $row->text;
            if ($params->get('readon')) echo JHtml::_('link', $row->link, JText::_('MOD_MH_FADECFC_READON'), array('class' => 'readmore', 'title' => $row->title));
            ?>
			<p><?php echo getCategoryName($row->id); ?></p>
        </div>
    <?php endforeach; ?>
    <script type="text/javascript">
        new fcfc(<?php echo count($rows); ?>, <?php echo $params->get('fadeSpeed'); ?>, <?php echo $params->get('fadeOutTime')*1000; ?>, '<?php echo 'fcfc_'.$module->id.'_'; ?>');
    </script>
</div>
<?php
function getCategoryName($id) {
   //Modified from: http://stackoverflow.com/questions/8928967/joomla-display-catagory-name-in-template

   $db = &JFactory::getDBO(); 
   $view = JRequest::getString('view'); 

   $sql = "SELECT #__categories.title FROM #__content, #__categories WHERE #__content.catid = #__categories.id AND #__content.id = $id";

   $db->setQuery($sql); 
   $category = $db->loadResult(); 
   return $category; 
}
?>