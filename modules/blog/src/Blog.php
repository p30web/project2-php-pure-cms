<?php

namespace Joonika\Modules\Blog;
if (!defined('jk')) die('Access Not Allowed !');

class Blog
{
	public function __construct()
	{

	}
}

function categoryCheckboxParentHTML($module, $sub = 0, $child = 0, $dataID = 0)
{
	global $database;
	$getcheckedID = [];
	if ($dataID >= 1) {
		$getcheckedID = $database->select('jk_data_categories_rel', 'categoryID', [
			"dataID" => $dataID
		]);
	}
	$navs = $database->select('jk_data', '*', [
		"AND" => [
			"module" => $module,
			"parent" => $sub,
			"status" => "active",
		],
		"ORDER" => ["parent" => "ASC", "sort" => "ASC"]
	]);
	$soo = sizeof($navs);
	if ($soo >= 1) {
		?>
    <ul class="dd-list dd-list-<?php echo JK_DIRECTION ?>">
		<?php
		foreach ($navs as $nav) {
			?>
            <li class="dd-item dd3-item" data-id="<?php echo $nav['id'] ?>">
                <div class="dd3-content">
                    <input type="checkbox" name="cats[]" id="cat_<?php echo $nav['id'] ?>"
                           value="<?php echo $nav['id']; ?>" <?php
					       if (in_array($nav['id'], $getcheckedID)){
					       ?>checked<?php
					}
					?>>
                    <label for="cat_<?php echo $nav['id'] ?>"
                           class="no-padding no-margin"><?php echo $nav['title']; ?></label>
                </div>
				<?php

				categoryCheckboxParentHTML($module, $nav['id'], $child++, $dataID);

				?>
            </li>
			<?php

		}
		?></ul><?php

	}
}

function dateTitle($dataID)
{
	global $database;
	return $database->get('jk_data', 'title', [
		"id" => $dataID
	]);
}

function datePlusView($dataID)
{
	global $database;
	$database->update('jk_data', [
		"views[+]" => 1
	], [
		"id" => $dataID
	]);
}

function slugify($textSlug, $options = [])
{
	global $database;
	$option = [
		"flag" => 1,
		"table" => 'jk_data',
		"column" => 'slug',
		"editID" => 0
	];
	if (sizeof($option) >= 1) {
		foreach ($option as $key => $opt) {
			if (isset($options[$key])) {
				$option[$key] = $options[$key];
			}
		}
	}
	$continue = true;
	if ($option['editID'] != 0) {
		$count = $database->count($option['table'], $option['column'], [
			"AND" => [
				"id" => $option['editID'],
				$option['column'] => $textSlug,
			]
		]);
		if ($count == 1) {
			$continue = false;
		}
	}
	if ($continue == true) {
		// replace non letter or digits by -
		$textSlug = preg_replace('/[\x00-\x1F\x7F]/u', '', $textSlug);

		// transliterate
		$textSlug = iconv('utf-8', 'utf-8//TRANSLIT', $textSlug);

		// trim
		$textSlug = trim($textSlug, '-');
		// remove duplicate -
		$textSlug = preg_replace('~-+~', '-', $textSlug);

		$textSlug = str_replace(' ', '-', $textSlug);

		// lowercase
		$textSlug = strtolower($textSlug);
		if (empty($textSlug)) {
			return 'n-a';
		}

		$count = $database->count($option['table'], $option['column'], [
			"AND" => [
				"id[!]" => $option['editID'],
				$option['column'] => $textSlug
			]
		]);
		if ($count >= 1) {
			$option['flag'] += 1;
			if ($option['flag'] >= 2) {
				$textSlug = rtrim($textSlug, '-' . ($option['flag'] - 1));
				$textSlug = $textSlug . '-' . $option['flag'];
			}
			$textSlug = slugify($textSlug, $option);
		}
	}
	return $textSlug;
}

function category_update_data($categories_post, $dataID)
{
	global $database;
	$cpo = [];
	if (is_array($categories_post) && sizeof($categories_post) >= 1 && $dataID >= 1) {
		foreach ($categories_post as $cp) {
			array_push($cpo, $cp);
			$groups = category_parent_sub($cp);

			if (sizeof($groups) >= 1) {
				foreach ($groups as $gr) {
					array_push($cpo, $gr);
				}
			}
		}
	}

	$catsbefore = $database->select('jk_data_categories_rel', 'categoryID', [
		"dataID" => $dataID
	]);
	$postcat = [];

	if (sizeof($cpo) >= 1) {
		foreach ($cpo as $cp) {
			$cathas = $database->has('jk_data_categories_rel', [
				"AND" => [
					"categoryID" => $cp,
					"dataID" => $dataID
				]
			]);
			if (!$cathas) {
				$database->insert('jk_data_categories_rel', [
					"categoryID" => $cp,
					"dataID" => $dataID
				]);
			}
			array_push($postcat, $cp);

		}
	}
	$result = array_diff($catsbefore, $postcat);
	if (sizeof($result) >= 1) {
		foreach ($result as $rem) {
			$database->delete('jk_data_categories_rel', [
				"AND" => [
					"categoryID" => $rem,
					"dataID" => $dataID
				]
			]);
		}
	}

}

function dataAddTh($addThs, $dataID)
{
	global $database;
	$beClear = [];
	if (sizeof($addThs) >= 1) {
		foreach ($addThs as $addThK => $addThV) {
			$has = $database->get('jk_data_th', '*', [
				"AND" => [
					"thID" => $addThK,
					"dataID" => $dataID,
				]
			]);
			if (isset($has['id'])) {
				$database->update('jk_data_th', [
					"fileID" => $addThV,
					"status" => "active",
				], [
					"id" => $has['id']
				]);
				array_push($beClear, $has['id']);
			} else {
				$database->insert('jk_data_th', [
					"fileID" => $addThV,
					"thID" => $addThK,
					"dataID" => $dataID,
					"status" => "active",
				]);
				$newID = $database->id();
				array_push($beClear, $newID);
			}
		}
	}
	$database->update('jk_data_th', [
		"status" => "removed"
	], [
		"AND" => [
			"id[!]" => $beClear,
			"dataID" => $dataID,
		]
	]);


}

function category_parent_sub($parent, &$groups = [])
{
	global $database;
	$groupins = $database->select('jk_data', 'parent', [
			"id" => $parent,
			"ORDER" => ['sort' => 'ASC']
		]
	);
	if (sizeof($groupins) >= 1) {
		foreach ($groupins as $group) {
			if ($group != 0) {
				$groups[$group] = $group;
				category_parent_sub($group, $groups);
			}
		}
	}
	return $groups;
}

function tags_update_data($tags, $dataID)
{
	global $database;
	$tagsbefore = [];
	$deltags = [];
	$expadd = [];
	$tagsbefore2 = $database->select('jk_data_tags_rel', 'tagID', [
		"dataID" => $dataID
	]);

	if (sizeof($tagsbefore2) >= 1) {
		$tagsbefore = $database->select('jk_data_tags', 'title', [
			"id" => $tagsbefore2
		]);
	}
	if ($tags != '') {
		$exp = explode(',', $tags);

		if (sizeof($exp) >= 1 && is_array($exp)) {
			foreach ($exp as $ex) {
				array_push($expadd, trim($ex));
			}
		}
		if (sizeof($exp) >= 1 && is_array($exp)) {
			foreach ($exp as $ex) {
				$ex = trim($ex);
				if (!in_array($ex, $tagsbefore)) {

					$hastag = $database->get("jk_data_tags", '*', [
						"title" => $ex
					]);
					if (isset($hastag['id'])) {
						$datatagID = $hastag['id'];
					} else {
						$database->insert('jk_data_tags', [
							"title" => $ex
						]);
						$datatagID = $database->id();
					}
					$database->insert('jk_data_tags_rel', [
						"tagID" => $datatagID,
						"dataID" => $dataID
					]);
				}
			}
		}
		$result = array_diff($tagsbefore, $expadd);
		if (sizeof($result) >= 1) {
			foreach ($result as $res) {
				$getID = $database->get('jk_data_tags', 'id', [
					"title" => $res
				]);
				$del = $database->delete('jk_data_tags_rel', [
					"AND" => [
						"dataID" => $dataID,
						"tagID" => $getID
					]
				]);
			}
		}

	}
//print_r($tags);

}

function tagsGetFromData($dataID, $type = "string")
{
	$back = '';
	$tagback = [];
	global $database;
	$tags = $database->select('jk_data_tags_rel', "tagID", [
		"dataID" => $dataID
	]);
	if (sizeof($tags) >= 1) {
		foreach ($tags as $tag) {
			$tg = $database->get('jk_data_tags', ['title'], [
				"id" => $tag
			]);
			if (isset($tg['title'])) {
				$back .= $tg['title'] . ', ';
			}
			array_push($tagback, $tg['title']);
		}
		$back = rtrim($back, ', ');
	}
	if ($type == 'string') {
		return $back;
	} else {
		return $tagback;
	}
}

function getDataTh($dataID, $thID)
{
	global $database;
	$has = $database->get('jk_data_th', '*', [
		"AND" => [
			"dataID" => $dataID,
			"thID" => $thID,
		]
	]);
	if ($has['id']) {
		return $has['fileID'];
	} else {
		return false;
	}
}

function textView($text)
{

	$scanned_directory = array_diff(scandir(JK_DIR_MODULES), array('..', '.'));
	if (sizeof($scanned_directory) >= 1) {
		foreach ($scanned_directory as $elem) {
			if (is_dir(JK_DIR_MODULES . $elem)) {
				if (file_exists(JK_DIR_MODULES . $elem . DS . 'head.php')) {
					require_once(JK_DIR_MODULES . $elem . DS . 'head.php');
				}
			}
		}
	}
	$filegetin = $text;
	preg_match_all('/\[textCode\](.*?)\[\/textCode\]/s', $filegetin, $matches);
	if (isset($matches[1]) && sizeof($matches[1]) >= 1) {
		foreach ($matches[1] as $match) {
			parse_str(html_entity_decode($match), $get_array);
			if (is_array($get_array) && isset($get_array['name'])) {
				if (function_exists('textCode_' . $get_array['name'])) {
					$name = $get_array['name'];
					unset($get_array['name']);
					$var = call_user_func_array('textCode_' . $name, [$get_array]);
					$text = str_replace($matches[0][0], $var, $text);
				}
			}

		}
	}
	return $text;
}