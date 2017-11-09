<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Ushahidi Post Varchar Repository
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

use Ushahidi\Core\Entity\PostValue;
use Ushahidi\Core\Entity\PostValueRepository;

class Ushahidi_Repository_Post_Datetime extends Ushahidi_Repository_Post_Value
{
	// Ushahidi_Repository
	protected function getTable()
	{
		return 'post_datetime';
	}

	// Ushahidi_Repository
	public function getEntity(Array $data = null)
	{
		// Convert post_date to DateTime
		$value = date_create($data['value'], new \DateTimeZone('UTC'));
		$data['value'] = $value ? $value->format(DateTime::W3C) : null;
		return new PostValue($data);
	}

	private function convertToMysqlFormat($value) {
		$value = date_create($value, new \DateTimeZone('UTC'));
		$value->setTimezone(new \DateTimeZone('UTC'));

		return $value->format("Y-m-d H:i:s");
	}

	public function createValue($value, $form_attribute_id, $post_id)
	{
		$value = $this->convertToMysqlFormat($value);
		return parent::createValue($value, $form_attribute_id, $post_id);
	}

	public function updateValue($id, $value)
	{
		$value = $this->convertToMysqlFormat($value);
		return parent::updateValue($id, $value);
	}
}
