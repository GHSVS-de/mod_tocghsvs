<?php
\defined('_JEXEC') or die;

use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Registry\Registry;
use Joomla\CMS\Factory;
use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

#namespace Joomla\Module\AdministratorLinkGhsvs\Administrator\Helper;

abstract class TocGhsvsHelper
{
	public static function getId(
		Registry $params,
		string $moduleName = 'mod_tocghsvs'
	) : string
	{
		if (PluginHelper::isEnabled('system', 'bs3ghsvs'))
		{
			JLoader::register('Bs3ghsvsArticle',
				JPATH_PLUGINS . '/system/bs3ghsvs/Helper/ArticleHelper.php'
			);

			$id = Bs3ghsvsArticle::buildUniqueIdFromJinput('tocGhsvs'
				. $params->get(
					'btnModalConnector', $params->get('connectorKey', $moduleName)
				)
			);
		}
		else
		{
			$jinput = Factory::getApplication()->input;
			$getThis = array(
				'Itemid', 'option', 'view', 'catid', 'id', 'task'
			);

			$id = $moduleName;

			foreach ($getThis as $GetMe)
			{
				$id .= '_' . $jinput->get($GetMe);
			}

			$id = $prefix . '_' . md5(
				ApplicationHelper::stringURLSafe(base64_encode($id))
			);
		}

		return $id;
	}

	public static function getScriptOptions(
		Registry $params, String $id, $moduleId
	) : Array
	{
		$retarray = [
			'divRole' => 'complementary',
			'divTitle' => '',
			// aria-label for outer DIV container.
			'divAriaLabel' => Text::_('MOD_TOCGSHVS_DIVARIALABEL'),

			// The CSS class of the DIV where JS writes in the jump mark anchors.
			// 'divClass' => 'div4TocMenu',

			// The CSS ID of the DIV where JS writes in the jump mark anchors.
			'divId' => 'div4TocMenu-' . $moduleId,

			// aria-label for UL container.
			'ulAriaLabel' => Text::_('MOD_TOCGSHVS_ULARIALABEL'),
			'ulRole' => 'menu',
			'ulClass' => 'list-group list-group-flush',

			'ulId' => 'tocGhsvsUL-%s',

			'liClass' => 'list-group-item',

			// Where to search in for headings.
			'containerWithHeadings' => $params->get(
				'containerWithHeadings', 'div.TOC_GHSVS'
			),

			// Where the anchors will be inserted by JS.
			'attachElement' => '#tocGhsvsOutput-' . $id,

			// Beachte, dass z.B. Überschriften innerhalb pagebreak nicht angesprungen werden.
			'headings' => $params->get('headings', 'h2,h3'),
			'enumerateElements' => 'false',

			'textLimit' => 100,
			// Max. length of # fragment (id).
			'fragmentLimit' => 15,
			'moduleId' => $moduleId,

			'hideIfNothingFound' => '.HIDEIFNOTHINGFOUND' . $id,

			'indentChar' => '&#8227;',
			/*
			Zwar werden dann diese verlinkt angezeigt, aber man kann trotzdem nicht
			hinscrollen, wenn es sich bspw. um ein verstecktes h4 mit einer CSS-
			Klasse handelt, die man hier ergänzt.
			*/
			'forceIsItVisibleClasses' => ['sr-only', 'visually-hidden'],

			/*
			Wenn ein Fund nicht verlinkbar ist, weil das Ziel versteckt ist (macht
			keinen Sinn), kann man ihn trotzdem mit true anzeigen lassen. Halt dann
			ohne Link.
			Das ist einfach Entscheidungssache im Modul. Da man ja nicht nur headlines
			als Selektoren eingeben kann, sondern z.B. auch den beschrifteten Button
			eines Sliders, macht es Sinn die invisible Headline zu verstecken(?)
			*/
			'displayInvisible' => ($params->get('displayInvisible', 1) === 1 ? 'true'
				: 'false'),

			/*
			Auf seiten mit z.B. ?start=20 wechselt statt Scrollen die Seite.
			*/
			'currentUri' => Uri::getInstance()->toString(),
		];

		return $retarray;
	}
}
