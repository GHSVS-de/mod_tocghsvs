<?php
namespace Joomla\Module\TocGhsvs\Site\Helper;

\defined('_JEXEC') or die;

use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\Registry\Registry;
use Joomla\CMS\HTML\HTMLHelper;

// @since 2023-11
use GHSVS\Plugin\System\Bs3Ghsvs\Helper\Bs3GhsvsArticleHelper as Bs3ghsvsArticle;

abstract class TocGhsvsHelper
{
	protected static $isJ3 = true;

	protected static $wa = null;

	protected static $loaded = [];

	private static $name = 'mod_tocghsvs';

	protected static function init()
	{
		self::$isJ3 = version_compare(JVERSION, '4', 'lt');
	}

	public static function getId(Registry $params) : string
	{
		if (class_exists('Bs3ghsvsArticle'))
		{
			$id = \Bs3ghsvsArticle::buildUniqueIdFromJinput(
				'tocGhsvs'
				. $params->get(
					'btnModalConnector',
					$params->get('connectorKey', self::$name)
				)
			);
		}
		else
		{
			$jinput = Factory::getApplication()->input;
			$getThis = [
				'Itemid', 'option', 'view', 'catid', 'id', 'task',
			];

			$id = self::$name;

			foreach ($getThis as $GetMe)
			{
				$id .= '_' . $jinput->get($GetMe, '');
			}
$prefix = 'tocGhsvs';
			$id = $prefix . '_' . md5(
				ApplicationHelper::stringURLSafe(base64_encode($id))
			);
		}

		return $id;
	}

	public static function getScriptOptions(
		Registry $params,
		String $id,
		$moduleId
	) : array {
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

			// 'menu' wird bemeckert von a11y Tool.
			'ulRole' => '',
			'ulClass' => 'list-group list-group-flush',

			'ulId' => 'tocGhsvsUL-%s',

			'liClass' => 'list-group-item',

			// Where to search in for headings.
			'containerWithHeadings' => $params->get(
				'containerWithHeadings',
				'div.TOC_GHSVS'
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

	public static function loadAssets(&$params)
	{
		$wa = self::getWa();

		if ($wa) {
			$wa->useScript(self::$name . '.core');
			$wa->useStyle(self::$name . '.override.template');
		} else {
			$version = self::getMediaVersion();
			HTMLHelper::_('script', self::$name . '/tocGhsvs.min.js',
				['version' => $version, 'relative' => true], ['defer' => true]
			);
			HTMLHelper::_('stylesheet', self::$name . '.css',
				['version' => $version, 'relative' => true]
			);
		}
	}

	public static function getWa()
	{
		self::init();

		if (self::$isJ3 === false && empty(self::$wa))
		{
			self::$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
			self::$wa->getRegistry()->addExtensionRegistryFile(self::$name);
		}

		return self::$wa;
	}

	public static function getMediaVersion()
	{
		if (!isset(self::$loaded['mediaVersion']))
		{
			if (!(self::$loaded['mediaVersion'] =  json_decode(
				file_get_contents(
				JPATH_ROOT . '/media/' . self::$name . '/joomla.asset.json'
			)
			)->version)
			) {
				self::$loaded['mediaVersion'] = 'auto';
			}
		}

		return self::$loaded['mediaVersion'];
	}

}
